<?php

declare(strict_types=1);


namespace Architecture\UI\Http\Rest\Controller\Users;

use Architecture\Application\UseCases\Command\User\AddUser\CreateUserCommand;
use Architecture\Application\UseCases\Query\User\GetUser\GetUserQuery;
use Architecture\UI\Http\Rest\Controller\CommandQueryController;
use OpenTracing\GlobalTracer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsersController
 * @Route("/users")
 *
 * @package Architecture\UI\Http\Rest\Controller\Users
 */
class UsersController extends CommandQueryController
{

    /**
     * @Route("/{userId}", methods={"GET"}, requirements={"userId"="\d+"})
     * @return JsonResponse
     */
    public function getUserById(GetUserQuery $getUserQuery) : Response
    {
        $this->validate($getUserQuery);
        return $this->json($this->ask($getUserQuery));
    }

    /**
     * @Route("/create", methods={"POST"})
     * @return JsonResponse
     */
    public function createUser(CreateUserCommand $createUserCommand) : Response
    {
        $span = GlobalTracer::get()->startActiveSpan(__FUNCTION__);
        $this->validate($createUserCommand);
        $result = $this->handle($createUserCommand);
        $span->close();
        return $this->json(['userId' => $result], Response::HTTP_CREATED);
    }
}