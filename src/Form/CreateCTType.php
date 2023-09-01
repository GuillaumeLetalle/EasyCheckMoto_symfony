<?php

namespace App\Form;

use App\Entity\CT;
use App\Entity\Moto;
use App\Repository\MotoRepository;
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
            ])
            // ->add('client', EntityType::class, [
            //     'label' => 'client',
            //     'class' => Client::class,
            //     'choice_label' => 'name',
            //     'required' => true,
            // ])
            // ->add('fin')
            // ->add('freinage')
            // ->add('direction')
            // ->add('visibilite')
            // ->add('eclairage_signalisation')
            // ->add('pneumatique')
            // ->add('carrosserie')
            // ->add('mecanique')
            // ->add('equipement')
            // ->add('pollution')
            // ->add('niveau_sonore')
            // ->add('moto_is_ok')
            // ->add('ctEffectue')
            // ->add('commentaires')
            // ->add('technicien_controle', EntityType::class, [
            //     'label' => 'technicien',
            //      'class' => Technicien::class,
            //      'choice_label' => 'name',
            //      'required' => true,
            //  ])
        ;
    }

    // private function getFilteredChoices(ClientRepository $clientRepository)
    //     {
    //         // Vous devez obtenir les éléments que vous souhaitez inclure dans le menu déroulant
    //         // Cela peut se faire en utilisant Doctrine, par exemple, pour interroger votre base de données.

    //         // Exemple avec Doctrine :

    //         $filteredChoices = $clientRepository->getMotos(['client_id'=> $this->getUser()]); // Remplacez par votre propre logique de requête

    //         // Transformez les éléments en un tableau de choix pour le menu déroulant
    //         $choices = [];
    //         foreach ($filteredChoices as $element) {
    //             $choices[$element->getId()] = $element->get(); // Remplacez par les méthodes de votre entité
    //         }

    //         return $choices;
    //     }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CT::class,
        ]);
    }
}
