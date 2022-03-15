<?php

namespace Mvdgeijn\BNamed;

use Mvdgeijn\BNamed\Factories\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as PsrResponse;
use GuzzleHttp\Psr7\Utils;
use Mvdgeijn\BNamed\Exceptions\BNamedException;
use Mvdgeijn\BNamed\Transformers\Transformer;

class Connector implements ConnectorInterface
{
    /**
     * @var GuzzleClient The Guzzle client.
     */
    private $httpClient;

    /**
     * @var BNamed The API client.
     */
    private $bnamed;

    /**
     * Connector constructor.
     *
     * @param BNamed|null     $client             The client instance.
     * @param HandlerStack|null $guzzleHandlerStack Optional Guzzle handlers.
     */
    public function __construct(BNamed $client, ?HandlerStack $guzzleHandlerStack = null)
    {
        $this->bnamed = $client;

        // Don't let Guzzle throw exceptions, as it is handled by this class.
        $this->httpClient = new GuzzleClient([
                'exceptions' => false,
                'handler' => $guzzleHandlerStack
            ]);
    }

    /**
     * Perform a GET request and return the parsed body as response.
     *
     * @param string $command
     * @param array|null $payload (optional)
     *
     * @return array The response body.
     */
    public function get($command, ?array $params = null): array
    {
        $params['command'] = $command;

        return $this->makeCall('GET', $command, $params);
    }

    /**
     * Perform a POST request and return the parsed body as response.
     *
     * @param Transformer $params The payload to post.
     *
     * @return mixed[] The response body.
     */
    public function post(Transformer $params): array
    {
        return $this->makeCall('POST',json_encode($params->transform()));
    }

    /**
     * Make the call to the BNamed API.
     *
     * @param string        $method  The method to use for the call.
     * @param string        $command
     * @param string|null   $params (Optional) The payload to include.
     *
     * @return mixed[] The decoded JSON response.
     */
    protected function makeCall(string $method, string $command, ?array $params = null): array
    {
        $params['command'] = $command;

        $url = $this->buildUrl( $params );
        $headers = $this->getDefaultHeaders();

        $request = new Request($method, $url,$headers );

        $response = $this->httpClient->send($request,['http_errors' => false, 'verify' => false]);

        return $this->getResult($response);
    }

    /**
     * Parse the call response.
     *
     * @param PsrResponse $response The call response.
     *
     * @throws BNamedException
     */
    protected function getResult(PsrResponse $response)
    {
        if( $response->getStatusCode() == 200 ) {
            $xml = simplexml_load_string($response->getBody()->getContents() );

            if( (int)$xml->ErrorCode == 0 ) {
                foreach( $xml->Result->children() as $key => $value ) {
                    if( method_exists( Response::class, $key) )
                        return Response::$key( $value );
                }
            } else {
                throw new BNamedException("bNamed XML error response code " . $xml->ErrorCode . ": " . $xml->ErrorText );
            }
        } else {
            throw new BNamedException("bNamed API error response code " . $response->getStatusCode() );
        }
    }

    /**
     * Get the complete URL for making API requests.
     *
     * @param ?array $params
     *
     * @return string The complete URL.
     */
    protected function buildUrl(?array $params = null ): string
    {
        $config = $this->bnamed->getConfig();

        $params['UID'] = $config['username'];
        $params['Key'] = $config['password'];

        return $config['host'] . "?" . http_build_query($params);
    }

    /**
     * Get the headers that are default for each request.
     *
     * @return string[] The headers.
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'mvdgeijn-bnamed/'.BNamed::CLIENT_VERSION,
        ];
    }
}
