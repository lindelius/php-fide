<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\ContestantInterface;
use Lindelius\FIDE\RatingSystem;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for verifying that the RatingSystem implementation matches the
 * official FIDE rating calculator.
 *
 * @see https://ratings.fide.com/calc.phtml
 */
final class RatingSystemTest extends TestCase
{
    /**
     * @dataProvider provideRatingAfterDraw
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

    public function provideRatingAfterDraw(): array
    {
        return [

            "lower skilled contestant" => [
                new StaticContestant(1000, 1000, 35),
                new StaticContestant(2000, 2000, 75),
                1008,
            ],
            "equally skilled contestant" => [
                new StaticContestant(1000, 1000, 35),
                new StaticContestant(1000, 1000, 35),
                1000,
            ],
            "higher skilled contestant" => [
                new StaticContestant(2000, 2000, 75),
                new StaticContestant(1000, 1000, 35),
                1992,
            ],
            "much higher skilled contestant" => [
                new StaticContestant(2300, 2300, 75),
                new StaticContestant(1400, 1400, 35),
                2292,
            ],

            // Rookie contestants (less than 30 matches played)
            "lower skilled rookie" => [
                new StaticContestant(1000, 1000, 10),
                new StaticContestant(2000, 2000, 75),
                1017,
            ],
            "equally skilled rookie" => [
                new StaticContestant(1000, 1000, 10),
                new StaticContestant(1000, 1000, 10),
                1000,
            ],
            "higher skilled rookie" => [
                new StaticContestant(1100, 1100, 20),
                new StaticContestant(1000, 1000, 10),
                1094,
            ],
            "much higher skilled rookie" => [
                new StaticContestant(2300, 2300, 20),
                new StaticContestant(1400, 1400, 10),
                2283,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            "lower skilled elite" => [
                new StaticContestant(2200, 2400, 100),
                new StaticContestant(2400, 2400, 100),
                2203,
            ],
            "equally skilled elite" => [
                new StaticContestant(2200, 2400, 100),
                new StaticContestant(2200, 2200, 75),
                2200,
            ],
            "higher skilled elite" => [
                new StaticContestant(2400, 2400, 100),
                new StaticContestant(2200, 2200, 75),
                2397,
            ],
            "much higher skilled elite" => [
                new StaticContestant(2300, 2550, 100),
                new StaticContestant(1400, 1400, 75),
                2296,
            ],

        ];
    }

    /**
     * @dataProvider provideRatingAfterLoss
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

    public function provideRatingAfterLoss(): array
    {
        return [

            "lower skilled contestant" => [
                new StaticContestant(1000, 1000, 35),
                new StaticContestant(2000, 2000, 75),
                998,
            ],
            "equally skilled contestant" => [
                new StaticContestant(1000, 1000, 35),
                new StaticContestant(1000, 1000, 35),
                990,
            ],
            "higher skilled contestant" => [
                new StaticContestant(2000, 2000, 75),
                new StaticContestant(1000, 1000, 35),
                1982,
            ],
            "much higher skilled contestant" => [
                new StaticContestant(2300, 2300, 75),
                new StaticContestant(1400, 1400, 35),
                2282,
            ],

            // Rookie contestants (less than 30 matches played)
            "lower skilled rookie" => [
                new StaticContestant(1000, 1000, 10),
                new StaticContestant(2000, 2000, 75),
                997,
            ],
            "equally skilled rookie" => [
                new StaticContestant(1000, 1000, 10),
                new StaticContestant(1000, 1000, 10),
                980,
            ],
            "higher skilled rookie" => [
                new StaticContestant(1100, 1100, 20),
                new StaticContestant(1000, 1000, 10),
                1074,
            ],
            "much higher skilled rookie" => [
                new StaticContestant(2300, 2300, 20),
                new StaticContestant(1400, 1400, 10),
                2263,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            "lower skilled elite" => [
                new StaticContestant(2200, 2400, 100),
                new StaticContestant(2400, 2400, 100),
                2198,
            ],
            "equally skilled elite" => [
                new StaticContestant(2200, 2400, 100),
                new StaticContestant(2200, 2200, 75),
                2195,
            ],
            "higher skilled elite" => [
                new StaticContestant(2400, 2400, 100),
                new StaticContestant(2200, 2200, 75),
                2392,
            ],
            "much higher skilled elite" => [
                new StaticContestant(2300, 2550, 100),
                new StaticContestant(1400, 1400, 75),
                2291,
            ],

        ];
    }

    /**
     * @dataProvider provideRatingAfterWin
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

    public function provideRatingAfterWin(): array
    {
        return [

            "lower skilled contestant" => [
                new StaticContestant(1000, 1000, 35),
                new StaticContestant(2000, 2000, 75),
                1018,
            ],
            "equally skilled contestant" => [
                new StaticContestant(1000, 1000, 35),
                new StaticContestant(1000, 1000, 35),
                1010,
            ],
            "higher skilled contestant" => [
                new StaticContestant(2000, 2000, 75),
                new StaticContestant(1000, 1000, 35),
                2002,
            ],
            "much higher skilled contestant" => [
                new StaticContestant(2300, 2300, 75),
                new StaticContestant(1400, 1400, 35),
                2302,
            ],

            // Rookie contestants (less than 30 matches played)
            "lower skilled rookie" => [
                new StaticContestant(1000, 1000, 10),
                new StaticContestant(2000, 2000, 75),
                1037,
            ],
            "equally skilled rookie" => [
                new StaticContestant(1000, 1000, 10),
                new StaticContestant(1000, 1000, 10),
                1020,
            ],
            "higher skilled rookie" => [
                new StaticContestant(1100, 1100, 20),
                new StaticContestant(1000, 1000, 10),
                1114,
            ],
            "much higher skilled rookie" => [
                new StaticContestant(2300, 2300, 20),
                new StaticContestant(1400, 1400, 10),
                2303,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            "lower skilled elite" => [
                new StaticContestant(2200, 2400, 100),
                new StaticContestant(2400, 2400, 100),
                2208,
            ],
            "equally skilled elite" => [
                new StaticContestant(2200, 2400, 100),
                new StaticContestant(2200, 2200, 75),
                2205,
            ],
            "higher skilled elite" => [
                new StaticContestant(2400, 2400, 100),
                new StaticContestant(2200, 2200, 75),
                2402,
            ],
            "much higher skilled elite" => [
                new StaticContestant(2300, 2550, 100),
                new StaticContestant(1400, 1400, 75),
                2301,
            ],

        ];
    }
}
