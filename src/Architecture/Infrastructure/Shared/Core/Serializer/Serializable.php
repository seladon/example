<?php

namespace Architecture\Infrastructure\Shared\Core\Serializer;

/**
 * Contract for objects serializable
 */
interface Serializable
{
    /**
     * @param array $data
     *
     * @return mixed The object instance
     */
    public static function deserialize(array $data);

    public function serialize(): array;
}
