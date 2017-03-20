<?php

namespace AnnoncesBundle\Controller;

use AnnoncesBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AnnoncesBundle\Entity\Annonce;
use RolesBundle\Entity\Utilisateur;

/**
 * Reservation controller.
 *
 * @Route("reservation")
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     * @Route("/", name="reservation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservations = $em->getRepository('AnnoncesBundle:Reservation')->findAll();

        return $this->render('reservation/index.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     * @Route("/new", name="reservation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm('AnnoncesBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush($reservation);

            return $this->redirectToRoute('reservation_show', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reservation entity.
     *
     * @Route("/show/{id}", name="reservation_show")
     * @Method("GET")
     */
    public function showAction(Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);

        return $this->render('reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     * @Route("/{id}/edit", name="reservation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('AnnoncesBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     * @Route("delete/{id}", name="reservation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reservation $reservation)
    {
        $form = $this->createDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush($reservation);
        }

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Affiche les réservation de l'utilisateur
     *
     * @Route("/vos_reservations", name="vos_reservations")
     * @Method("GET")
     */
    public function vos_reservationsAction(Request $request)
    {    
         //récupération de toutes les réservation de l'utilisateur
         $em = $this->getDoctrine()->getManager();
         $arrayReservation = $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_user($_SESSION["user_connected"]->getId());
         $array_annonce = array();

        //on récupère toutes les annonces des réservations
        foreach ($arrayReservation as $reservation) {
            $a = $em->getRepository('AnnoncesBundle:Annonce')->find($reservation->getIdAnnonce());
            array_push($array_annonce , $a) ;
        }

        //boucle qui récupère toutes les réservations de chaque annonce, et les mets dans l'attribut array_annonce
        foreach ($array_annonce as $annonce) {
            $arrayPassagers = $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_annonce($annonce->getId());
            $annonce->setArrayPassagers($arrayPassagers);
        }


        return $this->render('reservation/vos_reservations.html.twig', array(
            'array_annonce' => $array_annonce,
            'user' => $_SESSION['user_connected'],
            'my_theme' => $_SESSION['theme'],
        ));
    }

    /**
     * Affiche les détail de la réservation de l'utilisateur
     *
     * @Route("/vos_reservations_description/{id}", name="vos_reservations_description")
     * @Method("GET")
     */
    public function vos_reservations_descriptionAction(Request $request, $id)
    {    
         //récupération de toutes les réservation de l'utilisateur
         $em = $this->getDoctrine()->getManager();
         $annonce = $em->getRepository('AnnoncesBundle:Annonce')->find($id);
         $annonceur = $em->getRepository('RolesBundle:Utilisateur')->find($annonce->getId_annonceur());


         return $this->render('reservation/description_vos_reservations.html.twig', array(
            'add' => $annonce,
            'user' => $_SESSION['user_connected'],
            'annonceur' => $annonceur,
            'my_theme' => $_SESSION['theme'],
        ));
    }



    /**
    * reservation de la place de l'annonce ayant pour IP id
    * @Method({"GET", "POST"})
    * @Route("/reservation_place/{id}", name="reservation_place")
    */
    public function reservation_action_complete_Action(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $add = $em->getRepository('AnnoncesBundle:Annonce')->find($id);
        $nb_user = $em->getRepository('RolesBundle:Utilisateur')->count_nb_user();
        $nb_annonce = $em->getRepository('AnnoncesBundle:Annonce')->count_nb_annonce();

        //si l'annonce n'existe pas
        if($add == null){
            return $this->render('annonce/recherche_annonce.html.twig', array(
                    'my_theme' => $_SESSION['theme'],
                    'user' => $_SESSION['user_connected'],
                    ));
        }
        //si elle existe
        else{
        
            $array_reserv = $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_annonce($id);
            
            //si il reste des places pour la reservation
            if(sizeof($array_reserv) < $add->getNbPlaces()){
                
                $reserv = new Reservation();
                $reserv->setIdAnnonce($add->getId());
                $reserv->setIdUser($_SESSION['user_connected']->getId());

                $em->persist($reserv);
                $em->flush($reserv);

                return $this->render('home/index_action_complete.html.twig', array(
                    'my_theme' => $_SESSION['theme'],
                    'user' => $_SESSION['user_connected'],
                    'nb_user' => $nb_user,
                    'nb_annonce' => $nb_annonce,
                    ));
            }
            //si le trajet est complet
            else{
                return $this->render('annonce/trajet_complet.html.twig', array(
                    'my_theme' => $_SESSION['theme'],
                    'user' => $_SESSION['user_connected'],
                    ));
            }


            
        }

         
    }


}
