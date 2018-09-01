# php-fide

PHP implementation of the [FIDE Rating System](https://www.fide.com/fide/handbook.html?id=172&view=article).

## Requirements

* PHP 5.6, or higher

## Installation

In order to install this library, issue the following Composer command from your project's root folder:

```
composer require "lindelius/php-fide=^0.3"
```

## Usage

First of all, implement the `Lindelius\FIDE\Contestant` interface in your ladder participant model (the object holding rating information about a given contestant in a given ladder or tournament).

```php
use Lindelius\FIDE\Contestant;

/**
 * Class Team
 */
class Team implements Contestant
{
    /**
     * @return int
     */
    public function getCurrentRating()
    {
        // TODO: Return the team's current rating
    }
    
    /**
     * @return int
     */
    public function getHighestRating()
    {
        // TODO: Return the team's highest rating
    }
    
    /**
     * @return int
     */
    public function getTotalMatchesPlayed()
    {
        // TODO: Return the total number of matches played by the team
    }
}
```

Then, use the static `Lindelius\FIDE\RatingSystem::calculateNewRating()` method to calculate the new ratings for the contestants after each match.

```php
use Lindelius\FIDE\RatingSystem;

/**
 * Calculate the new rating for both contestants.
 *
 * @var Team $contestant
 * @var Team $opponent
 */
$contestant->rating = RatingSystem::calculateNewRating($contestant, $opponent, RatingSystem::WON);
$opponent->rating   = RatingSystem::calculateNewRating($opponent, $contestant, RatingSystem::LOST);
```
