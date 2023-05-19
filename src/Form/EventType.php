<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('start')
            ->add('end')
            ->add('hide')
            ->add('is_published')
            ->add('created_at')
            ->add('status')
            ->add('address')
            ->add('zippcode')
            ->add('town')
            ->add('area')
            ->add('start_at')
            ->add('finished_at')
            ->add('coverFilename', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('longitudeStart_at')
            ->add('latitudeStart_at')
            ->add('longitudeFinish_at')
            ->add('latitudeFinish_at')
            ->add('user')
            
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}