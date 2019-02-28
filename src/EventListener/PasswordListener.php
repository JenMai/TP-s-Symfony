<?php

namespace App\EventListener;


use App\Event\UserEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordListener
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function onUserCreateSetPassword(UserEvent  $event)
    {
        $mdp = $this->encoder->encodePassword($event->getUser(), $event->getUser()->getPlainPassword());
        $event->getUser()->setPassword($mdp);

        if($event->getUser()->getPlainPassword() === 'zimzim'){
            $event->stopPropagation();
        }
    }
}