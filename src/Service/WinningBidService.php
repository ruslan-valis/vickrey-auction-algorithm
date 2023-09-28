<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Bid;
use App\Entity\Buyer;
use App\Entity\WinningBid;

class WinningBidService
{
    /**
     * @param Buyer[] $buyers
     * @param int $reserve
     * @return WinningBid
     */
    public function calculate(array $buyers, int $reserve): WinningBid
    {
        if (!$buyers) {
            return new WinningBid();
        }

        $bids = $this->getMaxBids($buyers);
        if (count($bids) === 0 || $bids[0]->getBid() < $reserve || $bids[0]->getBid() === $bids[1]->getBid()) {
            return new WinningBid();
        }

        return (new WinningBid())
            ->setWinningBuyerName($bids[0]->getName())
            ->setWinningBidPrice($bids[1]->getBid() < $reserve ? $bids[0]->getBid() : $bids[1]->getBid());
    }

    /**
     * @param Buyer[] $buyers
     * @return Bid[]
     */
    private function getMaxBids(array $buyers): array
    {
        $maxBids = [];

        /**
         * @param Buyer $buyer
         */
        foreach ($buyers as $buyer) {
            $maxBids[] = (new Bid())
                ->setName($buyer->getName())
                ->setBid($buyer->getMaxBid());
        }

        usort($maxBids, array($this, "compareBids"));
        return $maxBids;
    }

    /**
     * @param Bid $a
     * @param Bid $b
     * @return int
     * @psalm-suppress UnusedReturnValue
     */
    private function compareBids(Bid $a, Bid $b): int
    {
        return $b->getBid() - $a->getBid();
    }
}
