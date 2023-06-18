<?php

namespace App\Form;

use App\Entity\Organism;
use App\Entity\Tree;
use App\Entity\Specie;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OrganismType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom du projet',
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description du projet',
            'attr' => ['rows' => 4],
        ])
        ->add('siret_insee', IntegerType::class, [
            'label' => 'Numéro Siret/Insee',
        ])
        ->add('adress', TextType::class, [
            'label' => 'Nom de la rue',
            "attr" => [
                "placeholder" => "Rue de l'arbre"
            ],
        ])
        ->add('zip_code', IntegerType::class, [
            'label' => 'Code postal',
            "attr" => [
                "placeholder" => "00000"
            ],
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville',
            "attr" => [
                "placeholder" => "Arbre sur terre"
            ],
        ])
        ->add('phone_number', IntegerType::class, [
            'label' => 'Numéro de téléphone',
            "attr" => [
                "placeholder" => "0000000000"
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organism::class,
        ]);
    }
}
