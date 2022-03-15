<?php

namespace Mvdgeijn\BNamed\Responses;

class TLDsResponse implements ResponseInterface
{
    public static function parse( \SimpleXMLElement $element )
    {
        $data = [];

        foreach( $element as $key => $tld ) {
            $data[] = TLDResponse::parse( $tld );
        }
        return $data;
    }
}
