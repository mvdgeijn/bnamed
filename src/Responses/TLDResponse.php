<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class TLDResponse implements ResponseInterface
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

    public static function parse(SimpleXMLElement $element)
    {
        $rsp = new TLDResponse();

        $rsp->tld = (string)$element->TLD;

        foreach( $element->DNSSec->children() as $dnssec )
            $rsp->dnssec[] = DNSSecDetailResponse::parse( $dnssec );

        $rsp->region = explode(",", (string)$element->Regio_EN);

        $rsp->registrationPeriod = explode(",", (string)$element->Registration_Period);

        $rsp->registrationPeriodAfterTransfer = (string)$element->RegistrationPeriodAfterTransfer;

        $rsp->extendPeriod = explode(",", (string)$element->Extend_Period);

        $rsp->transferPeriod = explode(",", (string)$element->Transfer_Period);

        $rsp->minimumLength = (int)$element->Minimum_Length;

        foreach( (array)$element->Prices as $key => $value )
            $rsp->prices[$key] = str_replace(",", ".", $value );

        return $rsp;
    }
}
