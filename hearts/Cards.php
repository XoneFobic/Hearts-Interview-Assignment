<?php
declare( strict_types = 1 );

namespace Hearts;

/**
 * Class Cards
 *
 * @package Hearts
 */
class Cards {
  public array $availableCards = [];

  public function shuffle (): Cards {
    shuffle( $this->availableCards );

    return $this;
  }

  public function freshDeck (): Cards {
    $this->availableCards = [];

    $availableTypes = [
      [ 'value' => 1, 'label' => '♤' ],
      [ 'value' => 2, 'label' => '♡' ],
      [ 'value' => 3, 'label' => '♢' ],
      [ 'value' => 4, 'label' => '♧' ]
    ];
    $availableRanks = [
      [ 'value' => 7, 'label' => '7' ],
      [ 'value' => 8, 'label' => '8' ],
      [ 'value' => 9, 'label' => '9' ],
      [ 'value' => 10, 'label' => '10' ],
      [ 'value' => 11, 'label' => 'J' ],
      [ 'value' => 12, 'label' => 'Q' ],
      [ 'value' => 13, 'label' => 'K' ],
      [ 'value' => 14, 'label' => 'A' ]
    ];

    foreach ($availableTypes as $type) {
      foreach ($availableRanks as $rank) {
        $card = [ 'type' => $type, 'rank' => $rank, 'cost' => 0 ];

        if ($card[ 'type' ][ 'value' ] === 2) {
          $card[ 'cost' ] = 1;
        } elseif ($card[ 'type' ][ 'value' ] === 1 && $card[ 'rank' ][ 'value' ] === 12) {
          $card[ 'cost' ] = 5;
        } elseif ($card[ 'type' ][ 'value' ] === 4 && $card[ 'rank' ][ 'value' ] === 11) {
          $card[ 'cost' ] = 2;
        }

        $this->availableCards[] = $card;
      }
    }

    return $this;
  }
}
