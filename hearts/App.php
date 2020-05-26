<?php
declare( strict_types = 1 );

namespace Hearts;

/**
 * Class App
 *
 * @package Hearts
 */
class App {
  private const PLAYER_COUNT = 4;

  /* @var \Hearts\Player[] */
  public array $players = [];
  public Cards $cards;
  public array $table = [];

  private int $round = 1;
  private int $currentPlayer = 0;
  private int $startingPlayer;

  public function __construct () {
    $this->cards = new Cards();
  }

  /**
   * @throws \Exception
   */
  public function gameOn (): void {
    if (empty( $this->players )) {
      $this->createPlayers();
    }
    $this->selectStartingPlayer();

    $this->currentPlayer = $this->startingPlayer;

    while ($this->players[ $this->currentPlayer ]->points < 50) {
      echo '<section>';
      echo '<div class="header">Round ' . $this->round . '</div>';

      $this->playRound();
      $this->round++;

      echo '</section>';
    }

    echo '<section>';
    echo '<div class="header">Results</div>';
    foreach ($this->players as $player) {
      echo '<div>' . $player->name . ' has ' . $player->points . ' points' . ( $player->points >= 50 ? ' <strong>(lost)</strong>' : '' ) . '</div>';
    }
    echo '</section>';
  }

  public function createPlayers (): void {
    for ($index = 0; $index < self::PLAYER_COUNT; $index++) {
      $player = new Player();

      $this->players[] = $player;
    }
  }

  /**
   * @throws \Exception
   */
  private function selectStartingPlayer (): void {
    $this->startingPlayer = random_int( 0, self::PLAYER_COUNT - 1 );
  }

  /**
   * @throws \Exception
   */
  private function playRound (): void {
    $this->table = [ 'cards' => [], 'points' => 0 ];
    $chosenType = null;

    echo '<div class="playedBlock">';
    while (count( $this->table[ 'cards' ] ) < self::PLAYER_COUNT) {
      /** @var \Hearts\Player $player */
      $player = $this->players[ $this->currentPlayer ];

      if (empty( $player->hand )) {
        $this->splitCards();
      }

      $card = $player->playBestCard( $this->table, $chosenType );

      if ($chosenType === null) {
        $chosenType = $card[ 'type' ][ 'value' ];
      }

      $card[ 'playedBy' ] = $player;
      $this->table[ 'cards' ][] = $card;
      $this->table[ 'points' ] += $card[ 'cost' ];

      echo '<div>' . $player->name . ' played ' . $card[ 'type' ][ 'label' ] . $card[ 'rank' ][ 'label' ] . '</div>';

      $this->nextPlayer();
    }
    echo '</div>';

    $loser = $this->findLoser( $this->table, $chosenType );
    $loser->addPoints( $this->table[ 'points' ] );

    echo '<div class="tableResult">Points on Table: ' . $this->table[ 'points' ] . ' (' . $loser->name . ' lost)</div>';
  }

  public function splitCards (): void {
    $this->cards->freshDeck()->shuffle();

    foreach ($this->players as $player) {
      $player->hand = [];
    }

    foreach ($this->cards->availableCards as $card) {
      $this->players[ $this->currentPlayer ]->giveCard( $card );

      $this->currentPlayer++;
      if ($this->currentPlayer >= self::PLAYER_COUNT) {
        $this->currentPlayer = 0;
      }
    }

    echo '<div class="newHands">';

    foreach ($this->players as $player) {
      echo '<div>' . $player->name . ' has been dealt:';

      foreach ($player->hand as $card) {
        echo ' ' . $card[ 'type' ][ 'label' ] . $card[ 'rank' ][ 'label' ];
      }

      echo '</div>';
    }

    echo '</div>';
  }

  private function nextPlayer (): void {
    $this->currentPlayer++;
    if ($this->currentPlayer >= self::PLAYER_COUNT) {
      $this->currentPlayer = 0;
    }
  }

  /**
   * @param array $table
   * @param int $type
   *
   * @return \Hearts\Player
   */
  public function findLoser ( array $table, int $type ): Player {
    /** @var \Hearts\Player $player */
    $player = null;
    $highestPlayerCardOfType = null;

    foreach ($table[ 'cards' ] as $card) {
      if ($card[ 'type' ][ 'value' ] === $type) {
        if ($highestPlayerCardOfType === null || $highestPlayerCardOfType < $card[ 'rank' ][ 'value' ]) {
          $highestPlayerCardOfType = $card[ 'rank' ][ 'value' ];
          $player = $card[ 'playedBy' ];
        }
      }
    }

    return $player;
  }
}
