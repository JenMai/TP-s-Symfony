<?php

namespace App\EventListener;


use App\Entity\ActionUser;
use App\Event\ChoiceEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;

class ChoiceListener{

    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function onChoiceValidation(ChoiceEvent $event)
    {
        $direction = $event->getDirection();
        $user = $this->tokenStorage->getToken()->getUser();

        switch($direction){
            case"LEFT":
                $user->setPositionX($user->getPositionX() + 1);
                break;
            case"TOP":
                $user>setPositionY($user->getPositionY() - 1);
                break;
            case"RIGHT":
                $user->setPositionX($user->getPositionX() - 1);
                break;
            case"BOTTOM":
                $user->setPositionY($user->getPositionY() + 1);
                break;

        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function onChoiceValidationLogActionUser(ChoiceEvent $event){
        $actionUser = new ActionUser();
        $user = $this->tokenStorage->getToken()->getUser();

        $actionUser->setDirection($event->getDirection());
        $actionUser->setCreatedAt(new \DateTime('now'));
        $actionUser->setPositionX($user->getPositionX());
        $actionUser->setPositionY($user->getPositionY());
        $actionUser->setUser($user);

        $this->entityManager->persist($actionUser);
        $this->entityManager->flush();
    }

}