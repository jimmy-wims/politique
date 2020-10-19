<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Affaire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use App\Form\Type\AffaireType;
use App\Entity\Politicien;

class AffaireController extends AbstractController
{
    public function ajouter(Request $request)
    {
		$affaire = new Affaire;
		$form = $this->createForm(AffaireType::class, $affaire,
			['action' => $this->generateUrl('affaire_ajouter')]);
			$form->add('submit', SubmitType::class,
			array('label' => 'Ajouter'));
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($affaire);
			$entityManager->flush();
			return $this->redirectToRoute('affaire_voir',
			array('id' => $affaire->getId()));
		}
		return $this->render('affaire/ajouter.html.twig',array('monFormulaire' => $form->createView()));
    }

    public function voir(int $id)
    {
        $affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
        if(!$affaire)
            throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
        return $this->render('affaire/voir.html.twig',array('affaire' => $affaire));
    }

    public function liste()
    {
        $affaires = $this->getDoctrine()->getRepository(Affaire::class)->findAll();
        return $this->render('affaire/liste.html.twig',array('affaires' => $affaires));
    }

    public function gererPoliticien($id) {
		$affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
		if(!$affaire)
			throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
		$form = $this->createFormBuilder($affaire,
			['action' => $this->generateUrl('affaire_politicien_suite',
				array('id' => $affaire->getId()))])
        ->add('lesPoliticiens', EntityType::class, [
            'class' => Politicien::class,
            'multiple' => true,
            'expanded' => true,
		])
		->add('modifier', SubmitType::class)
		->getForm();

		return $this->render('affaire/gererPoliticien.html.twig',array('affaire' => $affaire->getDesignation(), 'monFormulaire' => $form->createView()));
	}

	public function GererPoliticienSuite(Request $request, $id) {
		$affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
		if(!$affaire)
		 	throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
		$form = $this->createFormBuilder($affaire,
			['action' => $this->generateUrl('affaire_politicien_suite',
				array('id' => $affaire->getId()))])
        ->add('lesPoliticiens', EntityType::class, [
            'class' => Politicien::class,
            'multiple' => true,
            'expanded' => true,
		])
		->add('modifier', SubmitType::class)
		->getForm();
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			$entityManager = $this->getDoctrine()->getManager();
		 	$entityManager->persist($affaire);
		 	$entityManager->flush();
		 	$url = $this->generateUrl('affaire_voir',
		 		array('id' => $affaire->getId()));
		 	return $this->redirect($url);
		}
		return $this->render('affaire/gererPoliticien.html.twig',
		array('monFormulaire' => $form->createView()));
	}

	public function remove(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
        if(!$affaire)
            throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
        if($affaire->getLesPoliticiens()->count() != 0)
            throw $this->createNotFoundException('L\'affaire "'.$affaire->getDesignation().'" posséde des politiciens');
        $entityManager->remove($affaire);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('affaire_liste'));
    }

    public function chercher(Request $request)
	{
		$affaire = new Affaire();
		$form = $this->createFormBuilder($affaire)
		 ->add('designation', TextType::class)
		 ->add('chercher', SubmitType::class)
		 ->getForm();
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			$repo = $this->getDoctrine()->getManager()->getRepository(Affaire::class);
		 	$affaires = $repo->findByPartieDesignation($affaire->getDesignation());
		 	return $this->render('affaire/chercher.html.twig',array('affaires' => $affaires, 'monFormulaire' => $form->createView()));
		}
		return $this->render('affaire/chercher.html.twig',
		array('monFormulaire' => $form->createView()));
	}
}
