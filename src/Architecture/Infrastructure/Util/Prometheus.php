<?php

namespace Architecture\Infrastructure\Util;

use Prometheus\Storage\Redis;

class Prometheus
{
    public static function getRedisAdapter(): Redis
    {
        return new Redis([
            'host' => getenv('REDIS_HOST'),
            'port' => (int) getenv('REDIS_PORT'),
            'password' => null,
            'timeout' => 0.1, // in seconds
            'read_timeout' => '10', // in seconds
            'persistent_connections' => false,
        ]);
    }
}
