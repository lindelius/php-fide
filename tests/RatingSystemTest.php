<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\Contestant;
use Lindelius\FIDE\RatingSystem;
use PHPUnit\Framework\TestCase;

/**
 * Class RatingSystemTest
 *
 * @author  Tom Lindelius <tom.lindelius@gmail.com>
 * @version 2017-05-12
 */
class RatingSystemTest extends TestCase
{
    /**
     * Complete data set for testing rating changes for various contestants.
     *
     * @return array
     */
    public function contestantProvider()
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
     * @return array
     */
    public function equallySkilledContestantProvider()
    {
        return [
            'equally skilled draw'        => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                RatingSystem::DRAW,
                0,
            ],
            'equally skilled lost'        => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                RatingSystem::LOST,
                -10,
            ],
            'equally skilled won'         => [
                new Team(1000, 1000, 35),
                new Team(1000, 1000, 35),
                RatingSystem::WON,
                10,
            ],
            /**
             * Rookie contestants (less than 30 matches played).
             */
            'equally skilled rookie draw' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                RatingSystem::DRAW,
                0,
            ],
            'equally skilled rookie lost' => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                RatingSystem::LOST,
                -20,
            ],
            'equally skilled rookie won'  => [
                new Team(1000, 1000, 10),
                new Team(1000, 1000, 10),
                RatingSystem::WON,
                20,
            ],
            /**
             * Highly skilled contestants (have, or have previously had, a
             * rating of 2400 or more).
             */
            'equally skilled elite draw'  => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::DRAW,
                0,
            ],
            'equally skilled elite lost'  => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::LOST,
                -5,
            ],
            'equally skilled elite won'   => [
                new Team(2200, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::WON,
                5,
            ],
        ];
    }

    /**
     * Data set for testing rating changes for higher skilled contestants.
     *
     * @return array
     */
    public function higherSkilledContestantProvider()
    {
        return [
            'higher skilled draw'        => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                RatingSystem::DRAW,
                -8,
            ],
            'higher skilled lost'        => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                RatingSystem::LOST,
                -18,
            ],
            'higher skilled won'         => [
                new Team(2000, 2000, 75),
                new Team(1000, 1000, 35),
                RatingSystem::WON,
                2,
            ],
            /**
             * Rookie contestants (less than 30 matches played).
             */
            'higher skilled rookie draw' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                RatingSystem::DRAW,
                -6,
            ],
            'higher skilled rookie lost' => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                RatingSystem::LOST,
                -26,
            ],
            'higher skilled rookie won'  => [
                new Team(1100, 1100, 20),
                new Team(1000, 1000, 10),
                RatingSystem::WON,
                14,
            ],
            /**
             * Highly skilled contestants (have, or previously had, a rating of
             * 2400 or more).
             */
            'higher skilled elite draw'  => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::DRAW,
                -3,
            ],
            'higher skilled elite lost'  => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::LOST,
                -8,
            ],
            'higher skilled elite won'   => [
                new Team(2400, 2400, 100),
                new Team(2200, 2200, 75),
                RatingSystem::WON,
                2,
            ],
        ];
    }

    /**
     * Data set for testing rating changes for lower skilled contestants.
     *
     * @return array
     */
    public function lowerSkilledContestantProvider()
    {
        return [
            'lower skilled draw'        => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                RatingSystem::DRAW,
                8,
            ],
            'lower skilled lost'        => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                RatingSystem::LOST,
                -2,
            ],
            'lower skilled won'         => [
                new Team(1000, 1000, 35),
                new Team(2000, 2000, 75),
                RatingSystem::WON,
                18,
            ],
            /**
             * Rookie contestants (less than 30 matches played).
             */
            'lower skilled rookie draw' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                RatingSystem::DRAW,
                17,
            ],
            'lower skilled rookie lost' => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                RatingSystem::LOST,
                -3,
            ],
            'lower skilled rookie won'  => [
                new Team(1000, 1000, 10),
                new Team(2000, 2000, 75),
                RatingSystem::WON,
                37,
            ],
            /**
             * Highly skilled contestants (have, or previously had, a rating of
             * 2400 or more).
             */
            'lower skilled elite draw'  => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                RatingSystem::DRAW,
                3,
            ],
            'lower skilled elite lost'  => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                RatingSystem::LOST,
                -2,
            ],
            'lower skilled elite won'   => [
                new Team(2200, 2400, 100),
                new Team(2400, 2400, 100),
                RatingSystem::WON,
                8,
            ],
        ];
    }

    /**
     * Test the rating change calculation for a given contestant versus a given
     * opponent with a given outcome.
     *
     * @param Contestant $contestant
     * @param Contestant $opponent
     * @param int        $outcome
     * @param int        $expectedRatingChange
     * @dataProvider contestantProvider
     */
    public function testVariousContestantOutcomes(Contestant $contestant, Contestant $opponent, $outcome, $expectedRatingChange)
    {
        $this->assertEquals(
            $expectedRatingChange,
            RatingSystem::calculateRatingChange($contestant, $opponent, $outcome)
        );
    }
}
