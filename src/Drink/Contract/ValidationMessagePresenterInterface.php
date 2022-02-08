<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Contract;

use GetWith\CoffeeMachine\Drink\Validation\ErrorsBag;

interface ValidationMessagePresenterInterface
{
    public function format(ErrorsBag $errorsBag): string;
}
