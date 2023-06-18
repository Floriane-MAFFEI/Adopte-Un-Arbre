<?php

namespace App\Controller\Api;

use App\Entity\Tree;
use App\Repository\TreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;


class TreeController extends AbstractController
{

    /**
     * Endpoint for all trees
     * 
     * @Route("/api/trees", name="api_tree_list", methods={"GET"})
     */
    public function list(TreeRepository $treeRepository): JsonResponse
    {
        $trees = $treeRepository->findAll();

        return $this->json(
            $trees,
            Response::HTTP_OK,
            [],
            ["groups" => ["tree_read", "specie", "project"]]
        );
    }

    /**
     * Endpoint for a single tree
     * 
     * @param int $id id of the tree
     * 
     * @Route("/api/trees/{id}", name="api_tree_read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(
        $id,
        TreeRepository $treeRepository
    ): JsonResponse {
        $tree = $treeRepository->find($id);
        if ($tree === null) {
            return $this->json("Arbre non trouvé", Response::HTTP_NOT_FOUND);
        }

        return $this->json($tree, Response::HTTP_OK, [], ["groups" => ["tree_read", "specie", "project"]]);
    }


    /**
     * Endpoint to edit a tree
     * @Route("/api/trees/{id}", name="api_tree_edit", requirements={"id"="\d+"}, methods={"PUT","PATCH"})
     */
    public function edit(
        $id,
        Request $request,
        TreeRepository $treeRepository,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
        // Security $security
    ): JsonResponse {

        //b-recup l'objet de la bdd a modifier
        $tree = $treeRepository->find($id);

        //dd($tree);
        if ($tree === null) {
            return $this->json("Arbre non trouvé", Response::HTTP_NOT_FOUND);
        }

        //a-recup les info de la requete
        $jsonContent = $request->getContent();
        //c-on transform en version json
        $serializerInterface->deserialize(
            //1. les données de la requete
            $jsonContent,
            //2. le type d'objet
            Tree::class,
            //3 le format des données
            'json',
            //4 le contexte càd l'objet qu'on souhaite maj avc les données
            // modification de la deserialization il remplis l'objet fournit au lieu d'en créeer un nouveau.
            [AbstractNormalizer::OBJECT_TO_POPULATE => $tree]
        );
        //dd($tree);


        //d- on verifie que les info sont valide (double validation en qlq sorte)
        $errors = $validatorInterface->validate($tree);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //dd($tree);
        //e-on fait la MAJ
        //les propriétés sont mise à jours par le deserializer.
        $treeRepository->add($tree, true);
        //dd($tree);
        return $this->json($tree, Response::HTTP_OK, [], ["groups" => ["tree_read", "specie", "project"]]);
    }

