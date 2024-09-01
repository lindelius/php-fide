# php-fide

[![CircleCI](https://circleci.com/gh/lindelius/php-fide.svg?style=shield)](https://circleci.com/gh/lindelius/php-fide)

A zero-dependency PHP implementation of the [FIDE Rating System](https://handbook.fide.com).

## Requirements

* PHP 8.1, or higher

## Installation

If you are using Composer, you may install the latest version of this library by running the following command from your project's root folder:

```
composer require lindelius/php-fide
```

You may also manually download the library by navigating to the "Releases" page and then expanding the "Assets" section of the latest release.

## Usage

**Step 1.** Implement the [`Lindelius\FIDE\ContestantInterface`](src/ContestantInterface.php) interface in your contestant entity model (the object holding rating information about a given contestant in a given competition).

```php
use Lindelius\FIDE\ContestantInterface;

final class MyContestant implements ContestantInterface
{
    private int $highestRating;
    private int $matchesPlayed;
    private int $rating;
    
    // ...

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

**Step 2.** Use the appropriate [`Lindelius\FIDE\RatingSystemInterface`](src/RatingSystemInterface.php) method(s) to calculate the new ratings for the contestants after each match. Please note that all available methods return the new rating for the contestant, and not just the rating change.

For matches with a winner, you will want to use the [`calculateRatingAfterWin()`](src/RatingSystemInterface.php#L38) and [`calculateRatingAfterLoss()`](src/RatingSystemInterface.php#L27) methods.

```php
$newRatingForWinner = $ratingSystem->calculateRatingAfterWin($winner, $loser);
$newRatingForLoser = $ratingSystem->calculateRatingAfterLoss($loser, $winner);
```

And for matches that end in a draw, you will want to use the [`calculateRatingAfterDraw()`](src/RatingSystemInterface.php#L16) method.

```php
$newRatingForContestant = $ratingSystem->calculateRatingAfterDraw($contestant, $opponent);
$newRatingForOpponent = $ratingSystem->calculateRatingAfterDraw($opponent, $contestant);
```

## Benchmarking

This library is using [PHPBench](https://github.com/phpbench/phpbench) for benchmarking.

You can benchmark the library on your own system by running the following command from the library's root folder:

```
./vendor/bin/phpbench run --report=default
```