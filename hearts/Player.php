<?php
declare( strict_types = 1 );

namespace Hearts;

use Faker\Factory;

/**
 * Class Player
 *
 * @package Hearts
 */
class Player {
  public string $name;
  public array $hand;
  public int $points = 0;

  public function __construct () {
    $faker = Factory::create();

    $this->name = $faker->firstName;
    $this->hand = [];
  }

  /**
   * @param $card
   */
  public function giveCard ( $card ): void {
    $this->hand[] = $card;
  }

  /**
   * @param array $table
   * @param int $type
   *
   * @return array
   * @throws \Exception
   */
  public function playBestCard ( array $table, ?int $type ): array {
    $cardIndex = count( $table ) === 0 || is_null( $type ) ? $this->randomCardIndex() : $this->getBestCardOfType( $type );
    $card = $this->hand[ $cardIndex ];

    $this->playCard( $cardIndex );

    return $card;
  }

  /**
   * @return int
   * @throws \Exception
   */
  public function randomCardIndex (): int {
    return random_int( 0, count( $this->hand ) - 1 );
  }

  /**
   * @param int $type
   *
   * @return int
   * @throws \Exception
   */
  private function getBestCardOfType ( int $type ): int {
    $chosenCard = null;
    $lowestKnownValue = null;

    foreach ($this->hand as $index => $card) {
      if ($card[ 'type' ][ 'value' ] === $type) {
        if (is_null( $lowestKnownValue ) || $card[ 'rank' ][ 'value' ] < $lowestKnownValue) {
          $lowestKnownValue = $card[ 'rank' ][ 'value' ];
          $chosenCard = $index;
        }
      }
    }

    if ($chosenCard === null) {
      return $this->randomCardIndex();
    }

    return $chosenCard;
  }

  private function playCard ( int $index ): array {
    $returnCard = $this->hand[ $index ];

    unset( $this->hand[ $index ] );
    $this->hand = array_values( $this->hand );

    return $returnCard;
  }

  /**
   * @param $points
   */
  public function addPoints ( $points ): void {
    $this->points += $points;
  }
}
