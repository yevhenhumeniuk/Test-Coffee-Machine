<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Config\Factory;

use GetWith\CoffeeMachine\Config\Contract\ConfigRepositoryInterface;
use GetWith\CoffeeMachine\Config\DrinkRepository;

class ConfigFactory
{
    public function makeDrinkRepository(): ConfigRepositoryInterface
    {
        return new DrinkRepository();
    }

    public static function create(): self
    {
        return new self();
    }
}
