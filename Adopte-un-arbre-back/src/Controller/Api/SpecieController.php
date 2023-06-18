<?php

namespace App\Controller\Api;

use App\Entity\Specie;
use App\Repository\SpecieRepository;
use App\Repository\TreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Core\Security;



class SpecieController extends AbstractController
{
    /**
     * Endpoint for all species
     * 
     * @Route("/api/species", name="api_specie_list", methods={"GET"})
     */
    public function list(SpecieRepository $specieRepository): JsonResponse
    {
        $species = $specieRepository->findAll();

        return $this->json($species, Response::HTTP_OK, [], 
        ["groups" => ["specie_list","tree_list"]]);
    }

    /**
     * Endpoint for a single specie
     * 
     * @param int $id id of the specie
     * 
     * @Route("/api/species/{id}", name="api_specie_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read($id,
    SpecieRepository $specieRepository): JsonResponse
    {
        $specie = $specieRepository->find($id);

        if ($specie === null){return $this->json("Espèce non trouvée",Response::HTTP_NOT_FOUND);}
        
        return $this->json($specie, Response::HTTP_OK, [], 
        ["groups" => ["specie_list","tree_list"]]);
    }

    /**
     * Endpoint to edit a specie
     * 
     * @Route("/api/species/{id}", name="api_specie_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, 
    Request $request, 
    SpecieRepository $specieRepository, 
    SerializerInterface $serializerInterface, 
    ValidatorInterface $validatorInterface): JsonResponse
    {
        $specie = $specieRepository->find($id);

        if ($specie === null){return $this->json("Espèce non trouvée",Response::HTTP_NOT_FOUND);}

        $jsonContent = $request->getContent();

        $serializerInterface->deserialize(
            $jsonContent,
            Specie::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $specie]);
        // Here the fusion between the database object (specie) and between the json object is done
        // ici la fusion entre l'objet BDD et l'objet JSON a été faite

        $errors = $validatorInterface->validate($specie);
        if (count($errors) > 0) {
            return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $specieRepository->add($specie, true);

        return $this->json($specie, 200, [], ["groups" => ["specie_list","tree_list"]]);
    }

    /**
     * Endpoint for adding a specie
     * 
     * @Route("/api/species", name="api_specie_add", methods={"POST"})
     */
    public function add(SpecieRepository $specieRepository,
    Request $request,
    SerializerInterface $serializerInterface,
    ValidatorInterface $validatorInterface): JsonResponse
    {
        $jsonContent = $request->getContent();

        if ($jsonContent === ""){return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);}

        $specie = $serializerInterface->deserialize($jsonContent, Specie::class, 'json');

        $errors = $validatorInterface->validate($specie);
        if (count($errors) > 0) {return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);}

        $specieRepository->add($specie, true);

        return $this->json($specie, 200, [], ["groups" => ["specie_list","tree_list"]]);
    }

    /**
     * Endpoint to delete a specie
     * 
     * @Route("/api/species/{id}", name="api_specie_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(
        $id,
        SpecieRepository $specieRepository
        ): JsonResponse
    {
        // Fetch the object in the database
        $specie = $specieRepository->find($id);

        // If we don't find it in the dabatase
        if ($specie === null){
            return $this->json(
                // Error message
                "Aucune espèce avec cet ID : " . $id,
                // code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }
        // Use the repository to remove
        $specieRepository->remove($specie, true);
        // Send a reponse in json
        return $this->json(
            null,
            // code HTTP : 204 NO_CONTENT
            Response::HTTP_NO_CONTENT,
        );
    }


}
