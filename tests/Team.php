<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\Contestant;

/**
 * Class Team
 */
class Team implements Contestant
{
    /**
     * @var int
     */
    private $rating;

    /**
     * @var int
     */
    private $highestRating;

    /**
     * @var int
     */
    private $matchesPlayed;

    /**
     * Team constructor.
     *
     * @param int $rating
     * @param int $highestRating
     * @param int $matchesPlayed
     */
    public function __construct($rating, $highestRating, $matchesPlayed)
    {
        $this->rating        = $rating;
        $this->highestRating = $highestRating;
        $this->matchesPlayed = $matchesPlayed;
    }

    /**
     * @return int
     */
    public function getCurrentRating()
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getHighestRating()
    {
        return $this->highestRating;
    }

    /**
     * @return int
     */
    public function getTotalMatchesPlayed()
    {
        return $this->matchesPlayed;
    }
}