    /**
     * Endpoint for adding a tree
     * 
     * @Route("/api/trees", name="api_tree_add", methods={"POST"})
     */
    public function add(
        TreeRepository $treeRepository,
        Request $request,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse {
        // TODO : récupérer les informations venant de la requete
        $jsonContent = $request->getContent();
        // dd($jsonContent);
        // on reçoit aucun JSON
        if ($jsonContent === "") {
            return $this->json(
                "Le contenu de la requete est invalide",
                Response::HTTP_BAD_REQUEST
            );
        }

        // TODO créer une boucle
        // je récup mon arbre , déséralise
        // récup le champ particulier (nb d'arbre identiques à ajouter)
        // boucle de 0 à nb d'arbre, pour chacune des itérations je vais créer un arbre et l'enregistrer en bdd.


        //dd($jsonContent);
        // TODO : deserialiser le json
        // on a besoin du SerializerInterface
        $tree = $serializerInterface->deserialize(
            // la chaine de caractère reçu dans la requete
            $jsonContent,
            // le type d'objet dans lequel on veux transformer le contenu
            Tree::class,
            // le format du contenu
            'json'
        );
        // TODO : on valide que les données respecte les assertions
        // on a un service qui s'occupe de ça : validatorInterface
        // ? https://symfony.com/doc/current/validation.html#using-the-validator-service
        $errors = $validatorInterface->validate($tree);
        // on regarde si on a des erreurs dans le tableau d'erreurs en sortie de la validation
        if (count($errors) > 0) {
            return $this->json(
                // 1. les données
                $errors,
                // 2. le code d'erreur
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        //dd($tree);
        $treeRepository->add($tree, true);
        //dd($tree);
        return $this->json(

            // 1. les données à renvoyer : la transformation en json est automatique
            $tree,

            // 2. code HTTP
            200,
            // 3. pas d'entêtes particulière
            [],
            // 4. le contexte
            // dans le contexte on précise le nom du/des groupes de serialisation

            ["groups" =>  ["tree_read", "specie", "project"]]
        );
    }

    /**
     * @Route("/api/trees/{id}", name="api_tree_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     */
    public function delete(
        $id,
        TreeRepository $treeRepository
    ): JsonResponse {
        // 1. aller l'objet dans la BDD
        $tree = $treeRepository->find($id);
        // on a pas trouvé en BDD
        if ($tree === null) {
            return $this->json(
                // 1. un message d'erreur
                "Aucune utilisateur avec cet ID : " . $id,
                //2. code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }
        // 2. utiliser le repository pour faire un remove
        $treeRepository->remove($tree, true);
        // 3. on renvoit une réponse JSON
        return $this->json(
            // 1. aucune donnée à fournir, peut être un message
            null,
            //2. code HTTP : 204 NO_CONTENT
            Response::HTTP_NO_CONTENT,
        );
    }



    /**
     * Endpoint to the counter of all adopted trees
     * 
     * @Route("/api/trees/count", name="api_tree_count", methods={"GET"})
     *
     */
    public function count(
        EntityManagerInterface $entityManager
    ): JsonResponse {

        // We need to get the trees who got an user
        $count = $entityManager->createQueryBuilder()
            ->select('COUNT(t.id)')
            ->from(Tree::class, 't')
            ->where('t.user IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();
    
        return $this->json($count);
    }

    /**
     * Endpoint to adopt a tree 
     * 
     * @param int $id id of the tree
     * 
     * @Route("/api/trees/{id}/adopt", name="api_tree_adopt", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function adopt(
        $id,
        TreeRepository $treeRepository,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {

        $tree = $treeRepository->find($id);

        // Only to connected users
        if (!$security->isGranted("IS_AUTHENTICATED_FULLY")) {
            throw $this->createAccessDeniedException();
        }

        // Error if the tree is already bought
        if ($tree->getUser()) {
            return $this->json(
                "Cet arbre a déjà été adopté",
                Response::HTTP_BAD_REQUEST
            );
        } else {
            // Getting the current project
            $project = $tree->getProject();

            // Request: get in the project, get the trees where the user is null
            // Create the request
            $totalTrees = $treeRepository->createQueryBuilder('t')
                // WHERE to find the trees in the current project
                ->where('t.project = :projectid')
                // Setting parameters to get the id of the project
                ->setParameter('projectid', $project->getId())
                // Because "where" had already been used, we're doing "andWhere" to make a where again, and we precise to get the user who are null
                ->andWhere('t.user is NULL')
                // We're counting all the trees
                ->select('count(t.id)')
                // Execute
                ->getQuery()
                // Giving the result 
                ->getSingleScalarResult();
            
            // If the stock is inferior or equal to 0, it means we're out of stock
            if ($totalTrees <= 0) {
                return $this->json("Nous n'avons plus d'arbre en stock", Response::HTTP_BAD_REQUEST);
            }

            // getting the current user
            $user = $security->getUser();
            // setting the current user to the tree
            $tree->setUser($user);
            $entityManager->flush();

            return $this->json("L'arbre a bien été adopté !");
        }

        return $this->json("Arbre non trouvé", Response::HTTP_NOT_FOUND);
    }
}
