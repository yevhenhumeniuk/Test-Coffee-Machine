<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\DbGateway;

use GetWith\CoffeeMachine\Drink\Contract\StoreDrinkOrderDbGatewayInterface;
use GetWith\CoffeeMachine\Drink\DTO\DrinkOrderDto;

class StoreDrinkOrderJsonStorage implements StoreDrinkOrderDbGatewayInterface
{
    private const FILENAME = 'ordered_drinks';
    private const FULL_FILENAME = self::FILENAME . '.json';

    private const PATH_TO_ROOT = __DIR__ . '/../../../';
    private const STORAGE_PATH = 'storage';

    private array $data;
    private readonly array $originalData;

    public function __construct()
    {
        $this->data = $this->getData();
    }

    public function __destruct()
    {
        $hasChanged = $this->data !== $this->originalData;
        if ($hasChanged) {
            $this->save();
        }
    }

    public function pushMoney(DrinkOrderDto $orderDto): bool
    {
        $money = $this->data[$orderDto->getDrinkType()] ?? 0;

        $this->data[$orderDto->getDrinkType()] = $money + $orderDto->getMoney();

        return $this->save();
    }

    private function getData(): array
    {
        $fullPathToFile = $this->getFullPathToFile();

        $hasFile = file_exists($fullPathToFile);
        if ($hasFile) {
            $content = file_get_contents($fullPathToFile);
            $data = json_decode($content, true);
        } else {
            $data = [];
        }
        $this->data = $data;
        $this->originalData = $data;

        return $data;
    }

    private function save(): bool
    {
        return (bool) file_put_contents(
            $this->getFullPathToFile(),
            json_encode($this->data),
        );
    }

    private function getFullPathToFile(): string
    {
        return self::PATH_TO_ROOT . self::STORAGE_PATH . '/' . self::FULL_FILENAME;
    }
}
