<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class TLDResponse extends Response
{
    public string $tld;

    public array $region;

    public array $dnssec;

    public string $registrationPeriodAfterTransfer;

    public array $registrationPeriod;

    public array $extendPeriod;

    public array $transferPeriod;

    public int $minimumLength;

    public array $prices = [];

    public function __construct(SimpleXMLElement $element)
    {
        $this->tld = (string)$element->TLD;

        foreach( $element->DNSSec->children() as $dnssec )
            $this->dnssec[] = new DNSSecDetailResponse( $dnssec );

        $this->region = explode(",", (string)$element->Regio_EN);

        $this->registrationPeriod = explode(",", (string)$element->Registration_Period);

        $this->registrationPeriodAfterTransfer = (string)$element->RegistrationPeriodAfterTransfer;

        $this->extendPeriod = explode(",", (string)$element->Extend_Period);

        $this->transferPeriod = explode(",", (string)$element->Transfer_Period);

        $this->minimumLength = (int)$element->Minimum_Length;

        foreach( (array)$element->Prices as $key => $value )
            $this->prices[$key] = str_replace(",", ".", $value );
    }
}
