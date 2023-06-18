<?php 

namespace App\DataFixtures\Provider;

class OrganismProvider 
{
    private $organism = [
        [
            'name' => 'Arbre Vivant',
            'description' => 'Arbre Vivant est une association qui promeut la protection et la plantation d\'arbres pour préserver la biodiversité.',
            'siret_insee' => '123456789',
            'adress' => '12 Rue des Chênes',
            'zip_code' => 75001,
            'city' => 'Paris',
            'phone_number' => "0123456789"
        ],
        [
            'name' => 'Les Amis des Arbres',
            'description' => 'Les Amis des Arbres est une association qui sensibilise le public à la protection des arbres et à la nécessité de les planter pour préserver l\'environnement.',
            'siret_insee' => '234567890',
            'adress' => '5 Rue des Sapins',
            'zip_code' => 69002,
            'city' => 'Lyon',
            'phone_number' => "0456789012"
        ],
        [
            'name' => 'Forêt Éternelle',
            'description' => 'Forêt Éternelle est une organisation qui travaille à la préservation des forêts anciennes pour maintenir leur biodiversité et leur rôle crucial dans le maintien du climat.',
            'siret_insee' => '345678901',
            'adress' => '7 Rue des Châtaigniers',
            'zip_code' => 33000,
            'city' => 'Bordeaux',
            'phone_number' => "0567890123"
        ],
        [
            'name' => 'Arboris',
            'description' => 'Arboris est une entreprise qui propose des solutions de plantation d\'arbres personnalisées pour les particuliers et les entreprises.',
            'siret_insee' => '456789012',
            'adress' => '3 Rue des Érables',
            'zip_code' => 44000,
            'city' => 'Nantes',
            'phone_number' => "0678901234"
        ],
        [
            'name' => 'Terre d\'Arbres',
            'description' => 'Terre d\'Arbres est une association qui oeuvre à la protection et à la restauration des forêts pour préserver les écosystèmes et la biodiversité.',
            'siret_insee' => '567890123',
            'adress' => '11 Rue des Pins',
            'zip_code' => 31000,
            'city' => 'Toulouse',
            'phone_number' => "0512345678"
        ],
        [
            'name' => 'Arbrissimo',
            'description' => 'Arbrissimo est une entreprise qui propose des solutions de plantation d\'arbres dans les villes pour améliorer la qualité de l\'air et l\'environnement urbain.',
            'siret_insee' => '789012345',
            'adress' => '4 Rue des Olivier',
            'zip_code' => 13000,
            'city' => 'Marseille',
            'phone_number' => "0456789012"
        ]
        
        ];

        public function getRandomorganism()
        {
            return $this->organism[array_rand($this->organism)];
        }

}
