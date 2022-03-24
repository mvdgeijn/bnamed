<?php
/*
 * Copyright (c) 2022 by bHosted.nl B.V.  - All rights reserved
 */

namespace Mvdgeijn\BNamed\Factories;

use Mvdgeijn\BNamed\Responses\TLDsResponse;

class Response
{
    public static function parse( $result ): array
    {
        $data = [];
        foreach( $result as $key => $value )
        {
            if( method_exists( Response::class, $key ) )
                return Response::TLDs( $value );

            if( strcmp( \Str::substr($key, 0, 4 ), "Name" ) == 0 ) {
                $data[$value->SLD . "." . $value->TLD] = (int)$value->AvailabilityCode;
            }
        }

        return $data;
    }

    public static function TLDs( \SimpleXMLElement $element )
    {
        return TLDsResponse::parse( $element );
    }

    public static function __callStatic(string $name, array $arguments)
    {
        dd( $name, $arguments );
    }
}
