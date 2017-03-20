<?php

namespace AnnoncesBundle\Controller;

use AnnoncesBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use RolesBundle\Entity\Utilisateur;
use AnnoncesBundle\Entity\Reservation;

/**
 * Annonce controller.
 *
 * @Route("annonce")
 */
class AnnonceController extends Controller
{
    /**
     * Lists all annonce entities.
     *
     * @Route("/", name="annonce_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AnnoncesBundle:Annonce')->findAll();

        return $this->render('annonce/index.html.twig', array(
            'annonces' => $annonces,
        ));
    }

    /**
     * Creates a new annonce entity.
     *
     * @Route("/new", name="annonce_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $annonce = new Annonce();
        $form = $this->createForm('AnnoncesBundle\Form\AnnonceType', $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush($annonce);

            return $this->redirectToRoute('annonce_show', array('id' => $annonce->getId()));
        }

        return $this->render('annonce/new.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/show/{id}", name="annonce_show")
     * @Method("GET")
     */
    public function showAction(Annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);

        return $this->render('annonce/show.html.twig', array(
            'annonce' => $annonce,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing annonce entity.
     *
     * @Route("/{id}/edit", name="annonce_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);
        $editForm = $this->createForm('AnnoncesBundle\Form\AnnonceType', $annonce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_edit', array('id' => $annonce->getId()));
        }

        return $this->render('annonce/edit.html.twig', array(
            'annonce' => $annonce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonce entity.
     *
     * @Route("/delete/{id}", name="annonce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Annonce $annonce)
    {
        $form = $this->createDeleteForm($annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonce);
            $em->flush($annonce);
        }

        return $this->redirectToRoute('annonce_index');
    }

    /**
     * Creates a form to delete a annonce entity.
     *
     * @param Annonce $annonce The annonce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Annonce $annonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonce_delete', array('id' => $annonce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * Retourne la page correspondante aux annonces d'un utilisateur
     *
     * @Route("/your_annonce", name="vos_annonces")
     */
    public function vos_annonceAction(Request $request)
    {
        $user = $_SESSION["user_connected"];
        $em = $this->getDoctrine()->getManager();
        


        $array_annonce = $em->getRepository('AnnoncesBundle:Annonce')->get_annonces_from_user($_SESSION['user_connected']);

        //boucle qui récupère toutes les réservations de chaque annonce, et les mets dans l'attribut array_annonce
        foreach ($array_annonce as $annonce) {
            $arrayPassagers = $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_annonce($annonce->getId());
            $annonce->setArrayPassagers($arrayPassagers);
        }

        return $this->render('annonce/vos_annonces.html.twig', array(
            'user' => $user,
            'my_theme' => $_SESSION["theme"],
            'array_annonce' => $array_annonce,
        ));

    }

     /**
     * Retourne la page correspondante à l'annonce sélectionnée par l'utilisateur
     *
     * @Route("/vos_annonces_description/{id}", name="vos_annonces_description")
     */
    public function vos_annonceDescriptionAction(Request $request, Annonce $id)
    {
        $user = $_SESSION["user_connected"];
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('AnnoncesBundle:Annonce')->find($id);
        $array_reserv =  $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_annonce($annonce->getId());
        $annonce->setArrayPassagers($array_reserv);
        return $this->render('annonce/description_vos_annonces.html.twig', array(
            'user' => $user,
            'my_theme' => $_SESSION["theme"],
            'add' => $annonce,
        ));

    }

     /**
     * Retourne la page correspondante à l'annonce sélectionnée par l'utilisateur
     *
     * @Route("/annonce_edit", name="edit_annonce")
     */
    public function vos_annonceEditAction(Request $request)
    {
        $user = $_SESSION["user_connected"];
        $em = $this->getDoctrine()->getManager();
        

        return $this->render('annonce/publier_annonce.html.twig', array(
            'user' => $user,
            'my_theme' => $_SESSION["theme"],
        ));

    }
     /**
     * @Route("/map", name="map")
     */
    public function mapAction(Request $request)
    {

        return $this->render('annonce/map.html');

    }

    /**
    * 
    * @Route("/home_edit_complete", name="action_add_annonce_complete")
    */
    public function action_add_annonce_completeAction(Request $request)
    {
        //traitement des données
        $em = $this->getDoctrine()->getManager();
        $annonce = new Annonce();
        $nb_user = $em->getRepository('RolesBundle:Utilisateur')->count_nb_user();
        $nb_annonce = $em->getRepository('AnnoncesBundle:Annonce')->count_nb_annonce();

        $annonce->setTitre( htmlspecialchars( $request->request->get('titre') ));
        $annonce->setDescription( htmlspecialchars( $request->request->get('description') ));
        $annonce->setNbPlaces(htmlspecialchars($request->request->get('nbPlaces')));
        $annonce->setPrix(  $request->request->get('prix') );
        $annonce->setDureeDetour(  $request->request->get('detour') );
        $annonce->setVilleArr( htmlspecialchars( $request->request->get('villeArr') ));
        $annonce->setVilleDep(htmlspecialchars($request->request->get('villeDep') ));

        $dateDep = $request->request->get('dateDep');
        $timeDep = $request->request->get('heureDep');
        $dateArr = $request->request->get('dateArr');
        $timeArr = $request->request->get('heureArr');

        $final_dep = date_create($dateDep .' '.$timeDep);
        $annonce->setDateDep($final_dep);
        $final_arr =date_create($dateArr .' '.$timeArr);
        $annonce->setDateArr($final_arr);

        $annonce->setIdConducteur($_SESSION['user_connected']->getId());
        $annonce->setId_annonceur($_SESSION['user_connected']->getId());
        
        if((int)$request->request->get('nbPlaces') <= 0 
         || htmlspecialchars($request->request->get('titre')) == ""
         || htmlspecialchars($request->request->get('villeArr')) == htmlspecialchars($request->request->get('villeDep')) 
         ){

            return $this->render('annonce/form_incomplete.html.twig', array(
            'user' => $_SESSION['user_connected'],
            'my_theme' => $_SESSION["theme"],
            'nb_user' => $nb_user,
            'nb_annonce' => $nb_annonce,
            ));
        }
        else{
             $em->persist($annonce);  
             $em->flush($annonce); 

            //retour vers la page de connexion
            if($_SESSION['user_connected'] != null && $_SESSION["theme"] != 'baseLogInOut.html.twig'){
                return $this->render('home/index_action_complete.html.twig', array(
                'user' => $_SESSION['user_connected'],
                'my_theme' => $_SESSION["theme"],
                'nb_user' => $nb_user,
                'nb_annonce' => $nb_annonce,
                ));
            }
            else{
                return $this->render('home/index_action_complete.html.twig', array(
                'my_theme' => 'baseLogInOut.html.twig',
                'nb_user' => $nb_user,
                'nb_annonce' => $nb_annonce,
                ));
        }


        }

            


    }


     /**
     * Permet d'afficher la page de recherche d'annonce par ville de départ
     *
     * @Route("/recherche_annonce", name="recherche_annonce")
     */
    public function recherche_annonceAction(Request $request)
    {

        if($_SESSION['user_connected'] != null){
            $user = $_SESSION["user_connected"];
            return $this->render('annonce/recherche_annonce.html.twig', array(
                'user' => $user,
                'my_theme' => $_SESSION["theme"],
            ));
        }
        else{
            return $this->render('annonce/recherche_annonce.html.twig', array(
                'my_theme' => 'baseLogInOut.html.twig',
            ));
        }
        

    }

    /**
     * Permet d'afficher le resultat de la recherche d'annonce par ville de départ
     *
     * @Route("/consulter_annonce_result", name="consulter_annonce_result")
     * @Method("POST")
     *
     */
    public function consulter_annonce_resultAction(Request $request)
    {
        $user = $_SESSION["user_connected"];

        //traitement des données
        $em = $this->getDoctrine()->getManager();
        $array_annonce = $em->getRepository('AnnoncesBundle:Annonce')->get_annonce_by_villeDep($request->get('villeDep'));



    

        //boucle qui récupère toutes les réservations de chaque annonce, et les mets dans l'attribut array_annonce
        foreach ($array_annonce as $annonce) {
            $arrayPassagers = $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_annonce($annonce->getId());
            $annonce->setArrayPassagers($arrayPassagers);
        }

        return $this->render('annonce/liste_annonces.html.twig', array(
            'user' => $user,
            'my_theme' => $_SESSION["theme"],
            'array_annonce' => $array_annonce,
        ));

    }

    /**
    * Permet de voir la description de la recherche sélectionnée
    * @Method({"GET", "POST"})
    * @Route("/annonce_description/{id}", name="annonce_description")
    */
    public function annonce_descriptionAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $add = $em->getRepository('AnnoncesBundle:Annonce')->find($id);
        $annonceur = $em->getRepository('RolesBundle:Utilisateur')->find($add->getId_annonceur());
        $array_reserv =  $em->getRepository('AnnoncesBundle:Reservation')->get_reservation_by_annonce($add->getId());
        $add->setArrayPassagers($array_reserv);


         return $this->render('annonce/description_annonce.html.twig', array(
                    'my_theme' => $_SESSION['theme'],
                    'user' => $_SESSION['user_connected'],
                    'annonceur' => $annonceur,
                    'add' => $add,
                    ));
    }

}
