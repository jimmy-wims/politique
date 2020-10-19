<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Parti;

class PartiController extends AbstractController
{
    public function ajouter(Request $request)
    {
        $parti = new Parti;
        $form = $this->createFormBuilder($parti)
        ->add('nom', TextType::class)
        ->add('ajouter', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parti);
            $entityManager->flush();
            return $this->redirectToRoute('parti_voir',
            array('id' => $parti->getId()));
        }
        return $this->render('parti/ajouter.html.twig',
        array('monFormulaire' => $form->createView()));
    }

    public function voir(int $id)
    {
        $parti = $this->getDoctrine()->getRepository(Parti::class)->find($id);
        if(!$parti)
            throw $this->createNotFoundException('Parti[id='.$id.'] inexistant');
        $age = 0;
        $nbFemme = 0;
        $nbPoliticien = 0;
        foreach ($parti->getLespoliticiens() as $politicien) {
            if($politicien->getSexe() == 'F')
                $nbFemme = $nbFemme + 1;
            $age = $age + $politicien->getAge();
            $nbPoliticien = $nbPoliticien + 1;
        }
        if($nbPoliticien != 0) {
            //calcul age moyen
            $age = $age / $nbPoliticien;
            //Pourcentage de femme
            $nbFemme = $nbFemme/$nbPoliticien*100;

            return $this->render('parti/voir.html.twig',array('parti' => $parti,"ageMoyen" => $age, "nbFemme" => $nbFemme, "nbHomme" => (100-$nbFemme)));
        } else {
            $age = 0;
            $femme = 0;
            return $this->render('parti/voir.html.twig',array('parti' => $parti,"ageMoyen" => $age, "nbFemme" => $nbFemme, "nbHomme" => $nbFemme));
        }
    }

    public function liste()
    {
        $partis = $this->getDoctrine()->getRepository(Parti::class)->findAll();
        return $this->render('parti/liste.html.twig',array('partis' => $partis));
    }

    public function remove(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $parti = $this->getDoctrine()->getRepository(Parti::class)->find($id);
        if(!$parti)
            throw $this->createNotFoundException('Parti[id='.$id.'] inexistant');
        if($parti->getLesPoliticiens()->count() != 0)
            throw $this->createNotFoundException('Le Parti "'.$parti->getNom().'" posséde des politiciens');
        $entityManager->remove($parti);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('parti_liste'));
    }
}
