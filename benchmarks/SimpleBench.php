<?php

namespace Lindelius\FIDE\Benchmarks;

use Lindelius\FIDE\ContestantInterface;
use Lindelius\FIDE\RatingSystem;
use Lindelius\FIDE\RatingSystemInterface;

/**
 * @BeforeMethods("init")
 * @Iterations(5)
 * @Revs(10000)
 * @Warmup(2)
 */
final class SimpleBench
{
    private ?ContestantInterface $a = null;
    private ?ContestantInterface $b = null;
    private ?RatingSystemInterface $ratingSystem = null;

    public function benchCalculateRatings(): void
    {
        $this->ratingSystem->calculateRatingAfterWin($this->a, $this->b);
        $this->ratingSystem->calculateRatingAfterLoss($this->b, $this->a);
    }

    public function init(): void
    {
        $this->a = new StaticContestant(2000, 2200, 1000);
        $this->b = new StaticContestant(1900, 1900, 800);
        $this->ratingSystem = new RatingSystem();
    }
}
