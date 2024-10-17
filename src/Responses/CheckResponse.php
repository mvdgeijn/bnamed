<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class CheckResponse extends Response
{
    const REGISTERED = '1';
    const UNREGISTERED = '0';

    protected function parseResult(SimpleXMLElement $result): Response
    {
        foreach( $result->children() as $checkResult ) {
            $this->items->push(
                [
                    'sld' => (string)$checkResult->SLD,
                    'tld' => (string)$checkResult->TLD,
                    'domain' => $checkResult->SLD . '.' . $checkResult->TLD,
                    'code' => (string)$checkResult->AvailabilityCode,
                    'message' => (string)$checkResult->AvailabilityText
                ]
            );
        }

        $this->items->keyBy( 'domain' );

        return $this;
    }
}
