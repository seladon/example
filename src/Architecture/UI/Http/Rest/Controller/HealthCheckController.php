<?php

declare(strict_types=1);

namespace Architecture\UI\Http\Rest\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/health")
 */
class HealthCheckController
{
    /**
     * @Route("/test", name="health_test", methods={"GET"})
     */
    public function test(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
