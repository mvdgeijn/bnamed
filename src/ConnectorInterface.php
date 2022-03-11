<?php

namespace Mvdgeijn\BNamed;

use Mvdgeijn\BNamed\Transformers\Transformer;

interface ConnectorInterface
{
    /**
     * Perform a GET request and return the parsed body as response.
     *
     * @param string $urlPath The URL path.
     *
     * @return mixed[] The response body.
     */
    public function get($command, ?array $params = null): array;

    /**
     * Perform a POST request and return the parsed body as response.
     *
     * @param Transformer $params The payload to post.
     *
     * @return mixed[] The response body.
     */
    public function post(Transformer $params): array;
}
