<?php

namespace App\Form;

use App\Entity\Game;
use App\Repository\TeamRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\Form\Type\TeamType;

class GameType extends AbstractType
{
    private $team;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->team = $options['team'];

        $builder
            ->add('scoreTeamA')
            ->add('scoreTeamB')
            ->add('date')
            ->add('rating')
            ->add('teamA')
            ->add('teamB', TeamType::class);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $game = $event->getData();


        if ($this->team !== null) {

            $form->remove('scoreTeamA')->remove('scoreTeamB')->remove('date')->remove('rating')->remove('teamA')->remove('teamB');

            $game->setTeamA($this->team);
            $game->setDate(new \DateTime('now'));
            $game->setRating(2.0);


            $form->add('teamB', TeamType::class, [
                'query_builder' => function (TeamRepository $teamRepository) {
                    return $teamRepository->createQueryBuilder('team')
                        ->where('team.id <> :team')
                        ->orderBy('team.name', 'ASC')
                        ->setParameter('team', $this->team);// merci PHP7
                },
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'team' => null
        ]);
    }
}
