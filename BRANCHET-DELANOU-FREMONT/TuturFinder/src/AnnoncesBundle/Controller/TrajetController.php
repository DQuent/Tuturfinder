<?php

namespace AnnoncesBundle\Controller;

use AnnoncesBundle\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Trajet controller.
 *
 * @Route("trajet")
 */
class TrajetController extends Controller
{
    /**
     * Lists all trajet entities.
     *
     * @Route("/", name="trajet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trajets = $em->getRepository('AnnoncesBundle:Trajet')->findAll();

        return $this->render('trajet/index.html.twig', array(
            'trajets' => $trajets,
        ));
    }

    /**
     * Creates a new trajet entity.
     *
     * @Route("/new", name="trajet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trajet = new Trajet();
        $form = $this->createForm('AnnoncesBundle\Form\TrajetType', $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trajet);
            $em->flush($trajet);

            return $this->redirectToRoute('trajet_show', array('id' => $trajet->getId()));
        }

        return $this->render('trajet/new.html.twig', array(
            'trajet' => $trajet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trajet entity.
     *
     * @Route("/delete/{id}", name="trajet_show")
     * @Method("GET")
     */
    public function showAction(Trajet $trajet)
    {
        $deleteForm = $this->createDeleteForm($trajet);

        return $this->render('trajet/show.html.twig', array(
            'trajet' => $trajet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing trajet entity.
     *
     * @Route("/{id}/edit", name="trajet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Trajet $trajet)
    {
        $deleteForm = $this->createDeleteForm($trajet);
        $editForm = $this->createForm('AnnoncesBundle\Form\TrajetType', $trajet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trajet_edit', array('id' => $trajet->getId()));
        }

        return $this->render('trajet/edit.html.twig', array(
            'trajet' => $trajet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trajet entity.
     *
     * @Route("/{id}", name="trajet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Trajet $trajet)
    {
        $form = $this->createDeleteForm($trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trajet);
            $em->flush($trajet);
        }

        return $this->redirectToRoute('trajet_index');
    }

    /**
     * Creates a form to delete a trajet entity.
     *
     * @param Trajet $trajet The trajet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Trajet $trajet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trajet_delete', array('id' => $trajet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


     /**
     * rechercher un trajet
     *
     * @Route("/search", name="trajet_search")
     * 
     */
    public function searchAction()
    {
        // On crée un objet Utilisateur

        $trajet = new Trajet();

        // On crée le FormBuilder grâce au service form factory

        $form = $this->createForm(TrajetType::class, $trajet, array(
        'action' => $this->generateUrl('trajet_list_by_search'),
        'method' => 'POST',
        ));

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
            return $this->render('trajet/search.html.twig', array(
          'form' => $form->createView(),
            ));
    }


     /**
     * rechercher un trajet
     *
     * @Route("/search_result", name="trajet_list_by_search")
     * @Method("POST")
     */
    public function search_Result_Action()
    {
        // On crée un objet Utilisateur

        //$array_trajet = new array();

        //TODO : Method recherche tout les trajet selon les input de search.html.twig
         // $_POST parameters
        $villeDep = $request->request->get('rolesbundle_utilisateur')['villeDep'];
        $villeArr = $request->request->get('rolesbundle_utilisateur')['villeArr'];
    }





}
