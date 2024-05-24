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

            if( strcmp( \Str::substr($key, 0, 6 ), "Domain") == 0 ) {
                list($symbol, $fee) = explode(' ', (string)$value->Fee);
                $data[$value->SLD . "." . $value->TLD] = [
                    'domain' => (string)$value->SLD . "." . (string)$value->TLD,
                    'reactivatableUntil' => \Carbon::createFromFormat( 'd/m/Y H:i:s', (string)$value->ReactivatableUntil . ' 00:00:00'),
                    'fee' => \Str::replace(',', '.', $fee ),
                    'currency' => $symbol
                ];
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
