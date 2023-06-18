<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Security\Voter\UserVoter;
use App\Repository\UserRepository;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;


class UserController extends AbstractController
{
    /**
    * @Route("/api/users", name="api_user_browse",methods={"GET"})
     * 
     */
    public function browse(UserRepository $userRepository, Security $security): JsonResponse
    {   
        $allUser = $userRepository->findAll();

        if(!$security->isGranted("ROLE_ADMIN")) {
            throw $this->createAccessDeniedException();
        }

        return $this->json($allUser, 200, [], ["groups"=>["user_list","organism_list", "tree"]]);
    }

    /**
     * @Route("/api/users/{id}", name="api_user_read", requirements={"id"="\d+"}, methods={"GET"})
    */
    public function read($id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        $this->denyAccessUnlessGranted(UserVoter::READ_EDIT, $user);

        if ($user === null){return $this->json("id inexistant",Response::HTTP_NOT_FOUND);}

        return $this->json($user, 200, [], ["groups"=>["user_list","organism_list", "tree"]]);
    }

     /**
     * @Route("/api/users/{id}", name="api_user_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit(
        $id,
        Request $request,
        UserRepository $userRepository,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
        ): JsonResponse
    {
        $user = $userRepository->find($id);

        $this->denyAccessUnlessGranted(UserVoter::READ_EDIT, $user);

        if ( $user === null){return $this->json("message d'erreur",Response::HTTP_NOT_FOUND);}

        $jsonContent = $request->getContent();

        $serializerInterface->deserialize(
            $jsonContent,
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        // ici la fusion entre l'objet BDD et l'objet JSON a été faites

        $errors = $validatorInterface->validate($user);
        if (count($errors) > 0) {
            return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userRepository->add($user, true);

        return $this->json($user, 200, [], ["groups" => ["user_list","organism_list","tree"]]);
    }



    /**
     * @Route("/api/users/{id}", name="api_user_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(
        $id,
        UserRepository $userRepository
        ): JsonResponse
    {
        // 1. aller l'objet dans la BDD
        $user = $userRepository->find($id);

        // on a pas trouvé en BDD
        if ($user === null){
            return $this->json(
                // 1. un message d'erreur
                "Aucune utilisateur avec cet ID : " . $id,
                //2. code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }

        $this->denyAccessUnlessGranted(UserVoter::DELETE, $user);

        // 2. utiliser le repository pour faire un remove
        $userRepository->remove($user, true);
        // 3. on renvoit une réponse JSON
        return $this->json(
            // 1. aucune donnée à fournir, peut être un message
            null,
            //2. code HTTP : 204 NO_CONTENT
            Response::HTTP_NO_CONTENT,
        );
    }

    
    /**
    * @Route("/api/users", name="api_user_add", methods={"POST"})
    */
    public function add(
            UserRepository $userRepository,
            Request $request,
            SerializerInterface $serializerInterface,
            ValidatorInterface $validatorInterface,
            UserPasswordHasherInterface $passwordHasher): JsonResponse
        {
            $jsonContent = $request->getContent();
            // on reçoit aucun JSON
            if ($jsonContent === ""){return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);}
         

            $user = $serializerInterface->deserialize($jsonContent, User::class, 'json', ["groups" => ["user_register"]]);

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $errors = $validatorInterface->validate($user);
            if (count($errors) > 0) {return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);}

            $userRepository->add($user, true);
        return $this->json($user, 200, [], ["groups" => ["user_list","organism_list","tree"]]);
    }


    /**
     * Déconnexion
     * 
     * @Route("/api/logout", name="api_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // On ne peut pas laisser le controller vide: ça ne sera jamais appelé
        throw new \Exception('Il faut activer le logout dans security.yaml');
    }



}

