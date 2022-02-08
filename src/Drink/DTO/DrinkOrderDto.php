<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\DTO;

final class DrinkOrderDto
{
    private function __construct(
        private string $drinkType,
        private float $money,
        private int $sugar,
        private bool $extraHot,
    ) {
    }

    public function getDrinkType(): string
    {
        return $this->drinkType;
    }

    public function getMoney(): float
    {
        return $this->money;
    }

    public function getSugar(): int
    {
        return $this->sugar;
    }

    public function isExtraHot(): bool
    {
        return $this->extraHot;
    }

    public static function create(string $drinkType, float $money, int $sugar, bool $extraHot): self
    {
        return new self($drinkType, $money, $sugar, $extraHot);
    }
}
