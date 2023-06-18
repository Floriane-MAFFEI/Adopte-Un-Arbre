<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tree;
use App\Entity\User;
use App\Entity\Specie;
use DateTimeImmutable;
use App\Entity\Picture;
use App\Entity\Project;
use App\Entity\Organism;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\Provider\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\SpecieProvider;
use App\DataFixtures\Provider\ProjectProvider;
use App\DataFixtures\Provider\OrganismProvider;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiFixtures extends Fixture
{
    // Declaration of a private variable to store  the passwordHasher Object
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        // Assignment of the UserPasswordHasherInterface object passed.
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $entityManager): void
    {
        // Installation of the faker in the method and I define it in fr and I import the provider
        $faker = Factory::create("fr_FR");

        // Create a Faker instance of SpecieProvider
        $faker->addProvider(new SpecieProvider());

        //! Fixture Species

        // Initializing an empty list to store instances of Species
        $specieList = [];

        for ($i = 0; $i < 11; $i++) {

            // Get random data for a species from the $faker object
            // getRandomspecie is used to get species-specific random data
            // The unique property before the method call indicates that we want the generated organism data to be unique
            $specieData = $faker->unique->getRandomspecie();

            // Creates a new instance of the Specie class
            $specie = new Specie();

            // Sets the Specie's name from the retrieved random data
            $specie->setName($specieData['name']);

            // Defines the scientifc name of the species from the retrieved random data
            $specie->setScientificName($specieData['scientific_name']);

            // Defines the description of the species from the retrieved random data
            $specie->setDescription($specieData['description']);

            // Add the specie instance to the $specieList
            $specieList[] = $specie;

            // Persist the Specie instance in the database
            $entityManager->persist($specie);
        }

        //! Fixture Organisms

        // Create a Faker instance of OrganismProvider
        $faker->addProvider(new OrganismProvider());

        // Initializing an empty list to store instances of Organisms
        $organismList = [];

        for ($i = 0; $i < 6; $i++) {

            // Get random data for a organism from the $faker object
            // getRandomorganism is used to get organisms-specific random data
            // The unique property before the method call indicates that we want the generated organism data to be unique
            $organismData = $faker->unique->getRandomorganism();

            // Creates a new instance of the Organism class
            $organism = new Organism();

            // Sets the organism's name from the retrieved random data
            $organism->setName($organismData['name']);

            // Defines the description of the organism from the retrieved random data
            $organism->setDescription($organismData['description']);

            // Defines the siret of the organism from the retrieved random data
            $organism->setSiretInsee($organismData['siret_insee']);

            // Defines the adress of the organism from the retrieved random data
            $organism->setAdress($organismData['adress']);

            // Defines the zipCode of the organism from the retrieved random data
            $organism->setZipCode($organismData['zip_code']);

            // Defines the City of the organism from the retrieved random data
            $organism->setCity($organismData['city']);

            // Defines the PhoneNumber of the organism from the retrieved random data
            $organism->setPhoneNumber($organismData['phone_number']);

            // I set the user's avatar using a generated URL based on the index of the loop
            $organism->setAvatar("https://i.pravatar.cc/150?img=" . $i);

            // Add the organism instance to the $specieList
            $organismList[] = $organism;

            // Persist the Specie instance in the database
            $entityManager->persist($organism);
        }


        //! Fixture Projects

        // Create a Faker instance of ProjectProvider
        $faker->addProvider(new ProjectProvider());

        // Creates an instance of the DateTime class to store the current date
        $currentDate = new \DateTime();

        // Initializing an empty list to store instances of projects
        $projectList = [];

        for ($i = 0; $i < 6; $i++) {

            // Get random data for a project from the $faker object
            // getRandomproject is used to get project-specific random data
            // The unique property before the method call indicates that we want the generated project data to be unique
            $projectData = $faker->unique->getRandomproject();

            // Creates a new instance of the project class
            $project = new Project();

            // Sets the Project's name from the retrieved random data
            $project->setName($projectData['name']);

            // Defines the description of the project from the retrieved random data
            $project->setDescription($projectData['description']);

            // Defines the localization of the project from the retrieved random data
            $project->setLocalization($projectData['localization']);

            // A random number between 0 and 100 is generated by the numberBetween() method of the $faker object in order to set the stock randomly.
            $project->setStock($faker->numberBetween(10, 500));

            // Generate a random start date for the project via the dateTimeBetween() method of the $faker object.
            // Then convert it to an instance of the DateTimeImmutable class.
            $startDate = new DateTimeImmutable($faker->dateTimeBetween('-1year', '+6months')->format('Y-m-d'));
            // And finally, the start date is set for the project.
            $project->setStartAt($startDate);

            // A random number between 0 and 100 is generated by the numberBetween() method of the $faker object in order to set the evolution randomly.
            $project->setEvolution($faker->numberBetween(0, 100));

            // I start by checking if the project has an evolution of less than 100 and if the project has started
            if ($project->getEvolution() < 100 && $startDate < $currentDate) {
                // If yes then I set the status of to "en cours"
                $project->setStatus('En cours');
                // Otherwise I check if the start date of the project has not yet arrived
            } elseif ($startDate > $currentDate) {
                // If yes then I set the status of to "Commence bientôt" and the Evolution is set to 0
                $project->setStatus('Commence bientôt');
                $project->setEvolution(0);
                // If I reach this stage, it means that the start date has passed and that the evolution of the project has reached 100
            } else {
                // I then change the status of the project to "Terminé"
                $project->setStatus('Terminé');
            }

            // I assign an organism to the project by selecting a random organism from my $organismList
            // For this I use the numberBetween() method of the $faker object is used to generate the random index among those available in the list
            $project->setOrganism($organismList[$faker->numberBetween(0, count($organismList) - 1)]);

            // Add the project instance to the $projectList
            $projectList[] = $project;

            // Persist the project instance in the database
            $entityManager->persist($project);
        }


        // ! Fixtures Users

        // Create a Faker instance of UserProvider
        $faker->addProvider(new UserProvider());

        // * Fixtures Admin

        // I create only one admin

        // Get random data for an admin from the $faker object
        // getRandomAdmin is used to get admin-specific random data
        // The unique property before the method call indicates that we want the generated admin data to be unique
        $adminData = $faker->unique->getRandomAdmin();

        // Creates a new instance of the User class for the admin
        $admin = new User();

        // I define the email address directly in the parameters of the setEmail
        $admin->setEmail("admin@oclock.io");
        // I define the firstname directly in the parameters of the setFirstName
        $admin->setFirstname("admin");
        // I set the admin last name using a random first name generated by the $faker object
        $admin->setLastname($faker->lastName());

        // I set the admin's date of birth using a random date between 70 and 18 generated by the $faker object
        $admin->setDateOfBirth(new DateTimeImmutable($faker->dateTimeBetween('-70years', '-18years')->format('Y-m-d')));
        // I set the admin address using the address data obtained from the $adminData array
        $admin->setAddress($adminData['address']);
        // I set the admin ZipCode using the address data obtained from the $adminData array
        $admin->setZipCode($adminData['zipcode']);
        // I set the admin city using the address data obtained from the $adminData array
        $admin->setCity($adminData['city']);
        // I define the roles of the administrator as an array containing a single role, which is "ROLE_ADMIN" and I pass it as a parameter of the setRoles
        $admin->setRoles(["ROLE_ADMIN"]);

        // I set the user's avatar using a generated URL based on the index of the loop
        $admin->setAvatar("https://i.pravatar.cc/150?img=" . $faker->numberBetween(0, 50), 0, '.', '');

        // Set the user's password using the passwordHasher
        $admin->setPassword($this->passwordHasher->hashPassword($admin, "admin"));

        // Persist the admin instance in the database
        $entityManager->persist($admin);


        // * Fixtures manager

        // I create only one manager

        // Get random data for an manager from the $faker object
        // getRandommanager is used to get manager-specific random data
        $managerData = $faker->getRandomManager();

        // Creates a new instance of the User class for the manager
        $manager = new User();

        // I define the email address directly in the parameters of the setEmail
        $manager->setEmail("manager@oclock.io");
        // I define the firstname directly in the parameters of the setFirstName
        $manager->setFirstname("manager");
        // I set the manager last name using a random first name generated by the $faker object
        $manager->setLastname($faker->lastName());

        // I set the manager's date of birth using a random date between 70 and 18 generated by the $faker object
        $manager->setDateOfBirth(new DateTimeImmutable($faker->dateTimeBetween('-70years', '-18years')->format('Y-m-d')));
        // I set the manager address using the address data obtained from the $adminData array
        $manager->setAddress($managerData['address']);
        // I set the admin ZipCode using the address data obtained from the $adminData array
        $manager->setZipCode($managerData['zipcode']);
        // I set the admin city using the address data obtained from the $adminData array
        $manager->setCity($managerData['city']);
        // I define the roles of the manager as an array containing a single role, which is "ROLE_MANAGER" and I pass it as a parameter of the setRoles
        $manager->setRoles(["ROLE_MANAGER"]);

        // I set the user's avatar using a generated URL based on the index of the loop
        $manager->setAvatar("https://i.pravatar.cc/150?img=" . $i);

        // Set the user's password using the passwordHasher
        $manager->setPassword($this->passwordHasher->hashPassword($manager, "manager"));

        // Persist the manager instance in the database
        $entityManager->persist($manager);


        // * Fixtures user

        // Shuffle the $organismList array to randomize the order of its elements
        // The shuffle method is a native PHP method
        shuffle($organismList);

        for ($i = 0; $i < 10; $i++) {
            // Generate a random umber between 0 and 10
            $aleatoire = mt_rand(0, 10);

            // Get random data for an user from the $faker object
            // getRandomUser is used to get user-specific random data
            $userData = $faker->getRandomUser();

            // Creates a new instance of the User class for the users
            $user = new User();

            // Create the user's email according to the index of the loop using a concatenation
            $user->setEmail("user" . $i . "@oclock.io");

            // Create the user's firstname according to the index of the loop using a concatenation
            $user->setFirstname("user" . $i);

            // I set the user last name using a random first name generated by the $faker object
            $user->setLastname($faker->lastName());

            // I set the user's date of birth using a random date between 70 and 18 generated by the $faker object
            $user->setDateOfBirth(new DateTimeImmutable($faker->dateTimeBetween('-70years', '-18years')->format('Y-m-d')));

            // I set the user address using the address data obtained from the $userData array
            $user->setAddress($userData['address']);
            // I set the user ZipCode using the address data obtained from the $userData array
            $user->setZipCode($userData['zipcode']);
            // I set the user City using the address data obtained from the $userData array
            $user->setCity($userData['city']);
            // I define the roles of the user as an array containing a single role, which is "ROLE_USER" and I pass it as a parameter of the setRoles
            $user->setRoles(["ROLE_USER"]);

            // Set the user's password using the passwordHasher
            $user->setPassword($this->passwordHasher->hashPassword($user, "user"));

            // I set the user's avatar using a generated URL based on the index of the loop
            $user->setAvatar("https://i.pravatar.cc/150?img=" . $i);

            // I check if the random number is greater than 4 and if the loop index is within the bounds of the $organismList array
            if ($aleatoire > 4 && $i < count($organismList)) {
                // I set the user's organism to the corresponding value in the $organismList array
                $user->setOrganism($organismList[$i]);
            } else {
                // Set the user's organism to NULL
                $user->setOrganism(null);
            }

            // Persist the user instance in the database
            $entityManager->persist($user);
        }


        // ! Fixture Pictures

        // I iterate over each species in the specieList array 
        foreach ($specieList as $specie) {

            // Get a random project from the projectList array
            $project = $projectList[$faker->numberBetween(0, count($projectList) - 1)];

            // Get the species name from the specie array
            $specieName = $specie->getName();

            // I create the name of the image file by concatenating the species name and the ".jpg" extension
            $imageName = $specieName . '.jpg';

            // I create the image path by concatenating the base directory, the relative path and the image file name
            $imagePath = __DIR__ . '/../../public/images/species/' . $imageName;

            // Creates a new instance of the Picture class for the pictures
            $picture = new Picture();
            // Set the image via the parameter of setFileName by including the element $imagePath
            $picture->setFileName($imagePath);

            // Creates a new instance of the tree class for the trees
            $tree = new Tree();
            // Set tree status to 1
            $tree->setStatus(1);
            // Set the origin of the tree to a value chosen randomly from the array ['Europe']
            $tree->setOrigin($faker->randomElement(['Europe']));
            // Set the price of the tree to a random value between 10 and 50
            $tree->setPrice($faker->numberBetween(10, 50));

            // Set the species of the tree to the current specie in the iteration
            $tree->setSpecie($specie);
            // Set the project of the tree to the randomly chosen project
            $tree->setProject($project);

            // Associate the tree with the picture
            $picture->setTree($tree);
            // Associate the picture with the project
            $picture->setProject($project);

            // Persist the tree instance in the database
            $entityManager->persist($tree);
            // Persist the picture instance in the database
            $entityManager->persist($picture);
        }

        //! Fixture Trees

        // Initializing an empty list to store instances of tree
        $treeList = [];

        for ($i = 0; $i < 10; $i++) {

            // Creates a new instance of the tree class for the trees
            $tree = new Tree();

            // Get a random project from the projectList array
            $project = $projectList[$faker->numberBetween(0, count($projectList) - 1)];

            // Check if the status of the project is either 'En cours' or 'Terminé'
            if ($project->getStatus() === 'En cours' || $project->getStatus() === 'Terminé') {
                // Set the status of the tree to 1 (active)
                $tree->setStatus(1);
            } else {
                // Set the status of the tree to 0 (inactive)
                $tree->setStatus(0);
            }

            // Set the origin of the tree to a randomly chosen value from the array ['Europe']
            $tree->setOrigin($faker->randomElement(['Europe']));
            // Set the price of the tree to a random value between 10 and 50
            $tree->setPrice($faker->numberBetween(10, 50));

            // Get a random project from the projectList array
            $specie = $specieList[$faker->numberBetween(0, count($specieList) - 1)];

            // Set the specie of the tree to the random specie
            $tree->setSpecie($specie);
            // Set the project of the tree to the random project
            $tree->setProject($project);

            // Add the tree instance to the $treeList
            $treeList[] = $tree;

            // Persist the tree instance in the database
            $entityManager->persist($tree);
        }

        // I flush in order to save in DB the objects that have been persisted
        $entityManager->flush();
    }
}
