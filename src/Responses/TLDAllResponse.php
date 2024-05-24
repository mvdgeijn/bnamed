<?php

namespace Mvdgeijn\BNamed\Responses;

class TLDAllResponse extends Response
{
    public array $data = [];
    public function __construct( \SimpleXMLElement $element )
    {
        foreach( $element->Result->TLDs->children() as $tld ) {
            $this->data[] = new TLDResponse( $tld );
        }
    }
}
