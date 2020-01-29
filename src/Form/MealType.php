<?php

namespace App\Form;

use App\Entity\Ingestion;
use App\Entity\Meal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('ingestion', EntityType::class,[
                    'class' => Ingestion::class,
                    'label' => 'Ingestion',
                    'choice_label' => function(Ingestion $ingestion) {
                        return $ingestion->getName();
                    },
                'expanded' => true,
                'multiple' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
