<?php


namespace App\Controller;



use App\Entity\Archive;
use App\Entity\Sortie;

use App\Form\ArchiveType;
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
        $sortie->setDateHeureDebut(new \Datetime());
        $sortie->setDateLimiteInscription(new \Datetime());
        $archive = new Archive();

        $sortie->setArchive($archive);

        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {

            $this->addFlash("success", "Votre sortie a bien été enregistrée !");

            // Enregistrement dans la BDD
            $em->persist($sortie);
            $em->persist($archive);
            $em->flush();

            // Redirection
            return $this->redirectToRoute("accueil");
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
     * @Route("/delete/{id}", name="annulerSortie", methods={"GET", "POST"})
     */
    public function delete(Request $request, EntityManagerInterface $em, $id)
    {

        //Récupération archive
        $sortie = $em->getRepository('App:Sortie')->find($id);
        $archive = $em->getRepository('App:Archive')->find($sortie->getArchive()->getId());

        //Transmission des valeurs de sortie à archive
        $archive->setNom($sortie->getNom());
        $archive->setDateHeureDebut($sortie->getDateHeureDebut());

        //Gestion formulaire
        $formMotif = $this->createForm(ArchiveType::class, $archive);
        $formMotif->handleRequest($request);

        if ($formMotif->isSubmitted()&&$formMotif->isValid()){
            $em->persist($archive);
            $em->persist($sortie);
            $em->remove($sortie);
            $em->flush();

            $this->addFlash('success', 'La sortie a bien été supprimée.');
            return $this->redirectToRoute('accueil');
        }
        return $this->render('annulerSortie.html.twig', [
            'sortie' => $sortie,
            'formMotif' => $formMotif->createView()
        ]);

    }
    /**
     * @Route("/addInscription/{sortie_id}", name="addInscription", methods={"GET"})
     */
    public function Inscription($sortie_id, EntityManagerInterface $em)
    {
        //Réunion infos
        $currentUser = $em->getRepository('App:User')->find($this->getUser());
        $sortie = $em->getRepository('App:Sortie')->find($sortie_id);

        //Si date limite inscription dépassée : avertissement et redirection
        if ($sortie->getdateLimiteInscription()<date("dd/mm/yyyy")){
            $this->addFlash("warning", "Date limite d'inscription dépassée!");
            return $this->redirectToRoute('accueil');
        }
        //Si le nombre d'inscrits est égal au nombre de places disponibles: redirection
        if ($sortie->getUsers()->count()>=$sortie->getNbInscriptionMax()){
            $this->addFlash("warning", "La sortie est complète!");
            return $this->redirectToRoute('accueil');
        }

        //Vérifier si l'utilisateur est déjà inscrit
        if ($sortie->getUsers()->contains($currentUser)){
            $this->addFlash("warning", "Vous êtes déjà inscrit");
            return $this->redirectToRoute('accueil');
            //L'inscription est ignorée
        } else {
            //Si non: inscription
            $sortie->inscription($currentUser);
            //persist/flush
            $em->persist($sortie);
            $em->flush();
            //redirection
            $this->addFlash("success", "Vous avez bien été inscrit!");
            return $this->redirectToRoute('accueil');
        }
    }

    /**
     * @Route("/desistement/{sortie_id}", name="desistement", methods={"GET"})
     */
    public function Desistement ($sortie_id, EntityManagerInterface $em)
    {
        //Réunion infos
        $currentUserID = $this->getUser();
        $sortie = $em->getRepository(Sortie::class)->find($sortie_id);
        if ($sortie->getDateHeureDebut()<date("dd/mm/yyyy")) {
            $this->addFlash("warning", "La sortie est déjà commencée!");
            return $this->redirectToRoute('accueil');
        } else {
            //Recherche de la bonne inscription
            $sortie = $em->getRepository('App:Sortie')->find($sortie_id);

            if (!$sortie) {
                $this->addFlash("warning", "Vous n'êtes pas inscrit à cette sortie!");
                return $this->redirectToRoute('accueil');
            }

            $currentUser = $em->getRepository('App:User')->find($currentUserID);
            if (!$currentUser) {
                $this->addFlash("warning", "Vous n'êtes pas inscrit à cette sortie!");
                return $this->redirectToRoute('accueil');
            }
            //Désistement
            $sortie->desistement($currentUser);

            //persist/flush
            $em->persist($sortie);
            $em->flush();

            //redirection avec message Flash
            $this->addFlash("success", "Vous vous êtes bien désisté!");
            return $this->redirectToRoute('accueil');
        }
    }

}

