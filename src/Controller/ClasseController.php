<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Classe;
use App\Form\ClasseType;

class ClasseController extends AbstractController
{
    private $classeRepo;
    private $entityManager;

    public function __construct(ClasseRepository $classeRepositoryParam,EntityManagerInterface $entityManagerParam)
    {
        $this->classeRepo = $classeRepositoryParam; 
        $this->entityManager=$entityManagerParam;
    }

    #[Route('/classe', name: 'app_classe')]
    public function index(): Response
    {
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
        ]);
    }
    #[Route('/ClasseList', name: 'app_classeList', methods:['GET'])]
    public function ClasseList(): Response
    {
        $classes = $this->classeRepo->findAll(); 

        return $this->render('classe/ClasseList.html.twig', [
            'classes' => $classes,
        ]);
    }
    #[Route('/addClasse', name: 'app_addClasse')]
   public function addClasse(EntityManagerInterface $em, Request $request): Response
   {
       $classe = new Classe();
       $form = $this->CreateForm(ClasseType::class, $classe);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $em->persist($classe);
           $em->flush();
           return $this->redirectToRoute('classes');
       }
       return $this->render('classe/addClasse.html.twig', [
           'classe' => $classe,
           'form' => $form
       ]);
   }
   #[Route('/updateClasse/{id}', name: 'app_updateClasse', methods: ['GET'])]
    public function updateClasse(Classe $classe):Response{
        if($classe)
        {
            $Classe->setNom($id);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_classeList');
    }
    #[Route('/deleteClasse/{id}', name: 'app_deleteClasse', methods: ['GET','DELETE'])]
   public function deleteClasse(Classe $classe):Response{
    if ($classe) {
        $this->entityManager->remove($classe);
        $this->entityManager->flush();
    }
        return $this->redirectToRoute('app_classeList');
   }
}
