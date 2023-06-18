<?php

namespace App\Controller\Back;

use App\Entity\Tree;
use App\Form\TreeType;
use App\Entity\Project;
use App\Entity\Organism;
use App\Form\ProjectType;
use App\Form\OrganismType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackofficeController extends AbstractController
{

    /**
     * @Route("/", name="backoffice_index")
     */
    public function index()
    {
        return $this->render('back/index.html.twig');
    }

}