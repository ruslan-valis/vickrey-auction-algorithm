<?php

declare(strict_types=1);

namespace App\Entity;

class Buyer
{
    private string $name = "";

    /**
     * @var int[]
     */
    private array $bids = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Buyer
     */
    public function setName(string $name): Buyer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getBids(): array
    {
        return $this->bids;
    }

    /**
     * @return int
     */
    public function getMaxBid(): int
    {
        if (count($this->bids) === 0) {
            return 0;
        }
        return max($this->bids);
    }

    /**
     * @param int[] $bids
     * @return Buyer
     */
    public function setBids(array $bids): Buyer
    {
        $this->bids = $bids;
        return $this;
    }
}
