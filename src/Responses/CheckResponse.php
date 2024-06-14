<?php

namespace Mvdgeijn\BNamed\Responses;

class CheckResponse extends Response
{
    const REGISTERED = '1';
    const UNREGISTERED = '0';

    public array $data = [];
    public function __construct( \SimpleXMLElement $element )
    {
        foreach( $element->Result->children() as $result ) {
            $this->data[$result->SLD . '.' . $result->TLD] = [
                'sld' => (string)$result->SLD,
                'tld' => (string)$result->TLD,
                'domain' => $result->SLD .'.' .$result->TLD,
                'code' => (string)$result->AvailabilityCode,
                'message' => (string)$result->AvailabilityText,
            ];
        }
    }
}
