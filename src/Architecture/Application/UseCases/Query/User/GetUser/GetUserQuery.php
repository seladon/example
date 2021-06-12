<?php
declare(strict_types=1);

namespace Architecture\Application\UseCases\Query\User\GetUser;

use Architecture\Application\UseCases\Query\QueryInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GetUserQuery
 *
 * @package Architecture\Application\UseCases\Query\User\GetUser
 */
class GetUserQuery implements QueryInterface
{

    /**
     * @Assert\Type(type = "int")
     * @Assert\NotBlank
     * @var string
     */
    public $userId;


    /**
     * GetUserQuery constructor.
     * @param int $userId
     */
    public function __construct(
        int $userId
    )
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}