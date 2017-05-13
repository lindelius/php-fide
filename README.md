# php-fide
PHP implementation of the [FIDE Rating System](https://www.fide.com/fide/handbook.html?id=172&view=article).

## Requirements
* PHP 5.6, or higher

## Installation
In order to install this library, issue the following command from your project's root folder:

```
composer require "lindelius/php-fide=^0.1"
```

## Usage

First of all, implement the `Lindelius\FIDE\Contestant` interface in your ladder participant model (the object holding rating information about a given contestant in a given ladder or tournament)

```php
use Lindelius\FIDE\Contestant;

/**
 * Class LadderParticipant
 */
class LadderParticipant implements Contestant
{
    public function currentRating()
    {
        // TODO: Return the contestants current rating
    }
    
    public function highestRating()
    {
        // TODO: Return the contestants highest rating
    }
    
    public function totalMatchesPlayed()
    {
        // TODO: Return the total number of matches played by the contestant
    }
}
```

then use the static `Lindelius\FIDE\RatingSystem::calculateRatingChange()` method to calculate the contestants rating changes after each match.

```php
use Lindelius\FIDE\RatingSystem;

/**
 * Calculate rating changes.
 * 
 * `$outcome` should be the outcome for `$contestant` and must be either of the
 * constants defined in the `Lindelius\FIDE\RatingSystem` class.
 */
$contestantRatingChange = RatingSystem::calculateRatingChange($contestant, $opponent, $outcome);
$opponentRatingChange   = RatingSystem::calculateRatingChange($opponent, $contestant, -$outcome);

/**
 * Set the contestants new ratings by adding the calculated rating changes to 
 * their current ratings.
 */
$contestantNewRating = $contestant->currentRating() + $contestantRatingChange;
$opponentNewRating   = $opponent->currentRating() + $opponentRatingChange;

// TODO: Save the new ratings
```
