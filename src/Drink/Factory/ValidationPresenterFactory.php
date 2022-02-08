<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Factory;

use GetWith\CoffeeMachine\Drink\Contract\ValidationMessagePresenterInterface;
use GetWith\CoffeeMachine\Drink\Presenter\ValidationConsoleMessagePresenter;
use GetWith\CoffeeMachine\Message\Drink\DrinkMessageRepositoryFactory;

class ValidationPresenterFactory
{
    public function makeConsoleMessagePresenter(): ValidationMessagePresenterInterface
    {
        $messageRepository = DrinkMessageRepositoryFactory::create()->makeValidationRepository();

        return new ValidationConsoleMessagePresenter($messageRepository);
    }

    public static function create(): self
    {
        return new self();
    }
}
