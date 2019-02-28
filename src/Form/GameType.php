<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;

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
            ->add('teamB')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $game = $event->getData();

        if($this->team !== null){
            $form->remove('teamA');
            $form->remove('rating');
            $form->remove('date');
            $game->setTeamA($this->team);
        }

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'team' => null,
        ]);
    }
}
