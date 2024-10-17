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
            $this->items->push( new CheckDomain( $checkResult->SLD, $checkResult->TLD, $checkResult->AvailabilityCode, $checkResult->AvailabilityText ) );
        }

        $this->items->keyBy( fn( CheckDomain $checkDomain ) => $checkDomain->getDomain() );

        return $this;
    }
}
