<?php
namespace App\Controller;

use App\Entity\Game;
use App\Service\ActionUser\Shoot;
use App\Event\AppEvent;
use App\Event\GameEvent;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
/**
 * @Route("/action-user")
 */
class ActionUserController extends AbstractController
{
    /**
     * @Route("/shoot/{id}", name="action_user_shoot", methods="GET")
     */
    public function shoot(Request $request, Game $game, Shoot $shoot): Response
    {
        $shoot->shoot($game, true);
        return $this->redirectToRoute('user_characters_index');
    }

    /**
     * @Route("/endGame/{id}", name="action_user_end_game", methods="GET")
     */
    public function endGame(Request $request, Game $game, GameEvent $gameEvent, EventDispatcherInterface $dispatcher): Response
    {
        $gameEvent->setGame($game);
        $dispatcher->dispatch(AppEvent::GameEnd, $gameEvent);

        return $this->redirectToRoute('user_characters_index');
    }
}