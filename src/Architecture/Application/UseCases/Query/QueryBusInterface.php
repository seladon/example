<?php

declare(strict_types=1);

namespace Architecture\Application\UseCases\Query;

interface QueryBusInterface
{
    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function ask(QueryInterface $query);
}
