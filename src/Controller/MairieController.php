<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Mairie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MairieController extends AbstractController
{
    public function ajouter(Request $request)
    {
        $mairie = new Mairie;
        $form = $this->createFormBuilder($mairie)
        ->add('ville', TextType::class)
        ->add('ajouter', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mairie);
            $entityManager->flush();
            return $this->redirectToRoute('mairie_voir',
            array('id' => $mairie->getId()));
        }
        return $this->render('mairie/ajouter.html.twig',
        array('monFormulaire' => $form->createView()));
    }

    public function voir(int $id)
    {
        $mairie = $this->getDoctrine()->getRepository(Mairie::class)->find($id);
        if(!$mairie)
            throw $this->createNotFoundException('Mairie[id='.$id.'] inexistante');
        return $this->render('mairie/voir.html.twig',array('mairie' => $mairie));
    }

    public function liste()
    {
        $mairies = $this->getDoctrine()->getRepository(Mairie::class)->findAll();
        return $this->render('mairie/liste.html.twig',array('mairies' => $mairies));
    }

    public function remove(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $mairie = $this->getDoctrine()->getRepository(Mairie::class)->find($id);
        if(!$mairie)
            throw $this->createNotFoundException('Mairie[id='.$id.'] inexistante');
        if($mairie->getLesPoliticiens()->count() != 0)
            throw $this->createNotFoundException('La Mairie "'.$mairie->getVille().'" posséde des politiciens');
        $entityManager->remove($mairie);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('mairie_liste'));
    }
}
