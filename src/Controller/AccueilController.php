<?php


namespace App\Controller;


use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends Controller
{

    /**
     * @Route("/", name="accueil")
     */

    public function home(){

        return $this->render('accueil.html.twig');
    }
    /**
     * @Route("accueil", name="accueil", methods={"GET"})
     */
    public function select(EntityManagerInterface $entityManager){

        $sortie = $entityManager->getRepository('App:Sortie')->findAll();


        return $this->render('accueil.html.twig', ['sortie' => $sortie]);
    }










}