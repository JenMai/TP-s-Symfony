<?php

namespace App\Controller;


use App\Entity\ActionUser;
use App\Event\ActionEvent;
use App\Event\AppEvent;
use App\Form\Type\ActionType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\EventDispatcher\Event;

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
    public function game(Request $request, ActionEvent $event, EventDispatcherInterface $dispatcher, EntityManagerInterface $entityManager){

        $builder = $this->createFormBuilder();
        $builder->add('action', ActionType::class);
        $builder->add('submit', SubmitType::class, ['label' => 'Valid direction']);
        $form = $builder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $event->setAction($data['action']);
            $dispatcher->dispatch('user.action', $event);
            $dispatcher->dispatch('direction.cancel', $event);

            return $this->redirectToRoute('home_game');
        }

        $actionsUser = $entityManager->getRepository(ActionUser::class)->findBy(['user' => $this->getUser()]);

        return $this->render('home/game.html.twig', ['form' => $form->createView(), 'actionsUser' => $actionsUser]);
    }

    /**
     * @Route("/reset", name="home_reset", methods="GET|POST")
     */
    public function reset(Request $request, EventDispatcherInterface $dispatcher){
        $dispatcher->dispatch(AppEvent::UserReset, new Event());
        return $this->redirectToRoute('home_game');
    }
}
