<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Buyer;
use App\Service\WinningBidService;
use JsonException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Execute test of WinningBidService with predefined values
 */
class WinningBidCommand extends Command
{
    private const NAME = "app:win-bid-test";
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

    /**
     * @throws JsonException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Start");

        $output->writeln("Initial conditions: " . json_encode(self::BUYERS, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        $buyers = $this->convertBuyers(self::BUYERS);
        $winner = $this->service->calculate($buyers, self::RESERVE);
        $output->writeln("Winner: " . $winner->getWinningBuyerName() . ", price: " . $winner->getWinningBidPrice());

        $output->writeln("Finish");
        return 0;
    }

    /**
     * @return Buyer[]
     */
    private function convertBuyers(array $buyers): array
    {
        $result = [];
        foreach ($buyers as $buyerData) {
            $buyer = new Buyer();
            $buyer->setName($buyerData["name"]);
            $buyer->setBids($buyerData["bids"]);
            $result[] = $buyer;
        }
        return $result;
    }
}
