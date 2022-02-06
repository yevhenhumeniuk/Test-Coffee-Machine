<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

/**
 * @internal
 * @coversNothing
 */
class IntegrationTestCase extends TestCase
{
    protected Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        $this->application = new Application();
    }
}
