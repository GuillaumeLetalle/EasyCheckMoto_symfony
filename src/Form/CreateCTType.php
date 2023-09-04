<?php

namespace App\Form;

use App\Entity\CT;
use App\Entity\Moto;
use App\Repository\MotoRepository;
use App\Validator\DateTimeNotInDatabase;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class CreateCTType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $userId = $user->getId();
        $builder
            ->add('debut', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new DateTimeNotInDatabase(),
                ],
            ])
            ->add('vehicule_controle', EntityType::class, [
                'label' => 'moto',
                'class' => Moto::class,
                'query_builder' => function (MotoRepository $er) use ($userId) {
                    return $er->createQueryBuilder('moto')
                        ->where('moto.client = :user')
                        ->setParameter('user', $userId);
                },
                'choice_label' => 'immatriculation',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CT::class,
        ]);
    }
}
