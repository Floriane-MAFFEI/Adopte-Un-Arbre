<?php

namespace App\Controller\Api;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PictureController extends AbstractController
{

/**
     * 
     * @Route("/api/pictures", name="api_picture_list", methods={"GET"})
     */
    public function list(PictureRepository $pictureRepository): JsonResponse
    {
        $pictures = $pictureRepository->findAll();

        return $this->json($pictures, Response::HTTP_OK, [], 
        ["groups" => ["picture_file","project_picture","tree_read", "specie"]]);
    }

    /**
     * Endpoint for a single picture
     * 
     * @param int $id id of the picture
     * 
     * @Route("/api/pictures/{id}", name="api_picture_read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read($id,
    PictureRepository $pictureRepository): JsonResponse
    {
        $picture = $pictureRepository->find($id);

        if ($picture === null){return $this->json("Image ou Photo non trouvée",Response::HTTP_NOT_FOUND);}
        
        return $this->json($picture, Response::HTTP_OK, [], 
        ["groups" => ["picture_file","project_picture","tree_read", "specie"]]);
    }

    /**
     * Endpoint to edit a specie
     * 
     * @Route("/api/pictures/{id}", name="api_picture_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, 
    Request $request, 
    PictureRepository $pictureRepository, 
    SerializerInterface $serializerInterface, 
    ValidatorInterface $validatorInterface): JsonResponse
    {
        $picture = $pictureRepository->find($id);

        if ($picture === null){return $this->json("Image ou Photo non trouvée",Response::HTTP_NOT_FOUND);}

        $jsonContent = $request->getContent();

        $serializerInterface->deserialize(
            $jsonContent,
            Picture::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $picture]);
        // Here the fusion between the database object (specie) and between the json object is done
        // ici la fusion entre l'objet BDD et l'objet JSON a été faite

        $errors = $validatorInterface->validate($picture);
        if (count($errors) > 0) {
            return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $pictureRepository->add($picture, true);

        return $this->json($picture, 200, [], ["groups" => ["picture_file","project_picture","tree_read", "specie"]]);
    }

    /**
     * Endpoint to add a picture
     * 
     * @Route("/api/pictures", name="api_picture_add", methods={"POST"})
     */
    public function add(PictureRepository $pictureRepository,
    Request $request,
    SerializerInterface $serializerInterface,
    ValidatorInterface $validatorInterface): JsonResponse
    {
        $jsonContent = $request->getContent();

        if ($jsonContent === ""){return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);}

        $picture = $serializerInterface->deserialize($jsonContent, Picture::class, 'json');

        $errors = $validatorInterface->validate($picture);
        if (count($errors) > 0) {return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);}

        $pictureRepository->add($picture, true);

        return $this->json($picture, 200, [], ["groups" => ["picture_file","project_picture","tree_read", "specie"]]);
    }

    /**
     * Endpoint to delete a picture
     * 
     * @Route("/api/pictures/{id}", name="api_picture_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(
        $id,
        PictureRepository $pictureRepository
        ): JsonResponse
    {
        // Fetch the object in the database
        $picture = $pictureRepository->find($id);

        // If we don't find it in the dabatase
        if ($picture === null){
            return $this->json(
                // Error message
                "Aucune espèce avec cet ID : " . $id,
                // code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }
        // Use the repository to remove
        $pictureRepository->remove($picture, true);
        // Send a reponse in json
        return $this->json(
            null,
            // code HTTP : 204 NO_CONTENT
            Response::HTTP_NO_CONTENT,
        );
    }


}


