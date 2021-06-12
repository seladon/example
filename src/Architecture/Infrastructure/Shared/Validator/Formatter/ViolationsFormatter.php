<?php


namespace Architecture\Infrastructure\Shared\Validator\Formatter;


use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationsFormatter implements ViolationsFormatterInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * Formatter constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     *
     * @return string
     */
    public function formatViolations(ConstraintViolationListInterface $constraintViolationList): string
    {
        $messages = [];

        /** @var  ConstraintViolationInterface $violation */
        foreach ($constraintViolationList as $violation) {
            $messages[$violation->getPropertyPath()] = $violation->getMessage();
        }
        return $this->serializer->serialize(
            $messages,
            JsonEncoder::FORMAT,
            [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE]
        );
    }
}