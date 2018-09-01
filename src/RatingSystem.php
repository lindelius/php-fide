<?php

namespace Lindelius\FIDE;

/**
 * Class RatingSystem
 *
 * An implementation of the FIDE Rating System
 * ({@link https://www.fide.com/fide/handbook.html?id=172&view=article}).
 */
class RatingSystem
{
    /**
     * @var int
     */
    const WON = 1;

    /**
     * @var int
     */
    const DRAW = 0;

    /**
     * @var int
     */
    const LOST = -1;

    /**
     * @var int[]
     */
    private static $ratingDifferences = [
        0   => 50,
        4   => 51,
        11  => 52,
        18  => 53,
        26  => 54,
        33  => 55,
        40  => 56,
        47  => 57,
        54  => 58,
        62  => 59,
        69  => 60,
        77  => 61,
        84  => 62,
        92  => 63,
        99  => 64,
        107 => 65,
        114 => 66,
        122 => 67,
        130 => 68,
        138 => 69,
        146 => 70,
        154 => 71,
        163 => 72,
        171 => 73,
        180 => 74,
        189 => 75,
        198 => 76,
        207 => 77,
        216 => 78,
        226 => 79,
        236 => 80,
        246 => 81,
        257 => 82,
        268 => 83,
        279 => 84,
        291 => 85,
        303 => 86,
        316 => 87,
        329 => 88,
        345 => 89,
        358 => 90,
        375 => 91,
        392 => 92,
        412 => 93,
        433 => 94,
        457 => 95,
        485 => 96,
        518 => 97,
        560 => 98,
        620 => 99,
        735 => 100,
    ];

    /**
     * Calculates the new rating for a given contestant versus a given opponent
     * with a given outcome.
     *
     * @param  Contestant $contestant
     * @param  Contestant $opponent
     * @param  int        $outcome
     * @param  int|null   $k
     * @return int
     */
    public static function calculateNewRating(Contestant $contestant, Contestant $opponent, int $outcome, int $k = null): int
    {
        $isHigherRated = $contestant->getCurrentRating() >= $opponent->getCurrentRating();

        $scoreProbability = static::getScoreProbability(
            static::getRatingDifference($contestant, $opponent),
            $isHigherRated
        );

        if ($k === null) {
            if ($contestant->getTotalMatchesPlayed() < 30) {
                $k = 40;
            } elseif ($contestant->getHighestRating() >= 2400) {
                $k = 10;
            } else {
                $k = 20;
            }
        }

        if ($outcome === static::WON) {
            $score = 1;
        } elseif ($outcome === static::LOST) {
            $score = 0;
        } else {
            $score = 0.5;
        }

        $ratingChange = (int) round(($score - $scoreProbability) * $k);

        return $contestant->getCurrentRating() + $ratingChange;
    }

    /**
     * Gets the absolute rating difference between a given contestant and a
     * given opponent.
     *
     * @param  Contestant $contestant
     * @param  Contestant $opponent
     * @return int
     */
    private static function getRatingDifference(Contestant $contestant, Contestant $opponent): int
    {
        return min(
            abs($contestant->getCurrentRating() - $opponent->getCurrentRating()),
            400
        );
    }

    /**
     * Gets the score probability for a given rating difference.
     *
     * @param  int  $ratingDifference
     * @param  bool $isHigherRated
     * @return float
     */
    private static function getScoreProbability(int $ratingDifference, bool $isHigherRated): float
    {
        $finalScoreProbability = 50;

        foreach (static::$ratingDifferences as $difference => $scoreProbability) {
            if ($ratingDifference < $difference) {
                break;
            }

            $finalScoreProbability = $scoreProbability / 100;
        }

        if (!$isHigherRated) {
            $finalScoreProbability = 1 - $finalScoreProbability;
        }

        return (float) $finalScoreProbability;
    }
}
