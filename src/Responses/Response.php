<?php

namespace Mvdgeijn\BNamed\Responses;

use Illuminate\Support\Collection;
use SimpleXMLElement;
use Traversable;
use IteratorAggregate;

class Response implements IteratorAggregate
{
    private string $command;
    private int $errorCode;
    private string $errorText;
    private bool $done;
    private float $time;

    protected Collection $items;

    /**
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        // Parse and assign the main data
        $this->command = (string) $xml->Command;
        $this->errorCode = (int) $xml->ErrorCode;
        $this->errorText = (string) $xml->ErrorText;
        $this->done = (string) $xml->Done === 'True';
        $this->time = (float) $xml->Time;

        // Initialize the items collection
        $this->items = collect();

        // Parse the result
        if( property_exists( $xml, 'Result' ) ) $this->parseResult( $xml->Result );

        // Sort the result
        $this->sortResult();
    }

    protected function parseResult( SimpleXMLElement $result ): self
    {
        return $this;
    }

    protected function sortResult( ): self
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorText(): string
    {
        return $this->errorText;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
    }

    /**
     * @return float
     */
    public function getTime(): float
    {
        return $this->time;
    }

    // Fluent Setters

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand(string $command): self
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @param int $errorCode
     * @return $this
     */
    public function setErrorCode(int $errorCode): self
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @param string $errorText
     * @return $this
     */
    public function setErrorText(string $errorText): self
    {
        $this->errorText = $errorText;
        return $this;
    }

    /**
     * @param bool $done
     * @return $this
     */
    public function setDone(bool $done): self
    {
        $this->done = $done;
        return $this;
    }

    /**
     * @param float $time
     * @return $this
     */
    public function setTime(float $time): self
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasCollection(): bool
    {
        return $this->items->count() > 0;
    }

    /**
     * Implement the getIterator method to make the class iterable over the items.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return $this->items->getIterator();
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
}
