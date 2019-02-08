<?php
/**
 * Created by PhpStorm.
 * User: jennifer.maillot
 * Date: 07/02/19
 * Time: 12:10
 */

namespace App\Service\Bet;

use App\Entity\Bet;

class GainPotential
{
    const PERFECT = 3;
    const GOOD = 1;
    const FAIL = -1;

    static function checkResult(Bet $bet){

        if(!$bet instanceof Bet)
            throw new \InvalidArgumentException('Argument must be of type Bet');

        // score exacte
        if (($bet->getScoreTeamA() === $bet->getGame()->getScoreTeamA()) && ($bet->getScoreTeamB() === $bet->getGame()->getScoreTeamB())){
            return self::PERFECT;
        }
        // bonne issue - team A win
        if (($bet->getScoreTeamA() > $bet->getScoreTeamB()) && ($bet->getGame()->getScoreTeamA() > $bet->getGame()->getScoreTeamB())){
            return self::GOOD;
        }
        // bonne issue - team B win
        if (($bet->getScoreTeamB() > $bet->getScoreTeamA()) && ($bet->getGame()->getScoreTeamB() > $bet->getGame()->getScoreTeamA())){
            return self::GOOD;
        }

        return self::FAIL;

    }

}