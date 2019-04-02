<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('loginName', TextType::class ,array('label' => 'Gebruikersnaam'))
            ->add('password', PasswordType::class, array('label' => 'Wachtwoord'))
            ->add('passCheck', PasswordType::class, array('label' => 'Wachtwoord bevestigen','mapped' => false))
            ->add('firstName', TextType::class, array('label' => 'Voornaam'))
            ->add('prefix', TextType::class, array('label' =>'tussenvoegsel'))
            ->add('lastName', TextType::class, array('label' =>'Achternaam'))
            ->add('dateOfBirth', null, array('label'=>'geboortedatum'))
            ->add('gender' ,ChoiceType::class, ['choices'  =>
                [   'Man' => 'man',
                    'Vrouw' => 'vrouw',
                    'Anders' => 'anders',
                    'Geheim' => 'geheim',
                ],'label'=>'geslacht'
            ])
            ->add('email')
            ->add('street', TextType::class, ['label'=> 'straat'] )
            ->add('postal_code', TextType::class, ['label' => 'postcode'] )
            ->add('place', TextType::class, ['label'=>'plaats'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Person'
        ]);
    }

}