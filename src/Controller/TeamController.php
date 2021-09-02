<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Personne;
use App\Form\EquipeType;
use App\Form\PersonneType;
use App\Repository\EquipeRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EquipeRepository $repoE,PersonneRepository $repoP): Response
    {
      
        $equipe = new Equipe();
        $formEquipe= $this->createForm(EquipeType::class,$equipe);

        $personne = new Personne();
        $formPersonne = $this->createForm(PersonneType::class,$personne);

        return $this->render('base.html.twig', [
            'formEquipe' => $formEquipe->createView(),
            'formPersonne' => $formPersonne->createView(),
            'equipes' => $repoE->findAll(),
            'personnes' => $repoP->findAll()
        ]);
    }

     /**
     * @Route("/equipe/ajouter", name="equipe_ajouter")
     */
    public function ajouterEquipe(Request $req,EntityManagerInterface $em): Response
    {
        $equipe = new Equipe();
        $formEquipe= $this->createForm(EquipeType::class,$equipe);
        $formEquipe->handleRequest($req);
        $em->persist($equipe);
        $em->flush();
        return $this->redirectToRoute('home');
        
    }

        /**
     * @Route("/personne/ajouter", name="personne_ajouter")
     */
    public function ajouterPersonne(Request $req,EntityManagerInterface $em): Response
    {
        $personne = new Personne();
        $formPersonne = $this->createForm(PersonneType::class,$personne);
        $formPersonne->handleRequest($req);
        $equipe = $formPersonne->get('equipes')->getData();
        $personne->addEquipe($equipe);
        
        $em->persist($personne);
        $em->flush();
        return $this->redirectToRoute('home');
        
    }

        /**
     * @Route("/equipe/enlever/{equipe}", name="equipe_enlever")
     */
    public function enleverEquipe(Equipe $equipe,EntityManagerInterface $em): Response
    {
        $em->remove($equipe);
        $em->flush();
        return $this->redirectToRoute('home');
        
    }

    /**
     * @Route("/personne/enlever/{personne}", name="personne_enlever")
     */
    public function enleverPersonne(Personne $personne,EntityManagerInterface $em): Response
    {
        $em->remove($personne);
        $em->flush();
        return $this->redirectToRoute('home');
        
    }
    /**
    * @Route("/personne/equipe/enlever/{personne}/{equipe}", name="personne_equipe_enlever")
    */
   public function enleverPersonneEquipe(Personne $personne,Equipe $equipe,EntityManagerInterface $em): Response
   {
      
    $equipe->removePersonne($personne);
    $em->flush();
       return $this->redirectToRoute('home');
       
   }
}
