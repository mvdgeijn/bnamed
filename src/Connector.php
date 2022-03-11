<?php

namespace Mvdgeijn\BNamed;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as PsrResponse;
use GuzzleHttp\Psr7\Utils;

class Connector
{
    /**
     * @var GuzzleClient The Guzzle client.
     */
    private $httpClient;

    /**
     * @var Powerdns The API client.
     */
    private $bnamed;

    /**
     * Connector constructor.
     *
     * @param Powerdns|null     $client             The client instance.
     * @param HandlerStack|null $guzzleHandlerStack Optional Guzzle handlers.
     */
    public function __construct(BNamed $client, ?HandlerStack $guzzleHandlerStack = null)
    {
        $this->powerdns = $client;

        // Don't let Guzzle throw exceptions, as it is handled by this class.
        $this->httpClient = new GuzzleClient(['exceptions' => false, 'handler' => $guzzleHandlerStack]);
    }

    /**
     * Perform a GET request and return the parsed body as response.
     *
     * @param string $urlPath The URL path.
     *
     * @return mixed[] The response body.
     */
    public function get($command, $payload): array
    {
        $payload['command'] = $command;

        return $this->makeCall('GET', $payload);
    }

    /**
     * Perform a POST request and return the parsed body as response.
     *
     * @param string      $urlPath The URL path.
     * @param Transformer $payload The payload to post.
     *
     * @return mixed[] The response body.
     */
    public function post(Transformer $payload): array
    {
        return $this->makeCall('POST',json_encode($payload->transform()));
    }

    /**
     * Make the call to the BNamed API.
     *
     * @param string      $method  The method to use for the call.
     * @param string      $urlPath The URL path.
     * @param string|null $payload (Optional) The payload to include.
     *
     * @throws PowerdnsException   When an unknown response is returned.
     * @throws ValidationException When a validation error is returned.
     *
     * @return mixed[] The decoded JSON response.
     */
    protected function makeCall(string $method, string $command, ?string $payload = null): array
    {
        $payload['command'] = $command;

        $url = $this->buildUrl();
        $headers = $this->getDefaultHeaders();

        $this->powerdns->log()->debug('Sending ['.$method.'] request', compact('url', 'headers', 'payload'));

        $stream = $payload !== null ? Utils::streamFor($payload) : null;
        $request = new Request($method, $url, $headers, $stream);

        $response = $this->httpClient->send($request, ['http_errors' => false]);

        return $this->parseResponse($response);
    }

    /**
     * Parse the call response.
     *
     * @param PsrResponse $response The call response.
     *
     * @throws ValidationException If there was a validation error returned.
     * @throws PowerdnsException   If there was a problem with the request.
     *
     * @return mixed[] The decoded JSON response.
     */
    protected function parseResponse(PsrResponse $response): array
    {
        $this->powerdns->log()->debug('Request completed', ['statusCode' => $response->getStatusCode()]);
        $contents = json_decode($response->getBody()->getContents(), true);

        switch ($response->getStatusCode()) {
            case 200:
            case 201:
                return $contents ?? [];

                break;

            case 204:
                return [];

                break;

            case 422:
                throw new ValidationException($contents['error']);

                break;
        }

        $this->powerdns->log()->debug('Request failed.', ['result_body' => $contents]);
        $error = $contents['error'] ?? 'Unknown bNamed exception.';

        throw new PowerdnsException($error);
    }

    /**
     * Get the complete URL for making API requests.
     *
     * @param string $path The path to append to the "base" URL.
     *
     * @return string The complete URL.
     */
    protected function buildUrl(): string
    {
        $config = $this->bnamed->getConfig();

        return $config['host'];
    }

    /**
     * Get the headers that are default for each request.
     *
     * @return string[] The headers.
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'X-API-Key' => $this->powerdns->getConfig()['apiKey'],
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'mvdgeijn-bnamed/'.BNamed::CLIENT_VERSION,
        ];
    }
}
