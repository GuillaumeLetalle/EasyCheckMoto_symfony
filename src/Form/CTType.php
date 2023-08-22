<?php

namespace App\Form;

use App\Entity\CT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debut')
            ->add('fin')
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
            ->add('vehicule_controle')
            ->add('technicien_controle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CT::class,
        ]);
    }
}
