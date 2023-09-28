<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Buyer;
use App\Service\WinningBidService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Execute test of WinningBidService with predefined values
 */
class WinningBidCommand extends Command
{
    private const NAME = "app:win-bet-test";
    private const BUYERS = [
        [
            "name" => "A",
            "bids" => [ 110, 130 ]
        ],
        [
            "name" => "B",
            "bids" => []
        ],
        [
            "name" => "C",
            "bids" => [ 125 ]
        ],
        [
            "name" => "D",
            "bids" => [ 105, 115, 90 ]
        ],
        [
            "name" => "E",
            "bids" => [ 132, 135, 130 ]
        ]
    ];
    private const RESERVE = 100;

    private WinningBidService $service;

    public function __construct(WinningBidService $service)
    {
        $this->service = $service;
        parent::__construct(self::NAME);
    }

    public function configure(): void
    {
        $this->setDescription("Start predefined test of WinningBidService");
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Start");

        /**
         * @param Buyer[] $buyers
         */
        $buyers = [];
        foreach (self::BUYERS as $buyerData) {
            $buyer = new Buyer();
            $buyer->setName($buyerData["name"]);
            $buyer->setBids($buyerData["bids"]);
            $output->writeln("Buyer: " . $buyer->getName() . ", bids: " . json_encode($buyer->getBids()));
            $buyers[] = $buyer;
        }

        $winner = $this->service->calculate($buyers, self::RESERVE);
        $output->writeln("Winner: " . $winner->getWinningBuyerName() . ", price: " . $winner->getWinningBidPrice());

        $output->writeln("Finish");
        return 0;
    }
}
