<?php

namespace Lindelius\FIDE;

interface RatingSystemInterface
{
    /**
     * Calculate the new rating for a given contestant after having drawn with a
     * given opponent.
     *
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param int|null $k
     * @return int
     */
    public function calculateRatingAfterDraw(ContestantInterface $contestant, ContestantInterface $opponent, ?int $k = null): int;

    /**
     * Calculate the new rating for a given contestant after having lost to a
     * given opponent.
     *
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param int|null $k
     * @return int
     */
    public function calculateRatingAfterLoss(ContestantInterface $contestant, ContestantInterface $opponent, ?int $k = null): int;

    /**
     * Calculate the new rating for a given contestant after having won over a
     * given opponent.
     *
     * @param ContestantInterface $contestant
     * @param ContestantInterface $opponent
     * @param int|null $k
     * @return int
     */
    public function calculateRatingAfterWin(ContestantInterface $contestant, ContestantInterface $opponent, ?int $k = null): int;
}
