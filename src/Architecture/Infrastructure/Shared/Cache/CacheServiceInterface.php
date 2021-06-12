<?php

declare(strict_types=1);

namespace Architecture\Infrastructure\Shared\Cache;


/**
 * Interface CacheServiceInterface
 *
 * @package Architecture\Infrastructure\Shared\Cache
 */
interface CacheServiceInterface
{
    /**
     * @param string $cacheId
     *
     * @param int $cacheTime
     *
     * @param string $cacheTag

     */
    public function getCache(string $cacheId, int $cacheTime = 3600, string $cacheTag = '');

    /**
     * @param string $cacheTag
     */
    public function clearByTag(string $cacheTag): void;
}