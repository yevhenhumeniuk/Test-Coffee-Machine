<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Contract;

use GetWith\CoffeeMachine\Drink\DTO\DrinkInputDto;
use GetWith\CoffeeMachine\Drink\Validation\ErrorsBag;

interface ValidatorInterface
{
    public function validate(DrinkInputDto $inputDto): ErrorsBag;
}
