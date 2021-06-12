<?php

namespace Architecture\Infrastructure\Shared\Core\Domain;


use DateTime as PHPDateTime;
use DateTimeZone;
use Exception;
use JsonSerializable;

/**
 * Class DateTime
 *
 * @package Architecture\Infrastructure\Shared\Domain
 */
class DateTime implements JsonSerializable
{
    public const FORMAT_STRING = 'Y-m-d\TH:i:s.uP';

    private PHPDateTime $dateTime;

    private string $serializationDateFormat = "d MMMM y";

    public function __construct(PHPDateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public static function now(): self
    {
        return new self(
            PHPDateTime::createFromFormat(
                'U.u',
                sprintf('%.6F', microtime(true)),
                new DateTimeZone('UTC')
            )->setTimezone(new DateTimeZone('Europe/Moscow'))
        );
    }

    /**
     * @param string $dateTimeString
     *
     * @return DateTime
     * @throws Exception
     */
    public static function fromString(string $dateTimeString): self
    {
        return new self(new PHPDateTime($dateTimeString));
    }

    /**
     * @param string $dateTimeString
     *
     * @return DateTime
     * @throws Exception
     */
    public static function fromUtc(string $dateTimeString): self
    {
        return new self((new PHPDateTime($dateTimeString, new DateTimeZone('UTC')))->setTimezone(new DateTimeZone('Europe/Moscow')));
    }

    /**
     * @param string $timestamp
     *
     * @return DateTime
     * @throws Exception
     */
    public static function fromTimestamp(string $timestamp): self
    {
        $dateTime = new PHPDateTime();
        $dateTime->setTimestamp($timestamp);
        return new self($dateTime);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public static function new(): self
    {
        return new self(new PHPDateTime());
    }

    /**
     * @param self $dateTime
     *
     * @return bool
     */
    public function equals(self $dateTime): bool
    {
        return $this->__toString() === $dateTime->__toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNative()->format($this->serializationDateFormat);
    }

    /**
     * @param self $dateTime
     *
     * @return bool
     */
    public function comesAfter(self $dateTime): bool
    {
        return $this->dateTime > $dateTime->dateTime;
    }


    /**
     * @return string
     */
    public function toYearWeekString(): string
    {
        return $this->dateTime->format('oW');
    }

    /**
     * @return PHPDateTime
     */
    public function toNative(): PHPDateTime
    {
        return $this->dateTime;
    }

    public function jsonSerialize()
    {
        return $this->__toString();
    }

    /**
     * @param string $serializationDateFormat
     *
     * @return DateTime
     */
    public function withSerializationDateFormat(string $serializationDateFormat): self
    {
        $this->serializationDateFormat = $serializationDateFormat;
        return $this;
    }
}
