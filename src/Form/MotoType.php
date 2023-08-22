<?php

namespace App\Form;

use App\Entity\Moto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque')
            ->add('modele')
            ->add('cylindree')
            ->add('annee')
            ->add('immatriculation')
            ->add('client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moto::class,
        ]);
    }
}
