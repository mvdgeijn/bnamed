<?php

namespace Mvdgeijn\BNamed;

interface BNamedInterface
{
    /**
     * Configure a new connection to a bNamed server.
     *
     * @param string $host   The bNamed host. Must include protocol (http, https, etc.).
     * @param int    $port   The bNamed API Port.
     * @param string $server The bNamed server to use.
     *
     * @return BNamed The created bNamed client.
     */
    public function connect(string $host): self;

    /**
     * Return the configuration
     *
     * @return array
     */
    public function getConfig(): array;
}
