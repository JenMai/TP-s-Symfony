<?php

namespace App\EventSubscriber;

use App\Entity\ActionUser;
use App\Event\AppEvent;
use App\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\Event;

class ActionUserSubscriber implements EventSubscriberInterface{

    private $token;
    private $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->token = $tokenStorage->getToken();
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::UserReset => ['resetAllUserAction', 128]
        ];
    }

    public function resetAllUserAction(Event $event)
    {
        $actionsUser = $this->entityManager->getRepository(ActionUser::class)->findBy(['user' =>  $this->token->getUser()]);
        foreach($actionsUser as $actionUser){
            $this->entityManager->remove($actionUser);
        }
        $this->entityManager->flush();

    }
}