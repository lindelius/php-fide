<?php

namespace Lindelius\FIDE;

interface ContestantInterface
{
    /**
     * Get the contestant's current rating.
     *
     * @return int
     */
    public function getCurrentRating(): int;

    /**
     * Get the contestant's highest rating.
     *
     * @return int
     */
    public function getHighestRating(): int;

    /**
     * Get the total number of matches that the contestant has played.
     *
     * @return int
     */
    public function getTotalMatchesPlayed(): int;
}
