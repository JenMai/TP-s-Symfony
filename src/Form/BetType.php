<?php

namespace App\Form;

use App\Entity\Bet;
use App\Form\Type\ScoreType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scoreTeamA', ScoreType::class)
            ->add('scoreTeamB', ScoreType::class)
            ->add('amout')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bet::class,
        ]);
    }
}