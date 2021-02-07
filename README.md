# php-fide

PHP implementation of the [FIDE Rating System](https://www.fide.com/fide/handbook.html?id=172&view=article).

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

Then, use the static `Lindelius\FIDE\RatingSystem::calculateNewRating()` method to calculate the new ratings for the contestants after each match.

```php
use Lindelius\FIDE\RatingSystem;

$teamOne->setCurrentRating(RatingSystem::calculateNewRating($teamOne, $teamTwo, RatingSystem::WON));
$teamTwo->setCurrentRating(RatingSystem::calculateNewRating($teamTwo, $teamOne, RatingSystem::LOST));
```
