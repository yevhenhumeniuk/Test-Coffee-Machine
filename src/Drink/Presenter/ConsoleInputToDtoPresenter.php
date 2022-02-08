<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Presenter;

use GetWith\CoffeeMachine\Drink\DTO\DrinkInputDto;
use GetWith\CoffeeMachine\Drink\MakeDrinkCommand;
use Symfony\Component\Console\Input\InputInterface;

class ConsoleInputToDtoPresenter
{
    public function format(InputInterface $input): DrinkInputDto
    {
        return DrinkInputDto::create(
            $input->getArgument(MakeDrinkCommand::DRINK_TYPE_ARG),
            (string) $input->getArgument(MakeDrinkCommand::MONEY_ARG),
            (string) $input->getArgument(MakeDrinkCommand::SUGAR_ARG),
            (bool) $input->getOption(MakeDrinkCommand::EXTRA_HOT_OPTION),
        );
    }

    public static function create(): self
    {
        return new self();
    }
}
