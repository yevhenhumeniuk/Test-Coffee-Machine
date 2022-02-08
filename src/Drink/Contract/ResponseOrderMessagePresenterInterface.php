<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Contract;

use GetWith\CoffeeMachine\Drink\DTO\DrinkOrderDto;

interface ResponseOrderMessagePresenterInterface
{
    public function format(DrinkOrderDto $orderDto): string;
}
