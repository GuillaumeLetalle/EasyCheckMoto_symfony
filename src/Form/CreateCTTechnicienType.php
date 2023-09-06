<?php

namespace App\Form;

use App\Entity\CT;
use App\Entity\Moto;
use App\Entity\Client;
use App\Repository\MotoRepository;
use App\Validator\DateTimeNotInDatabase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class CreateCTTechnicienType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('debut', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new DateTimeNotInDatabase(),
                ],
            ])
            ->add('client', EntityType::class, [
                'label' => 'client',
                'class' => Client::class,
                'choice_label' => 'name',
                'required' => true,
                'placeholder'=> 'Indiquer le client',
            ])
            ->add('vehicule_controle', EntityType::class, [
                'label' => 'moto',
                'class' => Moto::class,
                'choice_label' => 'immatriculation',
                'required' => true,
                'query_builder' => function (MotoRepository $er) {
                    return $er->createQueryBuilder('moto')
                        ->join('moto.client', 'c')  
                        ->addSelect('c')
                        ->orderBy('moto.immatriculation', 'ASC'); 
                },
                'placeholder'=> 'Indiquer la moto du client selectionné',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CT::class,
        ]);
    }
}
