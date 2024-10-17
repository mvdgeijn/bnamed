<?php

namespace Mvdgeijn\BNamed\Responses;

class CheckDomain
{
    /**
     * @param string $sld
     * @param string $tld
     * @param string $code
     * @param string $message
     */
    public function __construct(
        private string $sld,
        private string $tld,
        private string $code,
        private string $message
    ) {
    }

    /**
     * @return string
     */
    public function getDomain():string
    {
        return $this->sld . '.' . $this->tld;
    }

    /**
     * @return string
     */
    public function getSld(): string
    {
        return $this->sld;
    }

    /**
     * @return string
     */
    public function getTld(): string
    {
        return $this->tld;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}