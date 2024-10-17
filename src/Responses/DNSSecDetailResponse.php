<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class DNSSecDetailResponse
{
    private int $algorithm;

    private string $algorithmString;

    public function __construct(SimpleXMLElement $element)
    {
        $this->algorith = (int)$element->algorith;
        $this->algorithString = (string)$element->algorithmString;
    }

    /**
     * @return int
     */
    public function getAlgorithm(): int
    {
        return $this->algorithm;
    }

    /**
     * @param int $algorithm
     */
    public function setAlgorithm(int $algorithm): self
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlgorithmString(): string
    {
        return $this->algorithmString;
    }

    /**
     * @param string $algorithmString
     */
    public function setAlgorithmString(string $algorithmString): self
    {
        $this->algorithmString = $algorithmString;

        return $this;
    }
}
