<?php


namespace App\Controller;



use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class GererVilleController extends Controller{

        /**
         * @Route("gererVille", name="form_create")
         */
        public function create(EntityManagerInterface $entityManager, Request $request)
    {

        $ville = new Ville();

        $formVille = $this->createForm(VilleType::class, $ville);
        $ville = $entityManager->getRepository('App:Ville')->afficherVille();

        $formVille->handleRequest($request);

        if ($formVille->isSubmitted() && $formVille->isValid()) {

            $this->addFlash("success", "Votre ville a bien été enregistrée !");

            // Enregistrement dans la BDD
            $entityManager->persist($ville);
            $entityManager->flush();

            // Redirection
            return $this->redirectToRoute("form_create");
        }

        return $this->render('gererVille.html.twig', ["formVille" => $formVille->createView(), "ville" => $ville]);

    }




}