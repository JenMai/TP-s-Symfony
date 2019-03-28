<?php

namespace App\Form;

use App\Entity\UserProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserProductType extends AbstractType
{
    private $product;
    private $securityChecker;
    private $token;

    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $token)
    {
        $this->securityChecker = $securityChecker;
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->product = $options['product'];

        $builder
            ->add('quantity')
            ->add('createdAt')
            ->add('user')
            ->add('product')
            ->add('userOrder')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event){
        $form = $event->getForm();
        $userProduct = $event->getData();

        $userProduct->setUser($this->token->getToken()->getUser());
        $userProduct->setProduct($this->product);
        $userProduct->setCreatedAt(new \DateTime('now'));
        $form->remove('price');
        $form->remove('createdAt');
        $form->remove('user');
        $form->remove('userOrder');

        if($this->product !== null){
            $userProduct->setProduct($this->product);
            $form->remove('product');
        }

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserProduct::class,
            'product' => null
        ]);
    }
}
