<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

/**
 * Class representing the TLD response with its details.
 */
class TLDResponse
{
    /**
     * The top-level domain (TLD).
     *
     * @var string
     */
    public string $tld;

    /**
     * The regions associated with the TLD.
     *
     * @var array
     */
    public array $region;

    /**
     * DNSSEC details for the TLD.
     *
     * @var array
     */
    public array $dnssec;

    /**
     * Registration period after a transfer for the TLD.
     *
     * @var string
     */
    public string $registrationPeriodAfterTransfer;

    /**
     * Registration periods for the TLD.
     *
     * @var array
     */
    public array $registrationPeriod;

    /**
     * Periods for extending the registration of the TLD.
     *
     * @var array
     */
    public array $extendPeriod;

    /**
     * Periods for transferring the TLD.
     *
     * @var array
     */
    public array $transferPeriod;

    /**
     * The minimum length of the domain name for this TLD.
     *
     * @var int
     */
    public int $minimumLength;

    /**
     * Prices associated with the TLD.
     *
     * @var array
     */
    public array $prices = [];

    /**
     * TLDResponse constructor.
     *
     * @param SimpleXMLElement $element The XML element containing the TLD data.
     */
    public function __construct(SimpleXMLElement $element)
    {
        $this->tld = (string)$element->TLD;

        foreach ($element->DNSSec->children() as $dnssec) {
            $this->dnssec[] = new DNSSecDetailResponse($dnssec);
        }

        $this->region = explode(",", (string)$element->Regio_EN);
        $this->registrationPeriod = explode(",", (string)$element->Registration_Period);
        $this->registrationPeriodAfterTransfer = (string)$element->RegistrationPeriodAfterTransfer;
        $this->extendPeriod = explode(",", (string)$element->Extend_Period);
        $this->transferPeriod = explode(",", (string)$element->Transfer_Period);
        $this->minimumLength = (int)$element->Minimum_Length;

        foreach ((array)$element->Prices as $key => $value) {
            $this->prices[$key] = str_replace(",", ".", $value);
        }
    }

    /**
     * Get the TLD.
     *
     * @return string
     */
    public function getTld(): string
    {
        return $this->tld;
    }

    /**
     * Set the TLD.
     *
     * @param string $tld
     * @return self
     */
    public function setTld(string $tld): self
    {
        $this->tld = $tld;
        return $this;
    }

    /**
     * Get the regions associated with the TLD.
     *
     * @return array
     */
    public function getRegion(): array
    {
        return $this->region;
    }

    /**
     * Set the regions associated with the TLD.
     *
     * @param array $region
     * @return self
     */
    public function setRegion(array $region): self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get the DNSSEC details.
     *
     * @return array
     */
    public function getDnssec(): array
    {
        return $this->dnssec;
    }

    /**
     * Set the DNSSEC details.
     *
     * @param array $dnssec
     * @return self
     */
    public function setDnssec(array $dnssec): self
    {
        $this->dnssec = $dnssec;
        return $this;
    }

    /**
     * Get the registration period after transfer.
     *
     * @return string
     */
    public function getRegistrationPeriodAfterTransfer(): string
    {
        return $this->registrationPeriodAfterTransfer;
    }

    /**
     * Set the registration period after transfer.
     *
     * @param string $registrationPeriodAfterTransfer
     * @return self
     */
    public function setRegistrationPeriodAfterTransfer(string $registrationPeriodAfterTransfer): self
    {
        $this->registrationPeriodAfterTransfer = $registrationPeriodAfterTransfer;
        return $this;
    }

    /**
     * Get the registration periods.
     *
     * @return array
     */
    public function getRegistrationPeriod(): array
    {
        return $this->registrationPeriod;
    }

    /**
     * Set the registration periods.
     *
     * @param array $registrationPeriod
     * @return self
     */
    public function setRegistrationPeriod(array $registrationPeriod): self
    {
        $this->registrationPeriod = $registrationPeriod;
        return $this;
    }

    /**
     * Get the extend periods.
     *
     * @return array
     */
    public function getExtendPeriod(): array
    {
        return $this->extendPeriod;
    }

    /**
     * Set the extend periods.
     *
     * @param array $extendPeriod
     * @return self
     */
    public function setExtendPeriod(array $extendPeriod): self
    {
        $this->extendPeriod = $extendPeriod;
        return $this;
    }

    /**
     * Get the transfer periods.
     *
     * @return array
     */
    public function getTransferPeriod(): array
    {
        return $this->transferPeriod;
    }

    /**
     * Set the transfer periods.
     *
     * @param array $transferPeriod
     * @return self
     */
    public function setTransferPeriod(array $transferPeriod): self
    {
        $this->transferPeriod = $transferPeriod;
        return $this;
    }

    /**
     * Get the minimum length of the domain name.
     *
     * @return int
     */
    public function getMinimumLength(): int
    {
        return $this->minimumLength;
    }

    /**
     * Set the minimum length of the domain name.
     *
     * @param int $minimumLength
     * @return self
     */
    public function setMinimumLength(int $minimumLength): self
    {
        $this->minimumLength = $minimumLength;
        return $this;
    }

    /**
     * Get the prices for the TLD.
     *
     * @return array
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * Set the prices for the TLD.
     *
     * @param array $prices
     * @return self
     */
    public function setPrices(array $prices): self
    {
        $this->prices = $prices;
        return $this;
    }
}
