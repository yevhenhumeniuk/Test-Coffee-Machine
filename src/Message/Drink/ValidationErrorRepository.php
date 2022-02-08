<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Message\Drink;

use GetWith\CoffeeMachine\Drink\Validation\ValidationError;
use GetWith\CoffeeMachine\Message\Contract\MessageRepositoryInterface;

class ValidationErrorRepository implements MessageRepositoryInterface
{
    /**
     * @return string[]
     */
    public function getAll(): array
    {
        return [
            ValidationError::INVALID_DRINK_TYPE => 'The drink type should be',
            ValidationError::INVALID_MONEY_AMOUNT => 'The %s costs %.1f.',
            ValidationError::INVALID_SUGAR_NUMBER => 'The number of sugars should be between %d and %d.',
        ];
    }
}
