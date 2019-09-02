<?php


namespace App\Controller;

use App\Form\ModifierType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModifierProfilController extends Controller
{
    /**
     * @Route("/modifierProfil", name="modifierProfil", methods={"GET", "POST"})
     */
    public function modifier (Request $request, EntityManagerInterface $em){
        $currentUser = $this -> getUser();

            $modifierForm = $this->createForm(ModifierType::class, $currentUser);

            $modifierForm->handleRequest($request);
            if ($modifierForm->isSubmitted() && $modifierForm->isValid()){
                $em->persist($currentUser);
                $em->flush();

                $this->addFlash("success", "Vos informations ont bien été modifiées.");

                return $this->redirectToRoute("modifierProfil");
            }
            return $this->render("modifierProfil.html.twig", [
                "modifierForm"=>$modifierForm->createView(),
            ]);
        }

}