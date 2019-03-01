<?php

namespace App\EventListener;


use App\Entity\ActionUser;
use App\Event\ActionEvent;
use App\Event\UserEvent;
use App\Service\Action\ConvertAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ActionUserListener
{
    private $entityManager;
    private $token;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
    }

    public function onUserAction(ActionEvent $event){

        $actionUser = new ActionUser();
        $actionUser->setCreatedAt(new \DateTime('now'));
        $actionUser->setDirection($event->getAction());
        $actionUser->setPositionX($this->token->getUser()->getPositionX());
        $actionUser->setPositionY($this->token->getUser()->getPositionY());
        $actionUser->setUser($this->token->getUser());
        $this->entityManager->persist($actionUser);
        $this->entityManager->flush();
    }

    /*//nouveau listener
    public function onUserPosition(ActionEvent $event){
        $user = $this->token->getUser();
        $positionX = $user->getPositionX();
        $positionY = $user->getPositionY();

        if(($positionX === 0) && ($event->getAction() === "LEFT")){
            $event->stopPropagation();
        }

        if(($positionY === 0) && ($event->getAction() === "TOP")){
            $event->stopPropagation();
        }

    }*/
}