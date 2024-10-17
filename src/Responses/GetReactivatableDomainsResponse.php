<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class GetReactivatableDomainsResponse extends Response
{
    protected function parseResult( SimpleXMLElement $result ): self
    {
        foreach ($result->children() as $result) {
            $item = new ReactivatableDomain(
                (string)$result->SLD,
                (string)$result->TLD,
                (string)$result->ReactivatableUntil,
                (string)$result->ReactivatableUntil['lastReactivationPhase'] === 'True',
                (string)$result->Fee
            );

            $this->items->push($item);
        }

        return $this;
    }

    protected function sortResult(): self
    {
        $this->items->sort( function( $a, $b ) {
            return strcmp( $a->getDomain(), $b->getDomain() );
        });

        return $this;
    }
}
