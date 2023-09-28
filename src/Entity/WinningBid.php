<?php

declare(strict_types=1);

namespace App\Entity;

class WinningBid
{
    /**
     * @var string
     */
    private string $winningBuyerName = "";

    /**
     * @var int
     */
    private int $winningBidPrice = 0;

    /**
     * @return string
     */
    public function getWinningBuyerName(): string
    {
        return $this->winningBuyerName;
    }

    /**
     * @param string $winningBuyerName
     * @return WinningBid
     */
    public function setWinningBuyerName(string $winningBuyerName): WinningBid
    {
        $this->winningBuyerName = $winningBuyerName;
        return $this;
    }

    /**
     * @return int
     */
    public function getWinningBidPrice(): int
    {
        return $this->winningBidPrice;
    }

    /**
     * @param int $winningBidPrice
     * @return WinningBid
     */
    public function setWinningBidPrice(int $winningBidPrice): WinningBid
    {
        $this->winningBidPrice = $winningBidPrice;
        return $this;
    }
}
