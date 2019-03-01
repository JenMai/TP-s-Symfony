<?php

namespace App\Controller;


use App\Entity\ActionUser;
use App\Event\ChoiceEvent;
use App\Form\Type\DirectionType;
use App\Repository\GameRepository;
use App\Repository\ActionUserRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index", methods="GET")
     */
    public function index(Request $request, TranslatorInterface $translator, SessionInterface $session): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/game", name="home_game", methods="GET|POST")
     */
    public function game(Request $request, ChoiceEvent $choiceEvent, EventDispatcherInterface $dispatcher, ActionUserRepository $actionUserRepository, TokenStorageInterface $tokenStorage){

        $builder = $this->createFormBuilder();
        $builder->add('action', DirectionType::class);
        $builder->add('submit', SubmitType::class, ['label' => 'Valid direction']);
        $form = $builder->getForm();
        $logActionUsers = $actionUserRepository->findBy(['user' => $tokenStorage->getToken()->getUser()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //@todo
            $choiceEvent->setDirection($data['action']);
            $dispatcher->dispatch('choice.validation',$choiceEvent);



            return $this->redirectToRoute('home_game', ['logActionUsers' => $logActionUsers]); //@findMe -  pourquoi redirect ? = 1pt bonus
        }
        return $this->render('home/game.html.twig', ['form' => $form->createView(), 'logActionUsers' => $logActionUsers]);
    }

    /**
     * @Route("/reset", name="home_reset", methods="GET|POST")
     */
    public function reset(Request $request){

        //@todo

        return $this->redirectToRoute('home_game');
    }
}
