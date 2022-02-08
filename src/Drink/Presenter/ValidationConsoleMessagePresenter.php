<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Presenter;

use GetWith\CoffeeMachine\Drink\Contract\ValidationMessagePresenterInterface;
use GetWith\CoffeeMachine\Drink\Validation\ErrorsBag;
use GetWith\CoffeeMachine\Drink\Validation\ValidationError;
use GetWith\CoffeeMachine\Message\Contract\MessageRepositoryInterface;

class ValidationConsoleMessagePresenter implements ValidationMessagePresenterInterface
{
    /**
     * @see formatInvalidDrinkType
     * @see formatInvalidMoneyAmount
     * @see formatInvalidSugarNumber
     */
    private const HANDLERS = [
        ValidationError::INVALID_DRINK_TYPE => 'formatInvalidDrinkType',
        ValidationError::INVALID_MONEY_AMOUNT => 'formatInvalidMoneyAmount',
        ValidationError::INVALID_SUGAR_NUMBER => 'formatInvalidSugarNumber',
    ];

    public function __construct(
        private MessageRepositoryInterface $errorRepository
    ) {
    }

    public function format(ErrorsBag $errorsBag): string
    {
        $errorMap = $this->errorRepository->getAll();

        $message = '';
        foreach ($errorsBag->getAll() as $key => $context) {
            $handler = self::HANDLERS[$key];
            $template = $errorMap[$key];
            $message = $this->{$handler}($template, $context);

            break; // only the first
        }

        return $message;
    }

    private function formatInvalidDrinkType(string $prefix, array $context): string
    {
        $last = array_pop($context['types']);
        $typesInLine = implode(', ', $context['types']);

        return "{$prefix} {$typesInLine} or {$last}.";
    }

    private function formatInvalidMoneyAmount(string $format, array $context): string
    {
        return sprintf($format, $context['type'], $context['price']);
    }

    private function formatInvalidSugarNumber(string $format, array $context): string
    {
        return sprintf($format, $context['min'], $context['max']);
    }
}
