<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\BetType;
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

    /**
     * @Route("/{id}", name="match_show", methods={"GET"})
     */
    public function show(Game $game): Response
    {
        return $this->render('match/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/new", name="match_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bet = new Bet();
        $form = $this->createForm(BetType::class, $bet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bet);
            $entityManager->flush();

            return $this->redirectToRoute('match_index');
        }

        return $this->render('match/new.html.twig', [
            'bet' => $bet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="match_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bet $bet): Response
    {
        $form = $this->createForm(BetType::class, $bet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('match_index', [
                'id' => $bet->getId(),
            ]);
        }

        return $this->render('match/edit.html.twig', [
            'bet' => $bet,
            'form' => $form->createView(),
        ]);
    }
}