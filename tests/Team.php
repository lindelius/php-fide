<?php

namespace Lindelius\FIDE\Tests;

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

    public function currentRating()
    {
        return $this->rating;
    }

    public function highestRating()
    {
        return $this->highestRating;
    }

    public function totalMatchesPlayed()
    {
        return $this->matches;
    }
}
