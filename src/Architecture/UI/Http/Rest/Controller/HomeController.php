<?php

namespace Architecture\UI\Http\Rest\Controller;


use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpClient\TraceableHttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;


/**
 * Class HomeController
 * @Route("/")
 *
 * @package Architecture\UI\Http\Rest\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/check", name="check", methods={"GET"})
     */
    public function check(Request $request): JsonResponse
    {
        return $this->json(['check' => 'ok']);
    }

}
