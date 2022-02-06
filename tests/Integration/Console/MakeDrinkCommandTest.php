<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Integration\Console;

use GetWith\CoffeeMachine\Console\MakeDrinkCommand;
use GetWith\CoffeeMachine\Tests\Integration\IntegrationTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @internal
 * @coversNothing
 */
class MakeDrinkCommandTest extends IntegrationTestCase
{
    public const COMMAND = 'app:order-drink';

    public const TEA_DRINK_NAME = 'tea';
    public const COFFEE_DRINK_NAME = 'coffee';
    public const CHOCOLATE_DRINK_NAME = 'chocolate';

    public const TEA_DRINK_PRICE = 0.4;
    public const COFFEE_DRINK_PRICE = 0.5;
    public const CHOCOLATE_DRINK_PRICE = 0.6;

    public const DEFAULT_SUGAR = 0;
    public const DEFAULT_EXTRA_HOT = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->application->add(new MakeDrinkCommand());
    }

    /**
     * @dataProvider correctDrinksProvider
     */
    public function testCoffeeMachineAcceptsCorrectDrink(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider incorrectDrinksProvider
     */
    public function testCoffeeMachineAcceptsIncorrectDrink(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider correctMoneyProvider
     */
    public function testCoffeeMachineAcceptsCorrectMoney(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider incorrectMoneyProvider
     */
    public function testCoffeeMachineAcceptsIncorrectMoney(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider correctSugarProvider
     */
    public function testCoffeeMachineAcceptsCorrectSugar(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider noSugarProvider
     */
    public function testCoffeeMachineAcceptsDefaultSugar(
        string $drinkType,
        float $money,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommand([
            'drink-type' => $drinkType,
            'money' => $money,
            '--extra-hot' => $extraHot,
        ]);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider incorrectSugarProvider
     */
    public function testCoffeeMachineAcceptsIncorrectSugar(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider withExtraHotProvider
     */
    public function testCoffeeMachineAcceptsExtraHot(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider withoutExtraHotProvider
     */
    public function testCoffeeMachineAcceptsDefaultExtraHot(
        string $drinkType,
        float $money,
        int $sugars,
        string $expectedOutput,
    ) {
        $output = $this->runCommand([
            'drink-type' => $drinkType,
            'money' => $money,
            'sugars' => $sugars,
        ]);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider correctSugarAndExtraHotProvider
     */
    public function testCoffeeMachineAcceptsSugarAndExtraHot(
        string $drinkType,
        float $money,
        int $sugars,
        bool $extraHot,
        string $expectedOutput,
    ) {
        $output = $this->runCommandMapArgs($drinkType, $money, $sugars, $extraHot);

        $this->assertSame($expectedOutput, $output);
    }

    private function runCommand(array $args): string
    {
        $command = $this->application->find(static::COMMAND);
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),

            ...$args,
        ]);

        return $commandTester->getDisplay();
    }

    private function runCommandMapArgs(string $drinkType, float $money, int $sugars, bool $extraHot): string
    {
        return $this->runCommand([
            'drink-type' => $drinkType,
            'money' => $money,
            'sugars' => $sugars,
            '--extra-hot' => $extraHot,
        ]);
    }

    private function correctDrinksProvider(): array
    {
        $outputPrefix = 'You have ordered a ';

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::TEA_DRINK_NAME . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::COFFEE_DRINK_NAME . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::CHOCOLATE_DRINK_NAME . PHP_EOL,
            ],
        ];
    }

    private function incorrectDrinksProvider(): array
    {
        $expectedOutput = 'The drink type should be ' .
            static::TEA_DRINK_NAME . ', ' .
            static::COFFEE_DRINK_NAME . ' or ' .
            static::CHOCOLATE_DRINK_NAME . '.' . PHP_EOL;

        return [
            [
                'team', static::TEA_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $expectedOutput,
            ],
            [
                '1', static::COFFEE_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $expectedOutput,
            ],
            [
                '', static::CHOCOLATE_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $expectedOutput,
            ],
        ];
    }

    private function correctMoneyProvider(): array
    {
        $outputPrefix = 'You have ordered a ';

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::TEA_DRINK_NAME . PHP_EOL,
            ],
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE + 1, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::TEA_DRINK_NAME . PHP_EOL,
            ],

            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::COFFEE_DRINK_NAME . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE + 1, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::COFFEE_DRINK_NAME . PHP_EOL,
            ],

            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::CHOCOLATE_DRINK_NAME . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE + 1, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::CHOCOLATE_DRINK_NAME . PHP_EOL,
            ],
        ];
    }

    private function incorrectMoneyProvider(): array
    {
        return [
            [
                static::TEA_DRINK_NAME, 0.3, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::TEA_DRINK_NAME . ' costs ' . static::TEA_DRINK_PRICE . '.' . PHP_EOL,
            ],
            [
                static::TEA_DRINK_NAME, 0, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::TEA_DRINK_NAME . ' costs ' . static::TEA_DRINK_PRICE . '.' . PHP_EOL,
            ],
            [
                static::TEA_DRINK_NAME, -1, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::TEA_DRINK_NAME . ' costs ' . static::TEA_DRINK_PRICE . '.' . PHP_EOL,
            ],

            [
                static::COFFEE_DRINK_NAME, 0.4, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::COFFEE_DRINK_NAME . ' costs ' . static::COFFEE_DRINK_PRICE . '.' . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, 0, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::COFFEE_DRINK_NAME . ' costs ' . static::COFFEE_DRINK_PRICE . '.' . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, -1, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::COFFEE_DRINK_NAME . ' costs ' . static::COFFEE_DRINK_PRICE . '.' . PHP_EOL,
            ],

            [
                static::CHOCOLATE_DRINK_NAME, 0.5, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::CHOCOLATE_DRINK_NAME . ' costs ' . static::CHOCOLATE_DRINK_PRICE . '.' . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, 0, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::CHOCOLATE_DRINK_NAME . ' costs ' . static::CHOCOLATE_DRINK_PRICE . '.' . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, -1, static::DEFAULT_SUGAR, static::DEFAULT_EXTRA_HOT, 'The ' . static::CHOCOLATE_DRINK_NAME . ' costs ' . static::CHOCOLATE_DRINK_PRICE . '.' . PHP_EOL,
            ],
        ];
    }

    private function correctSugarProvider(): array
    {
        $noSugarOutputPrefix = 'You have ordered a ';
        $outputPrefix = 'You have ordered a ';
        $outputSuffix = 'sugars (stick included)';

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, 0, static::DEFAULT_EXTRA_HOT, $noSugarOutputPrefix . static::TEA_DRINK_NAME . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, 1, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::COFFEE_DRINK_NAME . " with 1 {$outputSuffix}" . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, 2, static::DEFAULT_EXTRA_HOT, $outputPrefix . static::CHOCOLATE_DRINK_NAME . " with 2 {$outputSuffix}" . PHP_EOL,
            ],
        ];
    }

    private function noSugarProvider(): array
    {
        $noSugarOutputPrefix = 'You have ordered a ';

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, static::DEFAULT_EXTRA_HOT, $noSugarOutputPrefix . static::TEA_DRINK_NAME . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, static::DEFAULT_EXTRA_HOT, $noSugarOutputPrefix . static::COFFEE_DRINK_NAME . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, static::DEFAULT_EXTRA_HOT, $noSugarOutputPrefix . static::CHOCOLATE_DRINK_NAME . PHP_EOL,
            ],
        ];
    }

    private function incorrectSugarProvider(): array
    {
        $expectedOutput = 'The number of sugars should be between 0 and 2.' . PHP_EOL;

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, 3, static::DEFAULT_EXTRA_HOT, $expectedOutput,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, -1, static::DEFAULT_EXTRA_HOT, $expectedOutput,
            ],
        ];
    }

    private function withExtraHotProvider(): array
    {
        $outputPrefix = 'You have ordered a ';
        $outputSuffix = ' extra hot';

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, static::DEFAULT_SUGAR, true, $outputPrefix . static::TEA_DRINK_NAME . $outputSuffix . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, static::DEFAULT_SUGAR, true, $outputPrefix . static::COFFEE_DRINK_NAME . $outputSuffix . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, static::DEFAULT_SUGAR, true, $outputPrefix . static::CHOCOLATE_DRINK_NAME . $outputSuffix . PHP_EOL,
            ],
        ];
    }

    private function withoutExtraHotProvider(): array
    {
        $outputPrefix = 'You have ordered a ';

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, static::DEFAULT_SUGAR, $outputPrefix . static::TEA_DRINK_NAME . PHP_EOL,
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, static::DEFAULT_SUGAR, $outputPrefix . static::COFFEE_DRINK_NAME . PHP_EOL,
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, static::DEFAULT_SUGAR, $outputPrefix . static::CHOCOLATE_DRINK_NAME . PHP_EOL,
            ],
        ];
    }

    private function correctSugarAndExtraHotProvider(): array
    {
        $outputPrefix = 'You have ordered a ';
        $outputExtraHotSuffix = ' extra hot with ';
        $outputSugarSuffix = ' sugars (stick included)' . PHP_EOL;

        return [
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, 1, true, $outputPrefix . static::TEA_DRINK_NAME . "{$outputExtraHotSuffix}1{$outputSugarSuffix}",
            ],
            [
                static::TEA_DRINK_NAME, static::TEA_DRINK_PRICE, 2, true, $outputPrefix . static::TEA_DRINK_NAME . "{$outputExtraHotSuffix}2{$outputSugarSuffix}",
            ],

            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, 1, true, $outputPrefix . static::COFFEE_DRINK_NAME . "{$outputExtraHotSuffix}1{$outputSugarSuffix}",
            ],
            [
                static::COFFEE_DRINK_NAME, static::COFFEE_DRINK_PRICE, 2, true, $outputPrefix . static::COFFEE_DRINK_NAME . "{$outputExtraHotSuffix}2{$outputSugarSuffix}",
            ],

            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, 1, true, $outputPrefix . static::CHOCOLATE_DRINK_NAME . "{$outputExtraHotSuffix}1{$outputSugarSuffix}",
            ],
            [
                static::CHOCOLATE_DRINK_NAME, static::CHOCOLATE_DRINK_PRICE, 2, true, $outputPrefix . static::CHOCOLATE_DRINK_NAME . "{$outputExtraHotSuffix}2{$outputSugarSuffix}",
            ],
        ];
    }
}
