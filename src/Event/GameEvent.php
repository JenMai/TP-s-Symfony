<?php

namespace App\Event;

use App\Entity\Game;
use Symfony\Component\EventDispatcher\Event;

class GameEvent extends Event{

    private $game;

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): void
    {
        $this->game = $game;
    }
}