<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/match")
 */
class MatchController extends AbstractController
{
    /**
     * @Route("/", name="match_index", methods={"GET"})
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('match/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    //TODO
    /**
     * @Route("/", name="match_bet", methods={"GET"})
     */
    public function bet(GameRepository $gameRepository): Response
    {
        return $this->render('match/bet.html.twig');
    }

    /**
     * @Route("/{id}", name="match_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('match/show.html.twig', [
            'game' => $game,
        ]);
    }
}