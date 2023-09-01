<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Moto;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
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
            // ->add('client', EntityType::class, [
            //     'label' => 'client',
            //     'class' => Client::class,
            //     'choice_label' => 'name',
            //     'required' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moto::class,
        ]);
    }
}
