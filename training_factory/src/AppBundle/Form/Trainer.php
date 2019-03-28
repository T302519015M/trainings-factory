<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Trainer extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('loginName')
            ->add('password')
            ->add('firstName')
            ->add('prefix')
            ->add('lastName')
            ->add('dateOfBirth')
            ->add('gender' ,ChoiceType::class, ['choices'  =>
                [   'Man' => 'man',
                    'Vrouw' => 'vrouw',
                    'Anders' => 'anders',
                    'Geheim' => 'geheim',
                ],
            ])
            ->add('email')
            ->add('role' , ChoiceType::class, ['choices' =>
                [
                    'trainer' => 'ROLE_TRAINER',
                    'admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('hire_date')
            ->add('salary')
            ->add('street')
            ->add('postal_code')
            ->add('place')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Person'
        ]);
    }

}
