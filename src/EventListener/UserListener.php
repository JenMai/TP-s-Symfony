<?php

namespace App\EventListener;


use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;


class UserListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onUserCreateActive(UserEvent  $event)
    {
        if($event->getUser()->getPlainPassword() !== 'zoumzoum'){
            $event->getUser()->setEnabled(true);
        }
    }

    public function onUserCreate(UserEvent  $event)
    {
        $this->entityManager->persist($event->getUser());
        $this->entityManager->flush();
    }
}