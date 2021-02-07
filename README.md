# php-fide

[![CircleCI](https://circleci.com/gh/lindelius/php-fide.svg?style=shield)](https://circleci.com/gh/lindelius/php-fide)

A zero-dependency PHP implementation of the [FIDE Rating System](https://handbook.fide.com).

## Requirements

* PHP 7.4, or higher

## Installation

In order to install the latest version of this library, issue the following Composer command from your project's root folder:

```
composer require lindelius/php-fide
```

## Usage

The first step is to implement the `Lindelius\FIDE\ContestantInterface` interface in your contestant entity model (the object holding rating information about a given contestant in a given competition).

```php
use Lindelius\FIDE\ContestantInterface;

class Team implements ContestantInterface
{
    private int $highestRating;
    private int $matchesPlayed;
    private int $rating;

    public function setCurrentRating(int $newRating): void
    {
        $this->rating = $newRating;
    }

    public function getCurrentRating(): int
    {
        return $this->rating;
    }

    public function getHighestRating(): int
    {
        return $this->highestRating;
    }

    public function getTotalMatchesPlayed(): int
    {
        return $this->matchesPlayed;
    }
}
```

Then, use the appropriate `Lindelius\FIDE\RatingSystemInterface` method to calculate the new ratings for the contestants after each match.

```php
$ratingSystem = new Lindelius\FIDE\RatingSystem();

// Calculate new ratings for matches with a winner
$teamOne->setCurrentRating($ratingSystem->calculateRatingAfterWin($teamOne, $teamTwo));
$teamTwo->setCurrentRating($ratingSystem->calculateRatingAfterLoss($teamTwo, $teamOne));

// Calculate new ratings for drawn matches
$teamOne->setCurrentRating($ratingSystem->calculateRatingAfterDraw($teamOne, $teamTwo));
$teamTwo->setCurrentRating($ratingSystem->calculateRatingAfterDraw($teamTwo, $teamOne));
```
