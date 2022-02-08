<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Presenter;

use GetWith\CoffeeMachine\Drink\DTO\DrinkInputDto;
use GetWith\CoffeeMachine\Drink\DTO\DrinkOrderDto;

class DrinkInputToOrderDtoPresenter
{
    public function format(DrinkInputDto $inputDto): DrinkOrderDto
    {
        return DrinkOrderDto::create(
            $inputDto->getDrinkType(),
            (float) $inputDto->getMoney(),
            (int) $inputDto->getSugar(),
            $inputDto->isExtraHot(),
        );
    }

    public static function create(): self
    {
        return new self();
    }
}
