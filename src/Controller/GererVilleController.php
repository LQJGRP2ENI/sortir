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
         * @Route("gererVille", name="creerVille", methods={"GET", "POST"})
         */
        public function create(EntityManagerInterface $em, Request $request)
    {

        $newVille = new Ville();
        $villes = $em->getRepository('App:Ville')->findAll();
        $formVille = $this->createForm(VilleType::class, $newVille);
        $formVille->handleRequest($request);

        if ($formVille->isSubmitted() && $formVille->isValid()) {

            $this->addFlash("success", "Votre ville a bien été enregistrée !");

            // Enregistrement dans la BDD
            $em->persist($newVille);
            $em->flush();

            // Redirection
            return $this->redirectToRoute("creerVille", [
                'villes' => $villes,
                'form' => $formVille->createView(),
            ]);
        }

        return $this->render('gererVille.html.twig',  [
            "formVille" => $formVille->createView(),
            'villes' => $villes,
            ]);

    }







}