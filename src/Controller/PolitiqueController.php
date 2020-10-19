<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Affaire;
use App\Entity\Mairie;
use App\Entity\Parti;
use App\Entity\Politicien;

class PolitiqueController extends AbstractController
{
    public function index()
    {
        return $this->render('politique/index.html.twig');
    }

    public function navigation()
    {
        $user = $this->getUser();
        $lesAffaires = $this->getDoctrine()->getRepository(Affaire::class)->findAll();
        $lesMairies = $this->getDoctrine()->getRepository(Mairie::class)->findAll();
        $lesPartis = $this->getDoctrine()->getRepository(Parti::class)->findAll();
        $lesPoliticiens = $this->getDoctrine()->getRepository(Politicien::class)->findAll();
        return $this->render('politique/navigation.html.twig',array('lesAffaires' => $lesAffaires, 'lesMairies' => $lesMairies, 'lesPartis' => $lesPartis, 'lesPoliticiens' => $lesPoliticiens, 'user' => $user));
    }
}
