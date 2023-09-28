<?php

declare(strict_types=1);

namespace Command;

use App\Command\WinningBidCommand;
use App\Entity\WinningBid;
use App\Service\WinningBidService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class WinningBidCommandTest extends TestCase
{
    private MockObject $serviceMock;
    private CommandTester $commandTester;

    public function testExecute(): void
    {
        $winningBid = new WinningBid();
        $winningBid->setWinningBidPrice(130);
        $winningBid->setWinningBuyerName("E");

        $this->serviceMock
            ->expects($this->once())
            ->method("calculate")
            ->willReturn($winningBid);

        $this->commandTester->execute([]);

        $this->assertStringContainsString("Winner: E, price: 130", $this->commandTester->getDisplay());
    }

    public function setUp(): void
    {
        $this->serviceMock = $this->getMockBuilder(WinningBidService::class)->getMock();

        $application = new Application();
        $application->add(new WinningBidCommand($this->serviceMock));
        $command = $application->find("app:win-bid-test");
        $this->commandTester = new CommandTester($command);
    }
    public function tearDown(): void
    {
        unset($this->serviceMock, $this->commandTester);
    }
}