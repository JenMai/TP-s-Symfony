<?php
namespace App\Controller;

use App\Entity\Game;
use App\Service\ActionUser\Shoot;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/user-action")
 */
class ActionUserController extends AbstractController
{
    /**
     * @Route("/shoot/{id}", name="action_user_shoot", methods="GET")
     */
    public function shoot(Game $game, Shoot $shoot): Response
    {
        $shoot->shoot($game, true);
        return $this->redirectToRoute('user_characters_index');
    }
}