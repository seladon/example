<?php


namespace Architecture\Infrastructure\Shared\HttpClient;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class HttpClientService
 *
 * @package App\Infrastructure\Shared\HttpClient
 */
class HttpClientService implements HttpClientInterface
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $apiLogger;

    /**
     * HttpClientService constructor.
     *
     * @param LoggerInterface $apiLogger
     */
    public function __construct(
        LoggerInterface $apiLogger
    ) {
        $this->client = new Client();
        $this->apiLogger = $apiLogger;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $this->apiLogger->info(
            'External Api Request',
            [
                'method' => $method,
                'url' => $url,
                'options' => $options //todo remove
            ]
        );
        return $this->client->request($method, $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->request('GET', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->request('POST', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->request('PUT', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function patch(string $url, array $options = []): ResponseInterface
    {
        return $this->request('PATCH', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->request('DELETE', $url, $options);
    }

    /**
     * @param string $message
     * @param ResponseInterface|null $response
     */
    public function logErrorResponse(string $message, ?ResponseInterface $response): void
    {
        if ($response) {
            $this->apiLogger->error(
                $message,
                [
                    'statusCode' => $response->getStatusCode(),
                    'response' => $response->getBody()->getContents()
                ]
            );
        }

    }
}
