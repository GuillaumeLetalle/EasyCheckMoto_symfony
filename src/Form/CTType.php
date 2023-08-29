<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\CT;
use App\Entity\Moto;
use App\Entity\Technicien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('debut')
            // ->add('fin')
            ->add('vehicule_controle', EntityType::class, [
                'label' => 'moto',
                'class' => Moto::class,
                'choice_label' => 'immatriculation',
                'required' => true,
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
            ->add('commentaires')
            // ->add('client', EntityType::class, [
            //     'label' => 'client',
            //     'class' => Client::class,
            //     'choice_label' => 'name',
            //     'required' => true,
            // ])
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
