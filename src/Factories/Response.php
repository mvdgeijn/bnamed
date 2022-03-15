<?php
/*
 * Copyright (c) 2022 by bHosted.nl B.V.  - All rights reserved
 */

namespace Mvdgeijn\BNamed\Factories;

use Mvdgeijn\BNamed\Responses\TLDsResponse;

class Response
{
    public static function TLDs( \SimpleXMLElement $element )
    {
        return TLDsResponse::parse( $element );
    }
}
