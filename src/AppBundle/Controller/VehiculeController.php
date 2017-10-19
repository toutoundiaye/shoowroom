<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehicule;
use AppBundle\Form\VehiculeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class VehiculeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $vehicules = $this->getDoctrine()->getRepository(Vehicule::Class)->findAll();

        return $this->render('AppBundle:Vehicule:index.html.twig', array(
            'vehicules'=> $vehicules
        ));
    }

    /**
     * @Route("/create")
     */
    public function createAction(Request $request)
    {
        $vehicule = new Vehicule();

        $form = $this->createForm(VehiculeType::Class, $vehicule);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicule);
            $em->flush($vehicule);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Vehicule:create.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editAction(Request $request, $id)
    {
        $vehicule = $this->findById($id);

        $formEdit = $this->createForm(VehiculeType::Class, $vehicule);

        $formEdit->handleRequest($request);
        if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $em = $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Vehicule:edit.html.twig', array(
            'form'=> $formEdit->createView(),

        ));

    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $vehicule = $this->findById($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($vehicule);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    public function findById($id)
    {
        return $this
            ->getDoctrine()
            ->getRepository(Vehicule::Class)
            ->findOneBy(['id'=>$id]); 
    }

}
