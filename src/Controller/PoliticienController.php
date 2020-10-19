<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Politicien;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\PoliticienType;


class PoliticienController extends AbstractController
{
    public function ajouter(Request $request)
    {
		$politicien = new Politicien;
		$form = $this->createForm(PoliticienType::class, $politicien,
			['action' => $this->generateUrl('politicien_ajouter')]);
			$form->add('submit', SubmitType::class,
			array('label' => 'Ajouter'));
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($politicien);
			$entityManager->flush();
			return $this->redirectToRoute('politicien_voir',
			array('id' => $politicien->getId()));
		}
		return $this->render('politicien/ajouter.html.twig',array('monFormulaire' => $form->createView()));
    }

    public function voir(int $id)
    {
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistant');
        return $this->render('Politicien/voir.html.twig',array('politicien' => $politicien));
    }

    public function liste()
    {
        $politiciens = $this->getDoctrine()->getRepository(Politicien::class)->findAll();
        return $this->render('politicien/liste.html.twig',array('politiciens' => $politiciens));
    }

    public function modifier($id) {
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistant');
        $form = $this->createForm(PoliticienType::class, $politicien,
            ['action' => $this->generateUrl('politicien_modifier_suite',
                array('id' => $politicien->getId()))]);
            $form->add('submit', SubmitType::class,
            array('label' => 'Modifier'))
        ->remove('nom');

        return $this->render('politicien/modifier.html.twig',array('politicien' => $politicien->getNom(), 'monFormulaire' => $form->createView()));
    }

    public function modifierSuite(Request $request, $id) {
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistant');
        $form = $this->createForm(PoliticienType::class, $politicien,
            ['action' => $this->generateUrl('politicien_modifier_suite',
                array('id' => $politicien->getId()))]);
            $form->add('submit', SubmitType::class,
            array('label' => 'Modfier'))
        ->remove('nom');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($politicien);
            $entityManager->flush();
            $url = $this->generateUrl('politicien_voir',
                array('id' => $politicien->getId()));
            return $this->redirect($url);
        }
        return $this->render('politicien/modifier.html.twig',array('politicien' => $politicien->getNom(), 'monFormulaire' => $form->createView()));
     }

    public function remove(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistant');
        $entityManager->remove($politicien);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('politicien_liste'));
    }
}
