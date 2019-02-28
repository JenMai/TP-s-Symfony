<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event{

    /**@var \App\Entity\User
    */
    private $user;

    /**
     * @return \App\Entity\User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param \App\Entity\User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


}