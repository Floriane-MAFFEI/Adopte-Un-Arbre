<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Organism;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AbstractType
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
            ->add('localization', ChoiceType::class, [
                'label' => 'Région du projet',
                "choices" => [
                    "Auvergne-Rhône-Alpes" => "Auvergne-Rhône-Alpes",
                    "Bourgogne Franche Comté"=>"Bourgogne Franche Comté",
                    "Bretagne"=>"Bretagne",
                    "Centre-Val de Loire" => "Centre-Val de Loire",
                    "Grand Est" => "Grand Est",
                    "Hauts-de-France" => "Hauts-de-France",
                    "Ile-de-France" => "Ile-de-France",
                    "Normandie" => "Normandie"
                ],

            ])
            ->add('stock', IntegerType::class,[
                "label" => "Nombre d'arbre dans le projet",
                "attr" => [
                    "placeholder" => "Nombre d'arbre"
                ],
            ])
            ->add('start_at', DateType::class,[
                "label" => "Date de début",
                "input" => "datetime_immutable",
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('organism', EntityType::class, [
                'label' => 'Organisme',
                'class' => Organism::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un organisme',
            ])
            ->add('evolution', IntegerType::class,[
                'data' => 0,
                'attr' => [
                    'hidden' => true,
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Avancement du projet',
                "choices" => [
                    "Commence Bientôt" => "0",
                    "En cours"=>"1",
                    "Terminé"=>"2",
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
