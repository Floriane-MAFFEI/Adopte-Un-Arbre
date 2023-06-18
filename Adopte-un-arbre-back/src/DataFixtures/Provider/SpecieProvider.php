<?php 

namespace App\DataFixtures\Provider;

class SpecieProvider 
{
    private $species = [
        [
            'name' => 'Chêne',
            'scientific_name' => 'Quercus Robur L.',
            'description' => 'Un arbre à feuilles caduques qui est commun en France, et qui peut atteindre jusqu\'à 40 mètres de hauteur.'
        ],
        [
            'name' => 'Tilleul',
            'scientific_name' => 'Tilia',
            'description' => 'Un arbre à feuilles caduques qui est connu pour ses fleurs parfumées et son bois doux qui est utilisé pour fabriquer des meubles.'
        ],
        [
            'name' => 'Hêtre',
            'scientific_name' => 'Fagus sylvatica',
            'description' => 'Un arbre à feuilles caduques qui est commun en Europe et qui est connu pour sa capacité à produire des feuilles denses qui fournissent une ombre dense.'
        ],
        [
            'name' => 'Chêne-liège',
            'scientific_name' => 'Quercus suber',
            'description' => 'Un arbre à feuilles caduques qui est commun en Europe et qui est connu pour sa capacité à produire des feuilles denses qui fournissent une ombre dense.'
        ],
        [
            'name' => 'If',
            'scientific_name' => ' Taxus baccata',
            'description' => 'Un arbre à feuilles persistantes qui est cultivé pour son bois précieux et pour la taxol, un médicament anticancéreux dérivé de son écorce.'
        ],
        [
            'name' => 'Pin',
            'scientific_name' => 'Pinus mugo',
            'description' => 'Un arbre à feuilles persistantes qui est commun dans les montagnes d\'Europe et qui est utilisé pour l\'ornementation dans les jardins.'
        ],
        [
            'name' => 'Erable',
            'scientific_name' => 'Acer campestre',
            'description' => 'Un arbre à feuilles caduques qui est cultivé pour son bois dur et dense, et qui peut atteindre jusqu\'à 20 mètres de hauteur.'
        ],
        [
            'name' => 'Platane',
            'scientific_name' => 'Platanus x hispanica',
            'description' => 'Un arbre à feuilles caduques qui est cultivé pour son tronc massif et son feuillage dense, et qui peut atteindre jusqu\'à 30 mètres de hauteur.'
        ],
        [
            'name' => 'Frêne',
            'scientific_name' => 'Fraxinus excelsior',
            'description' => 'Un arbre à feuilles caduques qui est cultivé pour son bois dur et élastique, et qui peut atteindre jusqu\'à 40 mètres de hauteur.'
        ],
        [
            'name' => 'Cyprès',
            'scientific_name' => 'Cupressus sempervirens',
            'description' => ' Un arbre à feuilles persistantes qui est cultivé pour son feuillage dense et pour son utilisation en tant qu\'arbre d\'ornementation, et qui peut atteindre jusqu\'à 25 mètres de hauteur.'
        ],
        [
            'name' => 'Mélèze',
            'scientific_name' => 'Larix decidua',
            'description' => 'Un arbre à feuilles caduques qui est cultivé pour son bois résistant et pour son utilisation en tant qu\'arbre d\'ornementation, et qui peut atteindre jusqu\'à 30 mètres de hauteur.'
        ]
    ];


    public function getRandomspecie()
    {
        return $this->species[array_rand($this->species)];
    }
}