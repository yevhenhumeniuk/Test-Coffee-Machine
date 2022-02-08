<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Drink\Presenter;

use GetWith\CoffeeMachine\Drink\Contract\ResponseOrderMessagePresenterInterface;
use GetWith\CoffeeMachine\Drink\DTO\DrinkOrderDto;
use GetWith\CoffeeMachine\Drink\MakeDrinkCommand;
use GetWith\CoffeeMachine\Message\Contract\MessageRepositoryInterface;

class ConsoleOrderMessagePresenter implements ResponseOrderMessagePresenterInterface
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository
    ) {
    }

    public function format(DrinkOrderDto $orderDto): string
    {
        $messageMap = $this->messageRepository->getAll();

        // builder pattern can be applied
        $message = sprintf(
            $messageMap[MakeDrinkCommand::ORDERED_MSG],
            $orderDto->getDrinkType()
        );
        if ($orderDto->isExtraHot()) {
            $message .= $messageMap[MakeDrinkCommand::EXTRA_HOT_MSG];
        }
        if ($orderDto->getSugar() >= 1) {
            $message .= sprintf(
                $messageMap[MakeDrinkCommand::WITH_SUGAR_MSG],
                $orderDto->getSugar()
            );
        }

        return $message;
    }
}
