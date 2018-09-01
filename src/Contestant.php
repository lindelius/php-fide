<?php

namespace Lindelius\FIDE;

/**
 * Interface Contestant
 */
interface Contestant
{
    /**
     * Gets the contestant's current rating.
     *
     * @return int
     */
    public function getCurrentRating(): int;

    /**
     * Gets the contestant's highest rating.
     *
     * @return int
     */
    public function getHighestRating(): int;

    /**
     * Gets the total number of matches that the contestant has played.
     *
     * @return int
     */
    public function getTotalMatchesPlayed(): int;
}
