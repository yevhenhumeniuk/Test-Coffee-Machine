<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Validation;

use GetWith\CoffeeMachine\Config\Contract\ConfigRepositoryInterface;
use GetWith\CoffeeMachine\Drink\Contract\ValidatorInterface;
use GetWith\CoffeeMachine\Drink\DTO\DrinkInputDto;

class MakeDrinkValidator implements ValidatorInterface
{
    public function __construct(
        private ConfigRepositoryInterface $configRepository
    ) {
    }

    public function validate(DrinkInputDto $inputDto): ErrorsBag
    {
        $bag = ErrorsBag::create();
        $config = $this->configRepository->getAll();

        $types = $this->getDrinkTypes($config['list']);
        $isValidType = in_array(
            $inputDto->getDrinkType(),
            $types,
            true
        );
        if (!$isValidType) {
            return $bag->add(ValidationError::INVALID_DRINK_TYPE, [
                'types' => $types,
            ]);
        }

        $price = $this->getPrice(
            $config['list'],
            $inputDto->getDrinkType()
        );
        $money = (float) $inputDto->getMoney();
        $isValidMoney = $money >= $price;
        if (!$isValidMoney) {
            return $bag->add(ValidationError::INVALID_MONEY_AMOUNT, [
                'type' => $inputDto->getDrinkType(),
                'price' => $price,
            ]);
        }

        $params = $this->getSugarParams($config['additions']);
        $sugar = (int) $inputDto->getSugar();
        $isValidSugar = $sugar >= $params['min'] && $sugar <= $params['max'];
        if (!$isValidSugar) {
            return $bag->add(ValidationError::INVALID_SUGAR_NUMBER, [
                'min' => $params['min'],
                'max' => $params['max'],
            ]);
        }

        return $bag;
    }

    /**
     * @return string[]
     */
    private function getDrinkTypes(array $list): array
    {
        return array_map(function (array $drink): string {
            return $drink['name'];
        }, $list);
    }

    private function getPrice(array $list, string $type): float
    {
        return $list[$type]['price'];
    }

    private function getSugarParams(array $additions): array
    {
        return $additions['sugar'];
    }
}
