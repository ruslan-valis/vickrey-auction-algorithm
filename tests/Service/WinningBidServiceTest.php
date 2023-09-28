<?php

declare(strict_types=1);

namespace Service;

use App\Entity\Buyer;
use App\Entity\WinningBid;
use App\Service\WinningBidService;
use PHPUnit\Framework\TestCase;

class WinningBidServiceTest extends TestCase
{
    public function testWithEmptyBid(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("E");
        $expectedResult->setWinningBidPrice(130);

        $buyers = [
            (new Buyer())->setName("A")->setBids([110, 130]),
            (new Buyer())->setName("B")->setBids([]),
            (new Buyer())->setName("C")->setBids([125]),
            (new Buyer())->setName("D")->setBids([105, 115, 90]),
            (new Buyer())->setName("E")->setBids([132, 135, 130])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithTopSecondTopOnTheSameBuyer(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("B");
        $expectedResult->setWinningBidPrice(135);

        $buyers = [
            (new Buyer())->setName("A")->setBids([110, 130]),
            (new Buyer())->setName("B")->setBids([145, 150]),
            (new Buyer())->setName("C")->setBids([125]),
            (new Buyer())->setName("D")->setBids([105, 115, 90]),
            (new Buyer())->setName("E")->setBids([132, 135, 130])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithoutTopSecondTopOnTheSameBuyer(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("D");
        $expectedResult->setWinningBidPrice(200);

        $buyers = [
            (new Buyer())->setName("A")->setBids([140, 190]),
            (new Buyer())->setName("B")->setBids([115, 155]),
            (new Buyer())->setName("C")->setBids([125]),
            (new Buyer())->setName("D")->setBids([205, 55, 165]),
            (new Buyer())->setName("E")->setBids([200, 135, 130])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithNoWinnerBecauseOfReservePrice(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("");
        $expectedResult->setWinningBidPrice(0);

        $buyers = [
            (new Buyer())->setName("A")->setBids([140, 190]),
            (new Buyer())->setName("B")->setBids([115, 155]),
            (new Buyer())->setName("C")->setBids([125]),
            (new Buyer())->setName("D")->setBids([205, 55, 165]),
            (new Buyer())->setName("E")->setBids([200, 135, 130])
        ];
        $reserve = 350;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithSingleAboveReservePrice(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("B");
        $expectedResult->setWinningBidPrice(115);

        $buyers = [
            (new Buyer())->setName("A")->setBids([40, 90]),
            (new Buyer())->setName("B")->setBids([115, 55]),
            (new Buyer())->setName("C")->setBids([25]),
            (new Buyer())->setName("D")->setBids([5, 55, 65]),
            (new Buyer())->setName("E")->setBids([20, 35, 30])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithWinnerAtReservePrice(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("B");
        $expectedResult->setWinningBidPrice(100);

        $buyers = [
            (new Buyer())->setName("A")->setBids([40, 90]),
            (new Buyer())->setName("B")->setBids([115, 55]),
            (new Buyer())->setName("C")->setBids([25]),
            (new Buyer())->setName("D")->setBids([5, 55, 65]),
            (new Buyer())->setName("E")->setBids([100, 35, 30])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithNoBuyers(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("");
        $expectedResult->setWinningBidPrice(0);

        $buyers = [
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithNoBids(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("");
        $expectedResult->setWinningBidPrice(0);

        $buyers = [
            (new Buyer())->setName("A")->setBids([]),
            (new Buyer())->setName("B")->setBids([]),
            (new Buyer())->setName("C")->setBids([]),
            (new Buyer())->setName("D")->setBids([]),
            (new Buyer())->setName("E")->setBids([])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }


    public function testWithIncorrectBids(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("A");
        $expectedResult->setWinningBidPrice(200);

        $buyers = [
            (new Buyer())->setName("A")->setBids([-10, -500, 210]),
            (new Buyer())->setName("B")->setBids([-20, 115]),
            (new Buyer())->setName("C")->setBids([110, 200]),
            (new Buyer())->setName("D")->setBids([150, -10]),
            (new Buyer())->setName("E")->setBids([75, 200])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithEqualWinBids(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("");
        $expectedResult->setWinningBidPrice(0);

        $buyers = [
            (new Buyer())->setName("A")->setBids([140, 205]),
            (new Buyer())->setName("B")->setBids([115, 200]),
            (new Buyer())->setName("C")->setBids([125]),
            (new Buyer())->setName("D")->setBids([205, 55, 165]),
            (new Buyer())->setName("E")->setBids([200, 135, 130])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithEqualWinPrices(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("A");
        $expectedResult->setWinningBidPrice(200);

        $buyers = [
            (new Buyer())->setName("A")->setBids([140, 205]),
            (new Buyer())->setName("B")->setBids([115, 190]),
            (new Buyer())->setName("C")->setBids([125]),
            (new Buyer())->setName("D")->setBids([200, 55, 165]),
            (new Buyer())->setName("E")->setBids([200, 135, 130])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }

    public function testWithSingleBid(): void
    {
        $expectedResult = new WinningBid();
        $expectedResult->setWinningBuyerName("B");
        $expectedResult->setWinningBidPrice(115);

        $buyers = [
            (new Buyer())->setName("A")->setBids([90]),
            (new Buyer())->setName("B")->setBids([115]),
            (new Buyer())->setName("C")->setBids([25]),
            (new Buyer())->setName("D")->setBids([55]),
            (new Buyer())->setName("E")->setBids([35])
        ];
        $reserve = 100;

        $service = new WinningBidService();
        $result = $service->calculate($buyers, $reserve);

        $this->assertEquals($expectedResult, $result);
    }
}
