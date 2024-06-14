<?php

namespace Mvdgeijn\BNamed\Responses;

class CheckResponse extends Response
{
    public array $data = [];
    public function __construct( \SimpleXMLElement $element )
    {
        foreach( $element->Result->children() as $result ) {
            $this->data[] = $result;
        }
    }
}
