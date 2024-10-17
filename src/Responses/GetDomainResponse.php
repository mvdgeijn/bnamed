<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class GetDomainResponse extends Response
{
    public string $sld;
    public string $tld;
    public string $statusCode;
    public string $statusText;
    public array $licensee;
    public array $admin;
    public array $onSite;
    public string $dnsType;
    public array $dnsList;
    public array $dnsIpList;
    public string $authKey;
    public bool $transferLock;
    public string $expiration;
    public string $renewalDeadline;
    public string $registrationISO;
    public string $extendType;
    public bool $trustee;
    public array $dnssecRecords = [];
    public string $orderID;
    public ?string $label;
    public ?string $notes;

    /**
     * Parse the result data from the XML.
     *
     * @param SimpleXMLElement $result
     * @return self
     */
    protected function parseResult(SimpleXMLElement $result): self
    {
        $this->sld = (string) $result->SLD;
        $this->tld = (string) $result->TLD;
        $this->statusCode = (string) $result->StatusCode;
        $this->statusText = (string) $result->StatusText;

        // Parse Licensee, Admin, and OnSite contacts
        $this->licensee = $this->parseContact($result->Licensee);
        $this->admin = $this->parseContact($result->Admin);
        $this->onSite = $this->parseContact($result->OnSite);

        // DNS and related data
        $this->dnsType = (string) $result->DNSType;
        $this->dnsList = explode(',', (string) $result->DNSList);
        $this->dnsIpList = explode(',', (string) $result->DNSIPList);
        $this->authKey = (string) $result->AuthKey;
        $this->transferLock = (string) $result->TransferLock === 'true';
        $this->expiration = (string) $result->Expiration;
        $this->renewalDeadline = (string) $result->RenewalDeadline;
        $this->registrationISO = (string) $result->RegistrationISO;
        $this->extendType = (string) $result->ExtendType;
        $this->trustee = (string) $result->Trustee === 'false';

        // Parse DNSSEC records
        if (property_exists($result, 'DNSSec')) {
            foreach ($result->DNSSec->children() as $dnssecRecord) {
                $this->dnssecRecords[] = $this->parseDnssecRecord($dnssecRecord);
            }
        }

        $this->orderID = (string) $result->OrderID;
        $this->label = (string) $result->Label ?? null;
        $this->notes = (string) $result->Notes ?? null;

        return $this;
    }

    /**
     * Parse contact details from Licensee, Admin, or OnSite fields.
     *
     * @param SimpleXMLElement $contact
     * @return array
     */
    protected function parseContact(SimpleXMLElement $contact): array
    {
        return [
            'contactNr' => (string) $contact->ContactNr,
            'firstName' => (string) $contact->FirstName,
            'lastName' => (string) $contact->LastName,
            'company' => (string) $contact->Company,
            'street' => (string) $contact->Street,
            'streetNr' => (string) $contact->StreetNr,
            'postcode' => (string) $contact->Postcode,
            'residence' => (string) $contact->Residence,
            'country' => (string) $contact->Country,
            'phone' => (string) $contact->Phone,
            'email' => (string) $contact->EMail,
            'vatNumber' => (string) $contact->VATNumber ?? null,
            'language' => (string) $contact->Language,
        ];
    }

    /**
     * Parse a DNSSEC record from the XML.
     *
     * @param SimpleXMLElement $dnssecRecord
     * @return array
     */
    protected function parseDnssecRecord(SimpleXMLElement $dnssecRecord): array
    {
        return [
            'keytag' => (string) $dnssecRecord->Keytag,
            'algorithm' => (string) $dnssecRecord->Algorithm,
            'algorithmString' => (string) $dnssecRecord->AlgorithmString,
            'publicKey' => (string) $dnssecRecord->PublicKey,
            'digest' => (string) $dnssecRecord->Digest,
            'digestType' => (string) $dnssecRecord->DigestType,
        ];
    }
}
