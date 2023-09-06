<?php

namespace App\Form;

use App\Entity\CT;
use App\Entity\Moto;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class CTType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicule_controle', EntityType::class, [
                'label' => 'moto',
                'class' => Moto::class,
                'choice_label' => 'immatriculation',
                'required' => true,
                'disabled' => true,
            ])
            ->add('client', EntityType::class, [
                'label' => 'client',
                'class' => Client::class,
                'choice_label' => 'name',
                'required' => true,
                'disabled' => true,
             ])
            ->add('freinage')
            ->add('direction')
            ->add('visibilite')
            ->add('eclairage_signalisation')
            ->add('pneumatique')
            ->add('carrosserie')
            ->add('mecanique')
            ->add('equipement')
            ->add('pollution')
            ->add('niveau_sonore')
            ->add('moto_is_ok')
            ->add('ctEffectue', CheckboxType::class, [
                'label'    => 'Contrôle Technique effectué',
                'required' => false,
            ])
            ->add('commentaires');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CT::class,
        ]);
    }
}
