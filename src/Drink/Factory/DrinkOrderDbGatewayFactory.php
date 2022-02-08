<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Factory;

use GetWith\CoffeeMachine\Drink\Contract\StoreDrinkOrderDbGatewayInterface;
use GetWith\CoffeeMachine\Drink\DbGateway\StoreDrinkOrderJsonStorage;

class DrinkOrderDbGatewayFactory
{
    public function makeStoreDbGateway(): StoreDrinkOrderDbGatewayInterface
    {
        return new StoreDrinkOrderJsonStorage();
    }

    public static function create(): self
    {
        return new self();
    }
}
