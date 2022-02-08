<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Factory;

use GetWith\CoffeeMachine\Drink\Contract\ResponseOrderMessagePresenterInterface;
use GetWith\CoffeeMachine\Drink\Presenter\ConsoleOrderMessagePresenter;
use GetWith\CoffeeMachine\Message\Drink\DrinkMessageRepositoryFactory;

class ResponsePresenterFactory
{
    public function makeConsolePresenter(): ResponseOrderMessagePresenterInterface
    {
        $messageRepository = DrinkMessageRepositoryFactory::create()->makeOderMsgRepository();

        return new ConsoleOrderMessagePresenter($messageRepository);
    }

    public static function create(): self
    {
        return new self();
    }
}
