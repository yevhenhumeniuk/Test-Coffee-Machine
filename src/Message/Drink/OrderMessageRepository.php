<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Message\Drink;

use GetWith\CoffeeMachine\Drink\MakeDrinkCommand;
use GetWith\CoffeeMachine\Message\Contract\MessageRepositoryInterface;

class OrderMessageRepository implements MessageRepositoryInterface
{
    /**
     * @return string[]
     */
    public function getAll(): array
    {
        return [
            MakeDrinkCommand::ORDERED_MSG => 'You have ordered a %s',
            MakeDrinkCommand::WITH_SUGAR_MSG => ' with %d sugars (stick included)',
            MakeDrinkCommand::EXTRA_HOT_MSG => ' extra hot',
        ];
    }
}
