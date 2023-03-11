<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('address')
            ->add('zippcode')
            ->add('town')
            ->add('area')
            ->add('longitude')
            ->add('latitude')
            ->add('map')
            //->add('club', EntityType::class, [
             //       'class'=> Club::class,
              //      'choice_label' => 'title'
               //      ])
            ->add('coverFilename', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}