<?php
declare(strict_types=1);


namespace Architecture\Infrastructure\Redis\Service;


use Exception;
use Predis\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class RedisService
 * @package Architecture\Infrastructure\Redis\Service
 */
class RedisService
{
    /*** @var Client */
    private Client $client;
    /*** @var LoggerInterface */
    private LoggerInterface $appLogger;
    /*** @var KernelInterface */
    private KernelInterface $kernel;

    /**
     * RedisService constructor.
     *
     * @param string $redisHost
     * @param string|null $redisPass
     * @param string|null $redisService
     * @param LoggerInterface $appLogger
     * @param KernelInterface $kernel
     */
    public function __construct(
        string $redisHost,
        ?string $redisPass,
        ?string $redisService,
        LoggerInterface $appLogger,
        KernelInterface $kernel
    )
    {
        $this->appLogger = $appLogger;
        try {
            if ($kernel->getEnvironment() === 'dev') {
                $this->client = new Client([
                    'host' => $redisHost,
                ]);
            } else {
                $sentinels = [$redisHost];
                $options = [
                    'replication' => 'sentinel',
                    'service' => $redisService ?? 'redis',
                    'parameters' => [
                        'password' => $redisPass
                    ]
                ];
                $this->client = new Client($sentinels, $options);
            }
        } catch (\Throwable $exception) {
            $this->appLogger->info(
                sprintf(
                    'Redis client is not set - %s %s',
                    $exception->getMessage(),
                    $exception->getTraceAsString()
                )
            );
        }
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param $data
     */
    public function encodeData(&$data)
    {
        if (is_object($data)) {
            $data = base64_encode(serialize($data));
        }
        if (is_array($data)) {
            foreach ($data as &$el) {
               $this->encodeData($el);
            }
            unset($el);
        } elseif (is_string($data) && preg_match('/[\x{0080}-\x{FFFF}]/u', utf8_encode($data))) {
            $data = 'b64e_' . base64_encode($data);
        } elseif (preg_match('#[а-яА-Я]#is', $data)) {
            $data = 'b64e_' . base64_encode($data);
        }
    }

    /**
     * @param $data
     * @param bool $isUnserialize
     */
    public function decodeData(&$data, $isUnserialize = false)
    {
        if ($isUnserialize) {
            $data = unserialize(base64_decode($data));
        } elseif (is_array($data)) {
            foreach ($data as &$el) {
                $this->decodeData($el);
            }
            unset($el);
        } elseif (strpos($data, 'b64e_') === 0) {
            $data = base64_decode(str_replace('b64e_', '', $data));
        }
    }
}