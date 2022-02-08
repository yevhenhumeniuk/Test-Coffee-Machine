<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Message\Contract;

interface MessageRepositoryInterface
{
    public function getAll(): array;
}
