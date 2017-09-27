<?php

namespace Lindelius\FIDE;

/**
 * Interface Contestant
 *
 * @author  Tom Lindelius <tom.lindelius@gmail.com>
 * @version 2017-09-27
 */
interface Contestant
{
    /**
     * Gets the contestants current rating.
     *
     * @return int
     */
    public function getCurrentRating();

    /**
     * Gets the contestants highest rating.
     *
     * @return int
     */
    public function getHighestRating();

    /**
     * Gets the total number of matches the contestant has played.
     *
     * @return int
     */
    public function getTotalMatchesPlayed();
}
