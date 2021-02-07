<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\Contestant;
use Lindelius\FIDE\RatingSystem;
use PHPUnit\Framework\TestCase;

final class RatingSystemTest extends TestCase
{
    /**
     * Test the new rating calculation for a given contestant versus a given
     * opponent with a given outcome.
     *
     * @dataProvider ratingChangeProvider
     * @param Contestant $contestant
     * @param Contestant $opponent
     * @param int $outcome
     * @param int $expectedNewRating
     * @return void
     */
    public function testRatingChanges(Contestant $contestant, Contestant $opponent, int $outcome, int $expectedNewRating): void
    {
        $this->assertEquals(
            $expectedNewRating,
            RatingSystem::calculateNewRating($contestant, $opponent, $outcome)
        );
    }

    /**
     * Complete data set for testing rating changes for various contestants.
     *
     * @return array[]
     */
    public function ratingChangeProvider(): array
    {
        return array_merge(
            $this->equallySkilledContestantProvider(),
            $this->higherSkilledContestantProvider(),
            $this->lowerSkilledContestantProvider()
        );
    }

    /**
     * Data set for testing rating changes for equally skilled contestants.
     *
     * @return array[]
     */
    private function equallySkilledContestantProvider(): array
    {
        return [

            'equally skilled draw' => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                RatingSystem::DRAW,
                1000,
            ],
            'equally skilled lost' => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                RatingSystem::LOST,
                990,
            ],
            'equally skilled won' => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                RatingSystem::WON,
                1010,
            ],

            // Rookie contestants (less than 30 matches played)
            'equally skilled rookie draw' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                RatingSystem::DRAW,
                1000,
            ],
            'equally skilled rookie lost' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                RatingSystem::LOST,
                980,
            ],
            'equally skilled rookie won' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                RatingSystem::WON,
                1020,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            'equally skilled elite draw' => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::DRAW,
                2200,
            ],
            'equally skilled elite lost' => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::LOST,
                2195,
            ],
            'equally skilled elite won' => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::WON,
                2205,
            ],

        ];
    }

    /**
     * Data set for testing rating changes for higher skilled contestants.
     *
     * @return array[]
     */
    private function higherSkilledContestantProvider(): array
    {
        return [

            'higher skilled draw' => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                RatingSystem::DRAW,
                1992,
            ],
            'higher skilled lost' => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                RatingSystem::LOST,
                1982,
            ],
            'higher skilled won' => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                RatingSystem::WON,
                2002,
            ],

            // Rookie contestants (less than 30 matches played)
            'higher skilled rookie draw' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                RatingSystem::DRAW,
                1094,
            ],
            'higher skilled rookie lost' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                RatingSystem::LOST,
                1074,
            ],
            'higher skilled rookie won' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                RatingSystem::WON,
                1114,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            'higher skilled elite draw' => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::DRAW,
                2397,
            ],
            'higher skilled elite lost' => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::LOST,
                2392,
            ],
            'higher skilled elite won' => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::WON,
                2402,
            ],

        ];
    }

    /**
     * Data set for testing rating changes for lower skilled contestants.
     *
     * @return array[]
     */
    private function lowerSkilledContestantProvider(): array
    {
        return [

            'lower skilled draw' => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                RatingSystem::DRAW,
                1008,
            ],
            'lower skilled lost' => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                RatingSystem::LOST,
                998,
            ],
            'lower skilled won' => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                RatingSystem::WON,
                1018,
            ],

            // Rookie contestants (less than 30 matches played)
            'lower skilled rookie draw' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                RatingSystem::DRAW,
                1017,
            ],
            'lower skilled rookie lost' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                RatingSystem::LOST,
                997,
            ],
            'lower skilled rookie won' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                RatingSystem::WON,
                1037,
            ],

            // Highly skilled contestants (have had a rating of 2400, or higher)
            'lower skilled elite draw' => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                RatingSystem::DRAW,
                2203,
            ],
            'lower skilled elite lost' => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                RatingSystem::LOST,
                2198,
            ],
            'lower skilled elite won' => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                RatingSystem::WON,
                2208,
            ],

        ];
    }
}
