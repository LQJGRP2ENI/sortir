<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class afficherProfilController extends Controller
{
    /**
     * @Route("/afficherProfil", name="afficherProfil", methods={"GET", "POST"})
     */
    public function afficherProfil (int $user_id){
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user_id);

        if (!$user){
            throw $this->createNotFoundException("Pas d'utilisateur trouvé pour l'ID".$user_id);
        }
        return $this->render("afficherProfil.html.twig", ["user"=>$user]);
    }
}