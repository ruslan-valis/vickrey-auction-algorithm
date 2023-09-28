<?php

declare(strict_types=1);

namespace App\Entity;

class Bid
{
    /**
     * @var string
     */
    private string $name = "";

    /**
     * @var int
     */
    private int $bid = 0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Bid
     */
    public function setName(string $name): Bid
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getBid(): int
    {
        return $this->bid;
    }

    /**
     * @param int $bid
     * @return Bid
     */
    public function setBid(int $bid): Bid
    {
        $this->bid = $bid;
        return $this;
    }
}
