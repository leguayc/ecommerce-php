<?php

namespace App\Form;

use App\Entity\UserAdress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adress')
            ->add('cp')
            ->add('city')
            ->add('country')
            ->add('name')
            ->add('firstName')
            ->add('phoneNumber')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAdress::class,
        ]);
    }
}
