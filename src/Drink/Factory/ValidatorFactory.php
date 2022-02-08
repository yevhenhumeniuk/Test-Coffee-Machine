<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Factory;

use GetWith\CoffeeMachine\Config\Factory\ConfigFactory;
use GetWith\CoffeeMachine\Drink\Contract\ValidatorInterface;
use GetWith\CoffeeMachine\Drink\Validation\MakeDrinkValidator;

class ValidatorFactory
{
    public function makeDrinkValidator(): ValidatorInterface
    {
        $configRepository = ConfigFactory::create()->makeDrinkRepository();

        return new MakeDrinkValidator($configRepository);
    }

    public static function create(): self
    {
        return new self();
    }
}
