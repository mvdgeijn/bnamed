<?php

namespace Mvdgeijn\BNamed\Responses;

use Carbon\Carbon;

class ReactivatableDomain
{
    private string $sld;
    private string $tld;
    private Carbon $reactivatableUntil;
    private bool $lastReactivationPhase;
    private string $fee;

    /**
     * Constructor for DomainData.
     *
     * @param string $sld
     * @param string $tld
     * @param string $reactivatableUntil The date as a string, will be converted to Carbon.
     * @param bool $lastReactivationPhase
     * @param string $fee
     */
    public function __construct(string $sld, string $tld, string $reactivatableUntil, bool $lastReactivationPhase, string $fee)
    {
        $this->sld = $sld;
        $this->tld = $tld;
        // Convert the date string to a Carbon instance
        $this->reactivatableUntil = Carbon::createFromFormat('d/m/Y', $reactivatableUntil);
        $this->lastReactivationPhase = $lastReactivationPhase;
        $this->fee = $fee;
    }

    // Getters
    public function getSld(): string
    {
        return $this->sld;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function getDomain(): string
    {
        return $this->sld . '.' . $this->tld;
    }

    /**
     * Get the reactivatable until date as a Carbon instance.
     *
     * @return Carbon
     */
    public function getReactivatableUntil(): Carbon
    {
        return $this->reactivatableUntil;
    }

    public function isLastReactivationPhase(): bool
    {
        return $this->lastReactivationPhase;
    }

    public function getFee(): string
    {
        return $this->fee;
    }

    // Fluent Setters
    public function setSld(string $sld): self
    {
        $this->sld = $sld;
        return $this;
    }

    public function setTld(string $tld): self
    {
        $this->tld = $tld;
        return $this;
    }

    /**
     * Set the reactivatable until date.
     *
     * @param string|Carbon $reactivatableUntil The date as a string or Carbon instance.
     * @return self
     */
    public function setReactivatableUntil($reactivatableUntil): self
    {
        if (is_string($reactivatableUntil)) {
            $this->reactivatableUntil = Carbon::createFromFormat('d/m/Y', $reactivatableUntil);
        } else {
            $this->reactivatableUntil = $reactivatableUntil;
        }
        return $this;
    }

    public function setLastReactivationPhase(bool $lastReactivationPhase): self
    {
        $this->lastReactivationPhase = $lastReactivationPhase;
        return $this;
    }

    public function setFee(string $fee): self
    {
        $this->fee = $fee;
        return $this;
    }
}
