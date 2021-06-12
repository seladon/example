<?php


namespace Architecture\Domain\User\Event;


use Architecture\Infrastructure\Shared\Core\Serializer\Serializable;

/**
 * Class UserWasAdd
 * @package Architecture\Domain\Cart\Event
 */
class UserWasAdd implements Serializable
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * UserWasAdd constructor.
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param array $data
     * @return UserWasAdd
     */
    public static function deserialize(array $data): UserWasAdd
    {
        return new self($data['id']);
    }

    /**
     * @return string[]
     */
    public function serialize(): array
    {
        return [
            'id' => $this->userId
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}