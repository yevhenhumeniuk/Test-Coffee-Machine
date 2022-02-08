<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\DTO;

final class DrinkInputDto
{
    private function __construct(
        private string $drinkType,
        private string $money,
        private string $sugar,
        private bool $extraHot,
    ) {
    }

    public function getDrinkType(): string
    {
        return $this->drinkType;
    }

    public function getMoney(): string
    {
        return $this->money;
    }

    public function getSugar(): string
    {
        return $this->sugar;
    }

    public function isExtraHot(): bool
    {
        return $this->extraHot;
    }

    public static function create(string $drinkType, string $money, string $sugar, bool $extraHot): self
    {
        return new self($drinkType, $money, $sugar, $extraHot);
    }
}
