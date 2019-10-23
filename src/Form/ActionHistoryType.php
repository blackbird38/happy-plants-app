<?php

namespace App\Form;

use App\Entity\ActionHistory;
use App\Entity\Action;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      //      ->add('date')
            ->add('quantity')
            ->add('id_action', EntityType::class, [
                'class' => Action::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
       //     ->add('id_user')
        //    ->add('id_plant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActionHistory::class,
        ]);
    }
}
