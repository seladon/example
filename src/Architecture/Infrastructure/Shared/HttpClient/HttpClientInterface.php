<?php

declare(strict_types=1);

namespace Architecture\Infrastructure\Shared\HttpClient;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface HttpClientInterface
 *
 * @package Architecture\Infrastructure\Shared\HttpClient
 */
interface HttpClientInterface
{
    /**
     * @param string $method
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws ServerException
     *
     * @throws ClientException
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws ServerException
     *
     * @throws ClientException
     */
    public function get(string $url, array $options = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws ServerException
     *
     * @throws ClientException
     */
    public function post(string $url, array $options = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws ServerException
     *
     * @throws ClientException
     */
    public function put(string $url, array $options = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws ServerException
     *
     * @throws ClientException
     */
    public function delete(string $url, array $options = []): ResponseInterface;

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws ServerException
     *
     * @throws ClientException
     */
    public function patch(string $url, array $options = []): ResponseInterface;

    /**
     * @param string $message
     * @param ResponseInterface|null $response
     *
     * @return mixed
     */
    public function logErrorResponse(string $message, ?ResponseInterface $response): void;
}
