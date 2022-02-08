<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Console;

use GetWith\CoffeeMachine\Drink\Contract\ResponseOrderMessagePresenterInterface;
use GetWith\CoffeeMachine\Drink\Contract\StoreDrinkOrderDbGatewayInterface;
use GetWith\CoffeeMachine\Drink\Contract\ValidationMessagePresenterInterface;
use GetWith\CoffeeMachine\Drink\Contract\ValidatorInterface;
use GetWith\CoffeeMachine\Drink\Factory\DrinkOrderDbGatewayFactory;
use GetWith\CoffeeMachine\Drink\Factory\ResponsePresenterFactory;
use GetWith\CoffeeMachine\Drink\Factory\ValidationPresenterFactory;
use GetWith\CoffeeMachine\Drink\Factory\ValidatorFactory;
use GetWith\CoffeeMachine\Drink\MakeDrinkCommand as MakeDrinkCmd;
use GetWith\CoffeeMachine\Drink\Presenter\ConsoleInputToDtoPresenter;
use GetWith\CoffeeMachine\Drink\Presenter\DrinkInputToOrderDtoPresenter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeDrinkCommand extends Command
{
    protected static $defaultName = MakeDrinkCmd::NAME;

    private ConsoleInputToDtoPresenter $inputPresenter;
    private ValidatorInterface $validator;
    private ValidationMessagePresenterInterface $validationPresenter;
    private DrinkInputToOrderDtoPresenter $orderPresenter;
    private StoreDrinkOrderDbGatewayInterface $orderStorage;
    private ResponseOrderMessagePresenterInterface $outputPresenter;

    public function __construct()
    {
        parent::__construct(MakeDrinkCommand::$defaultName);

        $this->inputPresenter = ConsoleInputToDtoPresenter::create();
        $this->validator = ValidatorFactory::create()->makeDrinkValidator();
        $this->validationPresenter = ValidationPresenterFactory::create()->makeConsoleMessagePresenter();
        $this->orderPresenter = DrinkInputToOrderDtoPresenter::create();
        $this->orderStorage = DrinkOrderDbGatewayFactory::create()->makeStoreDbGateway();
        $this->outputPresenter = ResponsePresenterFactory::create()->makeConsolePresenter();
    }

    protected function configure(): void
    {
        $this->addArgument(
            MakeDrinkCmd::DRINK_TYPE_ARG,
            InputArgument::REQUIRED,
            'The type of the drink. (Tea, Coffee or Chocolate)'
        );

        $this->addArgument(
            MakeDrinkCmd::MONEY_ARG,
            InputArgument::REQUIRED,
            'The amount of money given by the user'
        );

        $this->addArgument(
            MakeDrinkCmd::SUGAR_ARG,
            InputArgument::OPTIONAL,
            'The number of sugars you want. (0, 1, 2)',
            0
        );

        $this->addOption(
            MakeDrinkCmd::EXTRA_HOT_OPTION,
            MakeDrinkCmd::EXTRA_HOT_OPTION_SHORT,
            InputOption::VALUE_NONE,
            'If the user wants to make the drink extra hot'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputDto = $this->inputPresenter->format($input);
        $errorsBag = $this->validator->validate($inputDto);
        if (!$errorsBag->isEmpty()) {
            $message = $this->validationPresenter->format($errorsBag);
            $output->writeln($message);

            return self::SUCCESS;
        }

        $orderDto = $this->orderPresenter->format($inputDto);
        $this->orderStorage->pushMoney($orderDto);

        $message = $this->outputPresenter->format($orderDto);
        $output->writeln($message);

        return self::SUCCESS;
    }
}
