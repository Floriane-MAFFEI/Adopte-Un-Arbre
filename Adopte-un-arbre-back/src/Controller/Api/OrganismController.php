<?php

namespace App\Controller\Api;

use App\Entity\Organism;
use App\Repository\OrganismRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrganismController extends AbstractController
{

    /**
     * endpoint to get all organisms
     * @Route("/api/organisms", name="api_organism_list", methods={"GET"})
     */
    public function list(OrganismRepository $organismRepository, SerializerInterface $serializer): JsonResponse
    {
        //We retrieve all organisms
        $organisms = $organismRepository->findAll();
  
        // I retrieve all organisms with a 200 status code
        return $this->json($organisms, Response::HTTP_OK, [], ["groups" => ["Organism"]]);
    }


    /**
     * endpoint to get a single organism with details
     * @Route("/api/organisms/{id}", name="api_organism_read", methods={"GET"},requirements={"id"="\d+"})
     */
    public function read(Organism $organism)
    {

        // I retrieve the organism requested with a 200 status code
        return $this->json($organism, Response::HTTP_OK, [], ["groups" => ["Organism"]]);
    }

    /**
     * Endpoint to update an organism
     * @Route("/api/organisms", name="api_organism_add", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): JsonResponse

    {
        // I retrieve the data sent in the HTTP request and decode in JSON format
        $data = json_decode($request->getContent(), true);

        // I check if all required fields have been passed
        if (isset($data['name']) && isset($data['siret_insee']) && isset($data['description']) && isset($data['adress']) && isset($data['city']) && isset($data['zip_code']) && isset($data['phone_number'])) {

            // I create a new object Organism
            $organism = new Organism();

            // I update the Organism object with the data sent in the HTTP request
            $organism->setName($data['name']);
            $organism->setSiretInsee($data['siret_insee']);
            $organism->setDescription($data['description']);
            $organism->setAdress($data['adress']);
            $organism->setCity($data['city']);
            $organism->setZipCode($data['zip_code']);
            $organism->setPhoneNumber($data['phone_number']);
            $organism->setAvatar($data['avatar'] ?? null);

            // I manually check the validity of the entity
            $validator = Validation::createValidator();
            $errors = $validator->validate($organism);

            if (count($errors) > 0) {
                // If there are validation errors, return a response with a 400 status code
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
                }
                return $this->json(['success' => false, 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
            }

            // I save the new organism in the DB
            $entityManager->persist($organism);
            $entityManager->flush();

            // We return a response with a 201 status code and the new organism data
            return $this->json(['success' => true, 'data' => $organism], Response::HTTP_CREATED);
        } else {
            // If required data is missing, return a response with a 400 status code and an explanatory message
            return $this->json(['success' => false, 'error' => 'Missing required data'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Endpoint to update an organism
     * @Route("/api/organisms/{id}", name="api_organism_edit", methods={"PUT", "PATCH"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, Organism $organism): JsonResponse
    {
        // I retrieve the data sent in the HTTP request and decode in JSON format
        $data = json_decode($request->getContent(), true);

        // I check if the JSON data is empty and if empty I return a response with a 400 status code and an explanatory message
        if (empty($data)) {
            return $this->json(['success' => false, 'error' => 'Invalid JSON data'], Response::HTTP_BAD_REQUEST);
        }

        // Update the organism with the received data
        foreach ($data as $key => $value) {
            // I put the first character of my key in uppercase then I concatenate it with set in order to have my setter name
            $setter = 'set' . ucfirst($key);
            // I check if the method exists in the entity Organism and put the $value as argument
            if (method_exists($organism, $setter)) {
                $organism->$setter($value);
            }
        }

        // I manually check the validity of the entity
        $validator = Validation::createValidator();
        $errors = $validator->validate($organism);

        // If there are validation errors, return a response with a 400 status code
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json(['success' => false, 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        return $this->json(['success' => true, 'data' => $organism]);
    }


    /**
     * Endpoint for delete a organism
     * @Route("/api/organisms/{id}", name="api_organism_delete", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $entityManager, Organism $organism): JsonResponse
    {
        foreach ($organism->getProjects() as $project) {
            foreach ($project->getTrees() as $tree) {
                $entityManager->remove($tree);
            }
            $entityManager->remove($project);
        }

        foreach ($organism->getUsers() as $user) {
            $user->setOrganism(null);
        }

        $entityManager->remove($organism);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }
}
