<?php

namespace Lindelius\FIDE;

/**
 * Interface Contestant
 *
 * @author  Tom Lindelius <tom.lindelius@gmail.com>
 * @version 2017-05-10
 */
interface Contestant
{
    /**
     * Gets the contestants current rating.
     *
     * @return int
     */
    public function currentRating();

    /**
     * Gets the contestants highest rating.
     *
     * @return int
     */
    public function highestRating();

    /**
     * Gets the total number of matches the contestant has played.
     *
     * @return int
     */
    public function totalMatchesPlayed();
}
