<?php

namespace Lindelius\FIDE;

use function abs;
use function min;
use function round;

/**
 * Implementation of the FIDE Rating System ({@link https://handbook.fide.com}).
 */
final class RatingSystem implements RatingSystemInterface
{
    /**
     * The current look-up table for rating differences and score probabilities.
     *
     * @var int[]
     */
    private static array $ratingDifferences = [
        0 => 50,
        4 => 51,
        11 => 52,
        18 => 53,
        26 => 54,
        33 => 55,
        40 => 56,
        47 => 57,
        54 => 58,
        62 => 59,
        69 => 60,
        77 => 61,
        84 => 62,
        92 => 63,
        99 => 64,
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

    public function calculateRatingAfterDraw(ContestantInterface $contestant, ContestantInterface $opponent, ?int $k = null): int
    {
        return self::calculateRating($contestant, $opponent, 0.5, $k);
    }

    public function calculateRatingAfterLoss(ContestantInterface $contestant, ContestantInterface $opponent, ?int $k = null): int
    {
        return self::calculateRating($contestant, $opponent, 0.0, $k);
    }

    public function calculateRatingAfterWin(ContestantInterface $contestant, ContestantInterface $opponent, ?int $k = null): int
    {
        return self::calculateRating($contestant, $opponent, 1.0, $k);
    }

    /**
     * Calculate the new rating for a given contestant after a given outcome
     * (the "score" parameter) against a given opponent.
     *
     * The score depends on the outcome and should be set to 0.5 after a draw,
     * 0 after a loss, and 1 after a win.
     *
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param float $score
     * @param int|null $k
     * @return int
     */
    private static function calculateRating(ContestantInterface $contestant, ContestantInterface $opponent, float $score, ?int $k = null): int
    {
        $isHigherRated = $contestant->getCurrentRating() >= $opponent->getCurrentRating();

        $scoreProbability = self::getScoreProbability(
            self::getRatingDifference($contestant, $opponent),
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

        $ratingChange = (int) round(($score - $scoreProbability) * $k);

        return $contestant->getCurrentRating() + $ratingChange;
    }

    /**
     * Get the absolute rating difference between a given contestant and a
     * given opponent.
     *
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @return int
     */
    private static function getRatingDifference(ContestantInterface $contestant, ContestantInterface $opponent): int
    {
        return min(
            abs($contestant->getCurrentRating() - $opponent->getCurrentRating()),
            400
        );
    }

    /**
     * Get the score probability for a given rating difference.
     *
     * @param int $ratingDifference
     * @param bool $isHigherRated
     * @return float
     */
    private static function getScoreProbability(int $ratingDifference, bool $isHigherRated): float
    {
        $finalScoreProbability = 50;

        foreach (self::$ratingDifferences as $difference => $scoreProbability) {
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
