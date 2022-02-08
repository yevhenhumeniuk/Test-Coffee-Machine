<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Validation;

class ErrorsBag
{
    private function __construct(
        private array $errors
    ) {
    }

    public function add(string $key, array $context = []): self
    {
        $this->errors[$key] = $context;

        return $this;
    }

    public function getAll(): array
    {
        return $this->errors;
    }

    public function isEmpty(): bool
    {
        return empty($this->errors);
    }

    public static function create(array $errors = []): self
    {
        return new self($errors);
    }
}
