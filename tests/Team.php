<?php

namespace Lindelius\FIDE\Tests;

use Lindelius\FIDE\Contestant;

/**
 * Class Team
 *
 * @author  Tom Lindelius <tom.lindelius@gmail.com>
 * @version 2017-05-10
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
    private $matches;

    /**
     * Constructor for Team objects.
     *
     * @param int $rating
     * @param int $highestRating
     * @param int $matches
     */
    public function __construct($rating, $highestRating, $matches)
    {
        $this->rating        = $rating;
        $this->highestRating = $highestRating;
        $this->matches       = $matches;
    }

    /**
     * Gets the contestants current rating.
     *
     * @return int
     */
    public function currentRating()
    {
        return $this->rating;
    }

    /**
     * Gets the contestants highest rating.
     *
     * @return int
     */
    public function highestRating()
    {
        return $this->highestRating;
    }

    /**
     * Gets the total number of matches the contestant has played.
     *
     * @return int
     */
    public function totalMatchesPlayed()
    {
        return $this->matches;
    }
}
