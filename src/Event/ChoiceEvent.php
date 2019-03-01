<?php

namespace App\Event;

use App\Entity\ActionUser;
use Symfony\Component\EventDispatcher\Event;

class ChoiceEvent extends Event{
    private $direction;

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function setDirection(string $direction)
    {
        $this->direction = $direction;
    }


}