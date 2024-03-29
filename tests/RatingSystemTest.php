<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\ContestantInterface;
use Lindelius\FIDE\RatingSystem;
use PHPUnit\Framework\TestCase;

final class RatingSystemTest extends TestCase
{
    /**
     * @dataProvider ratingAfterDrawProvider
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param int $expectedNewRating
     * @return void
     */
    public function testRatingAfterDraw(ContestantInterface $contestant, ContestantInterface $opponent, int $expectedNewRating): void
    {
        $this->assertSame(
            $expectedNewRating,
            (new RatingSystem())->calculateRatingAfterDraw($contestant, $opponent)
        );
    }

    public function ratingAfterDrawProvider(): array
    {
        return [

            'equally skilled contestant' => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                1000,
            ],
            'higher skilled contestant' => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                1992,
            ],
            'lower skilled contestant' => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                1008,
            ],

            // Rookie contestants (less than 30 matches played)
            'equally skilled rookie' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                1000,
            ],
            'higher skilled rookie' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                1094,
            ],
            'lower skilled rookie' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                1017,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            'equally skilled elite' => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                2200,
            ],
            'higher skilled elite' => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                2397,
            ],
            'lower skilled elite' => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                2203,
            ],

        ];
    }

    /**
     * @dataProvider ratingAfterLossProvider
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param int $expectedNewRating
     * @return void
     */
    public function testRatingAfterLoss(ContestantInterface $contestant, ContestantInterface $opponent, int $expectedNewRating): void
    {
        $this->assertSame(
            $expectedNewRating,
            (new RatingSystem())->calculateRatingAfterLoss($contestant, $opponent)
        );
    }

    public function ratingAfterLossProvider(): array
    {
        return [

            'equally skilled contestant' => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                990,
            ],
            'higher skilled contestant' => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                1982,
            ],
            'lower skilled contestant' => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                998,
            ],

            // Rookie contestants (less than 30 matches played)
            'equally skilled rookie' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                980,
            ],
            'higher skilled rookie' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                1074,
            ],
            'lower skilled rookie' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                997,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            'equally skilled elite' => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                2195,
            ],
            'higher skilled elite' => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                2392,
            ],
            'lower skilled elite' => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                2198,
            ],

        ];
    }

    /**
     * @dataProvider ratingAfterWinProvider
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param int $expectedNewRating
     * @return void
     */
    public function testRatingAfterWin(ContestantInterface $contestant, ContestantInterface $opponent, int $expectedNewRating): void
    {
        $this->assertSame(
            $expectedNewRating,
            (new RatingSystem())->calculateRatingAfterWin($contestant, $opponent)
        );
    }

    public function ratingAfterWinProvider(): array
    {
        return [

            'equally skilled contestant' => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                1010,
            ],
            'higher skilled contestant' => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                2002,
            ],
            'lower skilled contestant' => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                1018,
            ],

            // Rookie contestants (less than 30 matches played)
            'equally skilled rookie' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                1020,
            ],
            'higher skilled rookie' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                1114,
            ],
            'lower skilled rookie' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                1037,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            'equally skilled elite' => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                2205,
            ],
            'higher skilled elite' => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                2402,
            ],
            'lower skilled elite' => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                2208,
            ],

        ];
    }
}
