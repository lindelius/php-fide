# php-fide

[![CircleCI](https://circleci.com/gh/lindelius/php-fide.svg?style=shield)](https://circleci.com/gh/lindelius/php-fide)

A zero-dependency PHP implementation of the [FIDE Rating System](https://handbook.fide.com).

## Requirements

* PHP 7.4, or higher

## Installation

If you are using Composer, you may install the latest version of this library by running the following command from your project's root folder:

```
composer require lindelius/php-fide
```

You may also manually download the library by navigating to the "Releases" page and then expanding the "Assets" section of the latest release.

## Usage

**Step 1.** Implement the `Lindelius\FIDE\ContestantInterface` interface in your contestant entity model (the object holding rating information about a given contestant in a given competition).

```php
use Lindelius\FIDE\ContestantInterface;

class Team implements ContestantInterface
{
    private int $highestRating;
    private int $matchesPlayed;
    private int $rating;

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

**Step 2.** Use the appropriate `Lindelius\FIDE\RatingSystemInterface` method to calculate the new ratings for the contestants after each match.

```php
$ratingSystem = new Lindelius\FIDE\RatingSystem();

// Calculate new ratings for matches with a winner
$newTeamOneRating = $ratingSystem->calculateRatingAfterWin($teamOne, $teamTwo);
$newTeamTwoRating = $ratingSystem->calculateRatingAfterLoss($teamTwo, $teamOne);

// Calculate new ratings for drawn matches
$newTeamOneRating = $ratingSystem->calculateRatingAfterDraw($teamOne, $teamTwo);
$newTeamTwoRating = $ratingSystem->calculateRatingAfterDraw($teamTwo, $teamOne);
```
