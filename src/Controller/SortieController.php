<?php


namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\LieuType;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends Controller
{
/**
 * @Route("create", name="create")
 */

public function create(EntityManagerInterface $em, Request $request){

    $sortie = new Sortie();


    $formSortie = $this->createForm(SortieType::class, $sortie);
    $formSortie->handleRequest($request);
   ;


    if ($formSortie->isSubmitted() && $formSortie->isValid()) {

        $this->addFlash("success", "Votre sortie a bien été enregistrée !");

        // Enregistrement dans la BDD
        $em->persist($sortie);
        $em->flush();

        // Redirection
        return $this->redirectToRoute("create");
    }

    return $this->render('/sortie.html.twig',
        ["formSortie" => $formSortie->createView()]);

}


}