<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink;

class MakeDrinkCommand
{
    public const NAME = 'app:order-drink';

    public const DRINK_TYPE_ARG = 'drink-type';
    public const MONEY_ARG = 'money';
    public const SUGAR_ARG = 'sugars';

    public const EXTRA_HOT_OPTION = 'extra-hot';
    public const EXTRA_HOT_OPTION_SHORT = 'e';

    public const ORDERED_MSG = 'drink-ordered';
    public const WITH_SUGAR_MSG = 'drink-with-sugar';
    public const EXTRA_HOT_MSG = 'drink-extra-hot';
}
