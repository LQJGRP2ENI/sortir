<?php


namespace App\Controller;


use App\Entity\Sortie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherSortieController extends Controller
{

    /**
     * @Route("afficherSortie", name="afficherSortie")
     */

    public function afficherSortie( int $sortie_id){
       $sortie = $this->getDoctrine()
           ->getRepository(Sortie::class)
           ->find($sortie_id);
       return $this->render('afficherSortie', ["sortie" => $sortie]);

    }




}