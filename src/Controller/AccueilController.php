<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends Controller
{

    /**
     * @Route("accueil", name="accueil")
     */

    public function home(){

        return $this->render('accueil.html.twig');
    }

}