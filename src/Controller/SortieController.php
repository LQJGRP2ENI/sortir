<?php


namespace App\Controller;


use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends Controller
{
    /**
     * @Route("create", name="create")
     */

    public function create(EntityManagerInterface $em, Request $request)
    {

        $sortie = new Sortie();

        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);

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

    /**
     * @Route("modifierSortie/{id}", name="modifierSortie", methods={"GET", "POST"})
     */
    public function update(Request $request, EntityManagerInterface $entityManager, $id)
    {

        $sortie = $entityManager->getRepository('App:Sortie')->find($id);
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'La sortie a bien été modifiée.');

            return $this->redirectToRoute('modifierSortie', array(
                'id' => $id));
        }

        return $this->render('modifierSortie.html.twig', [
            'sortie' => $sortie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="supprimerSortie", methods={"GET"})
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('App:Sortie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sortie entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/addInscription/{sortie_id}", name="addInscription", methods={"GET"})
     */
    public function Inscription($sortie_id, EntityManagerInterface $em)
    {
    }
}

