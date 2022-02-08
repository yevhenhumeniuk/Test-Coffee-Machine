<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Message\Drink;

use GetWith\CoffeeMachine\Message\Contract\MessageRepositoryInterface;

class DrinkMessageRepositoryFactory
{
    public function makeValidationRepository(): MessageRepositoryInterface
    {
        return new ValidationErrorRepository();
    }

    public function makeOderMsgRepository(): MessageRepositoryInterface
    {
        return new OrderMessageRepository();
    }

    public static function create(): self
    {
        return new self();
    }
}
