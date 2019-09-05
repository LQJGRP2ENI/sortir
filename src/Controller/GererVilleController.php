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

    /**
     * @Route("modifierVille/{id}", name="modifierVille", methods={"GET", "POST"})
     */
    public function update(Request $request, EntityManagerInterface $entityManager, $id)
    {

        $ville = $entityManager->getRepository('App:Ville')->find($id);
        $formVilles = $this->createForm(VilleType::class, $ville);
        $formVilles->handleRequest($request);

        if ($formVilles->isSubmitted() && $formVilles->isValid()) {
            $entityManager->persist($ville);
            $entityManager->flush();
            $this->addFlash('success', 'La ville a bien été modifiée.');

            return $this->redirectToRoute('modifierVille', array(
                'id' => $id));
        }

        return $this->render('modifierVille.html.twig', [
            'ville' => $ville,
            'formVilles' => $formVilles->createView()
        ]);
    }
    /**
     * @Route("/deleteVille/{id}", name="supprimerVille", methods={"GET"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('App:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirectToRoute('creerVille');
    }








}