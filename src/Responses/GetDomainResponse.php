<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class GetDomainResponse
{
    public string $sld;

    public string $tld;

    public string $statusCode;

    public string $statusText;

    public string $dnsType;

    public array $dnsServers;

    public array $dnsIpList;

    public string $authKey;

    public bool $transferLock;

    public \Carbon $expiration;

    public \Carbon $renewlDeadline;

    public \Carbon $registrationISO;

    public string $extendType;

    public bool $trustee;

    public function __construct(SimpleXMLElement $element)
    {
        $this->tld = (string)$element->Result->TLD;

        $this->sld = (string)$element->Result->SLD;

        $this->statusCode = (string)$element->Result->StatusCode;

        $this->statusText = (string)$element->Result->StatusText;

        $this->dnsType = (string)$element->Result->DNSType;

        $this->authKey = (string)$element->Result->AuthKey;

        $this->trustee = ( (string)$element->Result->Trustee == "true" );

        $this->transferLock = ( (string)$element->Result->TransferLock == "true");

        $this->expiration = \Carbon::parseFromLocale( (string)$element->Result->Expiration );

        $this->renewlDeadline = \Carbon::parseFromLocale( (string)$element->Result->RenewalDeadline );

        $this->registrationISO = \Carbon::parseFromLocale( (string)$element->Result->RegistrationISO );

        $this->dnsServers = explode(",", (string)$element->Result->DNSList );

        $this->dnsIpList = explode( ",", (string)$element->Result->DNSIPList );
    }
}
