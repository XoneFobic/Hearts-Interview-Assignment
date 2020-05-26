<?php
declare( strict_types = 1 );

namespace Tests;

use Hearts\App;
use PHPUnit\Framework\TestCase;

/**
 * Class AppTest
 *
 * @package Tests
 */
class AppTest extends TestCase {
  /** @var \Hearts\App */
  private App $app;

  public function testFindLoser (): void {
    $data = $this->getLoserTables();

    foreach ($data as $item) {
      $loser = $this->app->findLoser( $item[ 'table' ], $item[ 'type' ] );
      self::assertEquals( $loser, $this->app->players[ $item[ 'loser' ] ] );
    }
  }

  /**
   * @return array
   */
  private function getLoserTables (): array {
    return [
      [
        'table' => [ 'cards' => [
          [
            'type' => [ 'value' => 4 ],
            'rank' => [ 'value' => 8 ],
            'playedBy' => $this->app->players[ 0 ]
          ],
          [
            'type' => [ 'value' => 4 ],
            'rank' => [ 'value' => 7 ],
            'playedBy' => $this->app->players[ 1 ]
          ],
          [
            'type' => [ 'value' => 4 ],
            'rank' => [ 'value' => 11 ],
            'playedBy' => $this->app->players[ 2 ]
          ],
          [
            'type' => [ 'value' => 4 ],
            'rank' => [ 'value' => 9 ],
            'playedBy' => $this->app->players[ 3 ]
          ],
        ] ],
        'type' => 4,
        'loser' => 2
      ],
      [
        'table' => [ 'cards' => [
          [
            'type' => [ 'value' => 1 ],
            'rank' => [ 'value' => 8 ],
            'playedBy' => $this->app->players[ 0 ]
          ],
          [
            'type' => [ 'value' => 1 ],
            'rank' => [ 'value' => 7 ],
            'playedBy' => $this->app->players[ 1 ]
          ],
          [
            'type' => [ 'value' => 4 ],
            'rank' => [ 'value' => 11 ],
            'playedBy' => $this->app->players[ 2 ]
          ],
          [
            'type' => [ 'value' => 1 ],
            'rank' => [ 'value' => 9 ],
            'playedBy' => $this->app->players[ 3 ]
          ],
        ] ],
        'type' => 1,
        'loser' => 3
      ]
    ];
  }

  protected function setUp (): void {
    parent::setUp();

    $this->app = new App();
    $this->app->createPlayers();
  }
}
