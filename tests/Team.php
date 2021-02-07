<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\Contestant;

final class Team implements Contestant
{
    private int $rating;
    private int $highestRating;
    private int $matchesPlayed;

    /**
     * @param int $rating
     * @param int $highestRating
     * @param int $matchesPlayed
     */
    public function __construct(int $rating, int $highestRating, int $matchesPlayed)
    {
        $this->rating = $rating;
        $this->highestRating = $highestRating;
        $this->matchesPlayed = $matchesPlayed;
    }

    public function getCurrentRating(): int
    {
        return $this->rating;
    }

    public function getHighestRating(): int
    {
        return $this->highestRating;
    }

    public function getTotalMatchesPlayed(): int
    {
        return $this->matchesPlayed;
    }
}
