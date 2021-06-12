<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;


/**
 * Class DomainMessage
 *
 * @package Architecture\Infrastructure\Shared\Domain
 */
class DomainMessage
{
    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var DateTime
     */
    private $recordedOn;

    /**
     * @param mixed $payload
     * @param DateTime $recordedOn
     */
    public function __construct($payload, DateTime $recordedOn)
    {
        $this->payload = $payload;
        $this->recordedOn = $recordedOn;
    }

    /**
     * @param mixed $payload
     *
     * @return DomainMessage
     */
    public static function recordNow($payload): self
    {
        return new self($payload, DateTime::now());
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return DateTime
     */
    public function getRecordedOn(): DateTime
    {
        return $this->recordedOn;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return strtr(get_class($this->payload), '\\', '.');
    }
}
