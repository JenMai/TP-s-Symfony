<?php

namespace App\Form\Type;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TeamTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Team::class,
            'query_builder' => function (TeamRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.name', 'DESC');
            },
            'choice_label' => 'name',
            ]);
    }


    public function getParent(){
        return EntityType::class;
    }
}
