<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Repository\ProjectRepository;
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

class ProjectController extends AbstractController
{
    /**
     * Endpoint for all projects
     * 
     * @Route("/api/projects", name="api_project_list", methods={"GET"})
     */
    public function list(ProjectRepository $projectRepository): JsonResponse
    {
        $projects = $projectRepository->findAll();

        return $this->json($projects, Response::HTTP_OK, [], 
        ["groups" => ["project_list","tree_read","specie", "project_picture","organism_list"]]);
    }

    /**
     * Endpoint for a single project
     * 
     * @param int $id id of the project
     * 
     * @Route("/api/projects/{id}", name="api_project_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read($id,
    ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);

        if ($project === null){return $this->json("Projet non trouvé",Response::HTTP_NOT_FOUND);}
        
        return $this->json($project, Response::HTTP_OK, [], 
        ["groups" => ["project_list","tree_read","specie", "project_picture","organism_list"]]);

    }

    /**
     * Endpoint to edit a project
     * 
     * @Route("/api/projects/{id}", name="api_project_edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, 
    Request $request, 
    ProjectRepository $projectRepository, 
    SerializerInterface $serializerInterface, 
    ValidatorInterface $validatorInterface): JsonResponse
    {
        $project = $projectRepository->find($id);

        if ($project === null){return $this->json("Projet non trouvé",Response::HTTP_NOT_FOUND);}

        $jsonContent = $request->getContent();

        $serializerInterface->deserialize(
            $jsonContent,
            Project::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $project]);
        // Here the fusion between the database object (project) and between the json object is done
        // ici la fusion entre l'objet BDD et l'objet JSON a été faite

        $errors = $validatorInterface->validate($project);
        if (count($errors) > 0) {
            return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $projectRepository->add($project, true);

        return $this->json($project, 200, [],   ["groups" => ["project_species"]]);
    }

    /**
     * Endpoint for adding a project
     * 
     * @Route("/api/projects", name="api_project_add", methods={"POST"})
     */
    public function add(ProjectRepository $projectRepository,
    Request $request,
    SerializerInterface $serializerInterface,
    ValidatorInterface $validatorInterface): JsonResponse
    {
        $jsonContent = $request->getContent();

        if ($jsonContent === ""){return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);}

        $project = $serializerInterface->deserialize($jsonContent, Project::class, 'json');

        $errors = $validatorInterface->validate($project);
        if (count($errors) > 0) {return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);}

        $projectRepository->add($project, true);

        return $this->json($project, 200, [],   ["groups" => ["project_list","tree","organism_list"]]);
    }


    /**
     * Endpoint for adding a project
     * 
     * @Route("/api/projects/{id}/species", name="api_project_specie", methods={"GET"})
     */
    public function readSpeciesByProject(
        Project $project,
        SpecieRepository $specieRepository,
        TreeRepository $treeRepository

    ): JsonResponse

    {
       
        $species = $specieRepository->findByProjectId($project->getId());
        $trees = [];
            foreach($species as $specie){
                $treesBySpecie = $treeRepository->findBy([
                    'specie'=>$specie,
                    'project'=>$project
                ]);
                $trees[]= [
                    'specie'=>$specie,
                    'trees' => $treesBySpecie,
                    'count' => count($treesBySpecie)
                ];
                //dump($trees);
            } 
        //dd($trees);
        if ($project === null){return $this->json("Projet non trouvé",Response::HTTP_NOT_FOUND);}
        
        return $this->json($trees, Response::HTTP_OK, [], ["groups" => ["project_species"]]);
        

    }

     /**
     * Endpoint to delete a project
     * 
     * @Route("/api/projects/{id}", name="api_project_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(
        $id,
        ProjectRepository $projectRepository
        ): JsonResponse
    {
        // Fetch the object in the database
        $project = $projectRepository->find($id);

        // If we don't find it in the dabatase
        if ($project === null){
            return $this->json(
                // Error message
                "Aucun projet avec cet ID : " . $id,
                // code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }
        // Use the repository to remove
        $projectRepository->remove($project, true);
        // Send a reponse in json
        return $this->json(
            null,
            // code HTTP : 204 NO_CONTENT
            Response::HTTP_NO_CONTENT,
        );
    }
}
