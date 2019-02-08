<?php
/**
 * Created by PhpStorm.
 * User: jennifer.maillot
 * Date: 07/02/19
 * Time: 12:31
 */

namespace App\Tests\Service\Bet;


use PHPUnit\Framework\TestCase;
use App\Service\Bet\GainPotential;
use App\Entity\Bet;
use App\Entity\Game;


class GainPotentialTest extends TestCase
{
    private function initGame($scoreTeamA, $scoreTeamB){
        $game = $this->createMock(Game::class);
        $game->expects($this->atLeastOnce())
            ->method('getScoreTeamA')
            ->willReturn($scoreTeamA);

        $game->expects($this->atLeastOnce())
            ->method('getScoreTeamB')
            ->willReturn($scoreTeamB);

        return $game;
    }

    private function initBet($scoreTeamA, $scoreTeamB, $game){
        $bet = $this->createMock(Bet::class);
        $bet->expects($this->atLeastOnce())
            ->method('getScoreTeamA')
            ->willReturn($scoreTeamA);

        $bet->expects($this->atLeastOnce())
            ->method('getScoreTeamB')
            ->willReturn($scoreTeamB);

        $bet->expects($this->atLeastOnce())
            ->method('getGame')
            ->willReturn($game);

        return $bet;
    }


    public function testGagnantExactTeamA(){
        $game = $this->initGame(6, 3);

        $bet = $this->initBet(6, 3, $game);

        $this->assertEquals(3, GainPotential::checkResult($bet));

    }

    public function testGagnantExactTeamB(){
        $game = $this->initGame(3, 6);

        $bet = $this->initBet(3, 6, $game);

        $this->assertEquals(3, GainPotential::checkResult($bet));
    }

    public function testEgalite(){
        $game = $this->initGame(0, 0);

        $bet = $this->initBet(0, 0, $game);

        $this->assertEquals(3, GainPotential::checkResult($bet));
    }

    public function testGagnantBonneVoieTeamA(){
        $game = $this->initGame(6, 3);

        $bet = $this->initBet(4, 3, $game);

        $this->assertEquals(1, GainPotential::checkResult($bet));
    }

    public function testGagnantBonneVoieTeamB(){
        $game = $this->initGame(3, 6);

        $bet = $this->initBet(4, 5, $game);

        $this->assertEquals(1, GainPotential::checkResult($bet));
    }

    public function testPerdantBetTeamAGagnantTeamB(){
        $game = $this->initGame(3, 6);

        $bet = $this->initBet(6, 3, $game);

        $this->assertEquals(-1, GainPotential::checkResult($bet));
    }

    public function testPerdantBetTeamBGagnantTeamA(){
        $game = $this->initGame(3, 6);

        $bet = $this->initBet(6, 3, $game);

        $this->assertEquals(-1, GainPotential::checkResult($bet));
    }

}