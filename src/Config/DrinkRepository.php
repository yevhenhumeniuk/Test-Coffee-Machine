<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Config;

class DrinkRepository implements Contract\ConfigRepositoryInterface
{
    public function getAll(): array
    {
        return [
            'list' => [
                'tea' => [
                    'name' => 'tea',
                    'price' => 0.4,
                ],
                'coffee' => [
                    'name' => 'coffee',
                    'price' => 0.5,
                ],
                'chocolate' => [
                    'name' => 'chocolate',
                    'price' => 0.6,
                ],
            ],

            'additions' => [
                'sugar' => [
                    'min' => 0,
                    'max' => 2,
                    'default' => 0,
                ],
            ],

            'modes' => [
                'extra-hot' => [
                    'default' => false,
                ],
            ],
        ];
    }
}
