<?php

namespace App\Form;

use App\Entity\Game;
use App\Form\Type\TeamTypeType;
use App\Form\Type\ScoreType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreTeamA', ScoreType::class)
            ->add('scoreTeamB', ScoreType::class)
            ->add('date')
            ->add('rating')
            ->add('teamA', TeamTypeType::class)
            ->add('teamB', TeamTypeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
