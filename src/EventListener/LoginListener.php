<?php

namespace App\EventListener;


use App\Event\UserEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LoginListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onUserCreate(UserEvent  $event)
    {
        $this->tokenStorage->setToken(
            new UsernamePasswordToken($event->getUser(), $event->getUser()->getPassword(), 'main', $event->getUser()->getRoles())
        );
    }
}