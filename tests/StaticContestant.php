<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\ContestantInterface;

final class StaticContestant implements ContestantInterface
{
    public function __construct(
        private readonly int $currentRating,
        private readonly int $highestRating,
        private readonly int $totalMatchesPlayed,
    ) {
    }

    public function getCurrentRating(): int
    {
        return $this->currentRating;
    }

    public function getHighestRating(): int
    {
        return $this->highestRating;
    }

    public function getTotalMatchesPlayed(): int
    {
        return $this->totalMatchesPlayed;
    }
}
