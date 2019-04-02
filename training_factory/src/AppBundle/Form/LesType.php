<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class LesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', TimeType::class, [
                    'input' => 'string',
                    'widget' => 'choice'
                ])
            ->add('date')
            ->add('location')
            ->add('maxPersons')
            ->add('instructor', EntityType::class, [
                'class' => 'AppBundle:Person',
                'choice_label' => 'loginName',
            ])
            ->add('training', EntityType::class, [
                'class' => 'AppBundle:Training',
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Lesson'
        ]);
    }

}
