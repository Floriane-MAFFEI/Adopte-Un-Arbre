<?php 

namespace App\DataFixtures\Provider;

class UserProvider
{
    private $user = [
        [
            'address' => '123 Rue des exemples',
            'city' => 'Paris',
            'zipcode' => '75001',
        ],
        [
            'address' => '456 Avenue des modèles',
            'city' => 'Lyon',
            'zipcode' => '69000',
        ],
        [
            'address' => '987 Boulevard des illustrations',
            'city' => 'Nantes',
            'zipcode' => '44000',
        ]

    ];

    private $manager =[
        [
            'address' => '654 Routes des Exemples',
            'city' => 'Strasbourg',
            'zipcode' => '67000',
        ],

    ];

    private $admin =[
        [
            'address' => '789 Rue du Soleil',
            'city' => 'Bordeaux',
            'zipcode' => '33000',
        ],

    ];
    
    public function getRandomUser()
    {
        return $this->user[array_rand($this->user)];
    }

    public function getRandomManager()
    {
        return $this->manager[array_rand($this->manager)];
    }

    public function getRandomAdmin()
    {
        return $this->admin[array_rand($this->admin)];
    }
}
