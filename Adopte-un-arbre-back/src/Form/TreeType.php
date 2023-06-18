<?php

namespace App\Form;

use App\Entity\Tree;
use App\Entity\Specie;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class,[
                'label' => 'Status',
                "choices" => [
                    "Pas encore planté" => "0", 
                    "Planté" => "1"
                ]
            ])
            ->add('origin', ChoiceType::class,[
                'label' => 'Origine',
                "choices" => [
                    "Europe" => "Europe", 
                    "Afrique" => "Afrique",
                    "Amérique" => "Amérique",
                    "Océanie" => "Océanie",
                    "Asie" => "Asie",
                ]
            ])
            ->add('price', IntegerType::class,[
                'label' => 'Prix',
            ])
            ->add('specie', EntityType::class, [
                'label' => 'Espèce',
                'class' => Specie::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez l\'espèce',
            ])
            ->add('project', EntityType::class, [
                'label' => 'Projet',
                'class' => Project::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez le projet',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tree::class,
        ]);
    }
}
