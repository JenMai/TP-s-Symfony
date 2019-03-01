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

class UserSubscriber implements EventSubscriberInterface{

    private $encoder;
    private $entityManager;
    private $token;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->token = $tokenStorage->getToken();
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::UserEdit => [['userPersist', 0], ['userEditPassword', 128]], //celui le plus haut repond avant le plus bas
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
            AppEvent::UserReset => [['resetPosition', 0], ['checkAction', 256]]
        ];
    }

    public function onAuthenticationFailure( AuthenticationFailureEvent $event )
    {

        echo 'failed login ! ';
    }

    public function onSecurityInteractiveLogin( InteractiveLoginEvent $event )
    {
         echo 'login ok ! : '.$event->getAuthenticationToken()->getUser()->getEmail();
    }

    public function userPersist(UserEvent $event){

        $this->entityManager->persist($event->getUser());
        $this->entityManager->flush();
    }

    public function userEditPassword(UserEvent $event){

        if($event->getUser()->getPlainPassword() !== ''){
            $mdp = $this->encoder->encodePassword($event->getUser(), $event->getUser()->getPlainPassword());
            $event->getUser()->setPassword($mdp);
        }
    }

    public function resetPosition(Event $event){
        $this->token->getUser()->setPositionX(0);
        $this->token->getUser()->setPositionY(0);
        $this->entityManager->persist($this->token->getUser());
        $this->entityManager->flush();
    }

    public function checkAction(Event $event){
        $actionsUser = $this->entityManager->getRepository(ActionUser::class)->findBy(['user' =>  $this->token->getUser()]);
        if(count($actionsUser) < 10 ){
            $event->stopPropagation();
        }
    }
}