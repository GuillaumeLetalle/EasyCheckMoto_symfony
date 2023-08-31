<?php

namespace App\Form;

use App\Entity\CT;
use App\Entity\Moto;
use App\Entity\Client;
use App\Entity\Technicien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\DateType;
// use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CreateCTTechnicienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debut', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            // ->add('vehicule_controle', EntityType::class, [
            //     'label' => 'moto',
            //     'class' => Moto::class,
            //     'choice_label' => 'immatriculation',
            //     'required' => true,
            // ])
            ->add('client', EntityType::class, [
                'label' => 'client',
                'class' => Client::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            // ->add('technicien_controle', EntityType::class, [
            //     'label' => 'technicien',
            //     'class' => Technicien::class,
            //     'choice_label' => 'name',
            //     'required' => true,
            // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CT::class,
        ]);
    }
}
