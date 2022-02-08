<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Config\Contract;

interface ConfigRepositoryInterface
{
    public function getAll(): array;
}
