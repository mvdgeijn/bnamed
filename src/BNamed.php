<?php

namespace Mvdgeijn\BNamed;

use Mvdgeijn\BNamed\Responses\GetReactivatableDomainsResponse;
use Mvdgeijn\BNamed\Responses\Response;
use Mvdgeijn\BNamed\Responses\TLDAllResponse;

class BNamed implements BNamedInterface
{
    /**
     * The version of this package. This is being used for the user-agent header.
     */
    public const CLIENT_VERSION = 'v1.2.0';

    /**
     * @var BNamed The client instance.
     */
    private static $_instance;

    /**
     * @var string The bNamed host. Must include protocol (http, https, etc.).
     */
    private string $host;

    /**
     * @var string The bNamed API username
     */
    private string $username;

    /**
     * @var string The bNamed API password
     */
    private string $password;

    /**
     * @var BNamedInterface The bNamed Connector to make calls.
     */
    private Connector $connector;

    /**
     * bNamed Client constructor.
     *
     * @param string|null             $host      (optional) The bNamed host. Must include protocol (http, https, etc.).
     * @param string|null             $username  (optional) The bNamed username.
     * @param string|null             $password  (optional) The bNamed password.
     * @param Connector|null $connector (optional) The Connector to make calls.
     */
    public function __construct(
        ?string $host = null,
        ?string $username = null,
        ?string $password = null,
        ?Connector $connector = null
    ) {
        if (self::$_instance === null) {
            self::$_instance = $this;
        }

        if ($host !== null) {
            $this->host = $host;
        }

        if ($username !== null) {
            $this->username = $username;
        }

        if ($password !== null) {
            $this->password = $password;
        }

        $this->connector = $connector ?? new Connector($this);
    }

    /**
     * Set the configured connector instance instead of the default one.
     *
     * @param Connector $connector The connector instance to use.
     *
     * @return $this The current BNamed class.
     */
    public function setConnector(Connector $connector): self
    {
        $this->connector = $connector;

        return $this;
    }

    /**
     * Configure a new connection to a bNamed server.
     *
     * @param string $host   The bNamed host. Must include protocol (http, https, etc.).
     *
     * @return BNamedInterface The created bNamed client.
     */
    public function connect(string $host): BNamedInterface
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the client config items.
     *
     * @return array Array containing the client config items.
     */
    public function getConfig(): array
    {
        return [
            'host'      => $this->host,
            'username'  => $this->username,
            'password'  => $this->password
        ];
    }

    /**
     * @return TLDAllResponse
     */
    public function TLDAll(): TLDAllResponse
    {
        return $this->connector->get('TLDAll');
    }

    /**
     * @param $domains
     * @return Response
     */
    public function check($domains): Response
    {
        return $this->connector->get('Check', ["DomainList" => implode(",", $domains)]);
    }

    /**
     * @return GetReactivatableDomainsResponse
     */
    public function getReactivatableDomains(): GetReactivatableDomainsResponse
    {
        return $this->connector->get('GetReactivatableDomains');
    }

    /**
     * @param string $domainName
     * @return Response
     */
    public function getDomain( string $domainName ): Response
    {
        [$sld, $tld] = explode('.', $domainName, 2);

        return $this->connector->get('GetDomain', ['SLD' => $sld, 'TLD' => $tld]);
    }
}
