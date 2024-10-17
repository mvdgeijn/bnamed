<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class TLDAllResponse extends Response
{
    protected function parseResult(SimpleXMLElement $result): self
    {
        foreach( $result->TLDs->children() as $tld ) {
            $this->items->push(
                new TLDResponse( $tld )
            );
        }

        return $this;
    }
}
