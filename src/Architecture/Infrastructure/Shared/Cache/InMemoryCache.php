<?php


namespace Architecture\Infrastructure\Shared\Cache;


class InMemoryCache implements CacheServiceInterface
{
    //TODO реализовать кеш
    private array $test = [];

    public function getCache(string $cacheId, int $cacheTime = 3600, string $cacheTag = '')
    {
        return $this->test[$cacheTag];
    }

    public function clearByTag(string $cacheTag): void
    {
        unset($this->test[$cacheTag]);
    }
}