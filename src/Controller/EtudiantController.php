<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Etudiant;

class EtudiantController extends AbstractController
{
    private $etudiantRepo;
    private $entityManager;

    public function __construct(EtudiantRepository $etudiantRepositoryParam,EntityManagerInterface $entityManagerParam)
    {
        $this->etudiantRepo = $etudiantRepositoryParam; 
        $this->entityManager=$entityManagerParam;
    }

    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }
    #[Route('/EtudiantList', name: 'app_etudiantList', methods:['GET'])]
    public function EtudiantList(): Response
    {
        $etudiants = $this->etudiantRepo->findAll(); 

        return $this->render('etudiant/EtudiantList.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }
}
