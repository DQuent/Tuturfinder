<?php

namespace RolesBundle\Controller;

use RolesBundle\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Voiture controller.
 *
 * @Route("voiture")
 */
class VoitureController extends Controller
{
    /**
     * Lists all voiture entities.
     *
     * @Route("/", name="voiture_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $voitures = $em->getRepository('RolesBundle:Voiture')->findAll();

        return $this->render('voiture/index.html.twig', array(
            'voitures' => $voitures,
        ));
    }

    /**
     * Creates a new voiture entity.
     *
     * @Route("/new", name="voiture_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $voiture = new Voiture();
        $form = $this->createForm('RolesBundle\Form\VoitureType', $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush($voiture);

            return $this->redirectToRoute('voiture_show', array('id' => $voiture->getId()));
        }

        return $this->render('voiture/new.html.twig', array(
            'voiture' => $voiture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a voiture entity.
     *
     * @Route("/{id}", name="voiture_show")
     * @Method("GET")
     */
    public function showAction(Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);

        return $this->render('voiture/show.html.twig', array(
            'voiture' => $voiture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing voiture entity.
     *
     * @Route("/{id}/edit", name="voiture_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Voiture $voiture)
    {
        $deleteForm = $this->createDeleteForm($voiture);
        $editForm = $this->createForm('RolesBundle\Form\VoitureType', $voiture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voiture_edit', array('id' => $voiture->getId()));
        }

        return $this->render('voiture/edit.html.twig', array(
            'voiture' => $voiture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a voiture entity.
     *
     * @Route("/{id}", name="voiture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Voiture $voiture)
    {
        $form = $this->createDeleteForm($voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($voiture);
            $em->flush($voiture);
        }

        return $this->redirectToRoute('voiture_index');
    }

    /**
     * Creates a form to delete a voiture entity.
     *
     * @param Voiture $voiture The voiture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Voiture $voiture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('voiture_delete', array('id' => $voiture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
