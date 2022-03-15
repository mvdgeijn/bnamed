<?php

namespace Mvdgeijn\BNamed\Responses;

use SimpleXMLElement;

class DNSSecDetailResponse implements ResponseInterface
{
    private int $algorithm;

    private string $algorithmString;

    public static function parse(SimpleXMLElement $element)
    {
        return ( new DNSSecDetailResponse() )
            ->setAlgorithm( (int)$element->algorith )
            ->setAlgorithmString( (string)$element->algorithmString );
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
