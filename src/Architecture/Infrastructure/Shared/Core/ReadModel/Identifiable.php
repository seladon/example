<?php

namespace Architecture\Infrastructure\Shared\Core\ReadModel;

/**
 * Represents a read model.
 */
interface Identifiable
{
    public function getId(): string;
}
