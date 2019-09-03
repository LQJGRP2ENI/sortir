<?php


namespace App\Controller;


use App\Entity\Sortie;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AfficherSortieController extends Controller
{

    /**
     * @Route("afficherSortie/{id}", name="afficher_sortie", methods={"GET", "POST"})
     */

    public function afficherSortie(Request $request, EntityManagerInterface $em){
       $id = $request->get('id');

       $sortie = $this->getDoctrine()
           ->getRepository(Sortie::class)
           ->find($id);

       return $this->render('afficherSortie', ["sortie" => $sortie]);

    }




}