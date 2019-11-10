<?php

namespace App\Form;

use App\Entity\Plant;
use App\Entity\Species;
use App\Entity\Medium;
use App\Entity\Stage;
use App\Entity\Place;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PlantType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userLoggedIn = $this->security->getUser();
        $user = new User();
        $user= $userLoggedIn;
        $userID = $user->getId();

        //https://symfony.com/doc/current/reference/forms/types/entity.html
        $builder
            ->add('name')
            ->add('birth_date', DateType::class, [
                'placeholder' => [
                    'year' => 'Select the year', 'month' => 'Select the month', 'day' => 'Select the day',
                ]
            ])
            ->add('id_species', EntityType::class, [
                'class' => Species::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Type'
            ])
            ->add('id_medium', EntityType::class, [
                'class' => Medium::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Medium',
            ])
            ->add('id_stage', EntityType::class, [
                'class' => Stage::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Stage',
            ])
            ->add('id_place', EntityType::class, [
                'class' => Place::class,
                'query_builder' => function (EntityRepository $er) use ($userID) {
                    return $er->createQueryBuilder('place')
                        ->innerJoin('App\Entity\User', 'user', 'with', 'place.owner = user.id')
                        // ->leftJoin('place.plants', 'plant', 'with', 'plant.owner_id = user.id')
                        // ->innerJoin('place.plants', 'plant', 'with', 'plant.owner_id = place.owner')
                        //  ->andWhere('user.id = 2')
                        ->andWhere('user.id = :idUser')
                        ->setParameter('idUser', $userID)
                        ->orderBy('place.name', 'ASC')
                        ;
                },
                'choice_label' => 'name',
                'label' => 'Place',
            ])
            // TODO : continue here
            ->add('photoFile', FileType::class, [
                'mapped' => false,
                'label' => 'Please upload an image of your plant:',
                'attr' => [
                    //   'id'        =>  //default:plant_photoFile
                    'onchange'    => 'previewPlantFile()'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plant::class,
        ]);
    }
}
