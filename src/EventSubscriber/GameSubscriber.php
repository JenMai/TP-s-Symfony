<?php

namespace App\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\AppEvent;

class GameSubscriber implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onGameEnd($event)
    {
        $game = $event->getGame();
        $userCharacters = $game->getUserCharacters();

        $game->setEndGame(true);
        // TODO seulement un char a true
        $userCharacters->setDefaultCharacter(true);

        $this->entityManager->persist($game);
        $this->entityManager->persist($userCharacters);
        $this->entityManager->flush();
    }
    public static function getSubscribedEvents()
    {
        return [
           AppEvent::GameEnd => 'onGameEnd',
        ];
    }
}