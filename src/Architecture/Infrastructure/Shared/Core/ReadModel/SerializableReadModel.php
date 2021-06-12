<?php

namespace Architecture\Infrastructure\Shared\Core\ReadModel;

use Architecture\Infrastructure\Shared\Core\Serializer\Serializable;

/**
 * Class SerializableReadModel
 *
 * @package App\Infrastructure\Shared\Core\ReadModel
 */
abstract class SerializableReadModel implements SerializableReadModelInterface
{
    /**
     * @param Serializable $event
     *
     * @return static
     */
    public static function fromSerializable(Serializable $event): self
    {
        return static::deserialize($event->serialize());
    }
}
