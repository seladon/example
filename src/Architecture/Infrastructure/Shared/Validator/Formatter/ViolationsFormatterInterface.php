<?php


namespace Architecture\Infrastructure\Shared\Validator\Formatter;


use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Interface FormatterInterface
 *
 * @package App\Infrastructure\Shared\Validator\Formatter
 */
interface ViolationsFormatterInterface
{
    /**
     * Return serialized violations representation for log
     *
     * @param ConstraintViolationListInterface $constraintViolationList
     *
     * @return string
     */
    public function formatViolations(ConstraintViolationListInterface $constraintViolationList): string;
}