<?php 

namespace App\DataFixtures\Provider;

class ProjectProvider
{
    private $project = [
        [
            'name' => 'Forêt en ville',
            'description' => 'Ce projet consiste à planter des arbres dans les zones urbaines pour améliorer la qualité de l\'air et fournir un environnement plus agréable pour les citadins.',
            'localization' => 'Paris',
        ],
        [
            'name' => 'Reforestation en zone rurale',
            'description' => 'Ce projet consiste à planter des arbres dans des zones rurales pour restaurer des écosystèmes endommagés et améliorer la qualité de l\'eau.',
            'localization' => 'Bourgogne-Franche-Comté',
        ],
        [
            'name' => 'Forêt comestible',
            'description' => 'Ce projet consiste à planter des arbres fruitiers et des arbustes comestibles pour fournir des aliments frais et locaux à la communauté.',
            'localization' => 'Bretagne',
        ],
        [
            'name' => 'Plantation d\'arbres pour les abeilles',
            'description' => 'Ce projet consiste à planter des arbres qui fournissent du pollen et du nectar aux abeilles, afin de soutenir la population d\'abeilles et d\'autres pollinisateurs.',
            'localization' => 'Normandie',
        ],
        [
            'name' => 'Forêt urbaine pour l\'éducation',
            'description' => 'Ce projet consiste à créer une forêt urbaine pour sensibiliser les enfants et les adultes à la nature et à l\'importance de la conservation des écosystèmes.',
            'localization' => 'Marseille',
        ],
        [
            'name' => 'Reboisement pour la biodiversité',
            'description' => 'Ce projet consiste à planter une grande variété d\'arbres pour favoriser la biodiversité et restaurer les écosystèmes dégradés..',
            'localization' => 'Auvergne-Rhône-Alpes',
        ]

        ];

    private $status = [
        'En cours',
        'Terminé'
    ];

    public function getRandomproject()
    {
        return $this->project[array_rand($this->project)];
    }

    /**
     * get an array of status
     * 
     * @return array status
     */
    public function status(){
        return $this->status;
    }
}
