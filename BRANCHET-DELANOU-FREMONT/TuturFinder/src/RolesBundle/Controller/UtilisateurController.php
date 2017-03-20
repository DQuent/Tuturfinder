<?php

namespace RolesBundle\Controller;

use RolesBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

use RolesBundle\Form\UtilisateurType;

/**
 * Utilisateur controller.
 *
 * @Route("/")
 */
class UtilisateurController extends Controller
{
    /**
     * Page de connexion
     *
     * @Route("/", name="login")
     * 
     */
    public function indexAction()
    {
        $user = new Utilisateur();
        
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm(UtilisateurType::class,$user,array(
            'action' => $this->generateUrl('myhomepage'),
            'method' => 'POST'
        ));
        
        return $this->render('utilisateur/login.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * Deconnexion utilisateur
     *
     * @Route("/logout", name="logOut")
     */
    public function logoutAction(Request $request)
    {
        $form = $this->createForm(UtilisateurType::class,$user,array(
            'action' => $this->generateUrl('myhomepage'),
            'method' => 'POST'
        ));

        //effacer toutes les sessions
        $_SESSION['user_connected'] = NULL;
        $_SESSION['theme'] = 'base.html.twig';
         return $this->render('utilisateur/logout.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Lists all utilisateur entities.
     *
     * @Route("/show", name="show_list")
     * @Method("GET")
     */
    public function show_listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('RolesBundle:Utilisateur')->findAll();

        return $this->render('utilisateur/list_user.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Route("/new", name="_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('RolesBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush($utilisateur);

            return $this->redirectToRoute('_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('utilisateur/new.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     * @Route("/list/{id}", name="_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('utilisateur/show.html.twig', array(
            'utilisateur' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Route("/{id}/edit", name="_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);
        $editForm = $this->createForm('RolesBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_edit', array('id' => $utilisateur->getId()));
        }

        return $this->render('utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Affiche les settings de l'utilisateur connecté
     *
     * @Route("/setting", name="setting")
     * @Method({"GET", "POST"})
     */
    public function settingAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         //$array_voiture = $em->getRepository('RolesBundle:Voiture')->get_voiture($_SESSION['user_connected']);
        
        return $this->render('utilisateur/settings.html.twig', array(
            'user' => $_SESSION['user_connected'],
            'my_theme' => $_SESSION['theme'],
        ));
    }

    /**
     * Affiche les settings de l'utilisateur connecté
     *
     * @Route("/home", name="setting_result")
     * @Method({"POST"})
     */
    public function settingValidateAction(Request $request)
    {
          $em = $this->getDoctrine()->getManager();
         $nb_user = $em->getRepository('RolesBundle:Utilisateur')->count_nb_user();
         $nb_annonce = $em->getRepository('AnnoncesBundle:Annonce')->count_nb_annonce();
      
         $user = $_SESSION["user_connected"];

         if($request->request->get('email') != ""){
            $email = htmlspecialchars( $request->request->get('email') );
            $user-> setEmail($email);
         }
        if($request->request->get('photo') != ""){
            $photo = htmlspecialchars( $request->request->get('photo') );
            $user->setPhoto($photo);
         }
        if($request->request->get('nom') != ""){
            $nom = htmlspecialchars($request->request->get('nom'));
            $user->setNom($nom);
         }
        if($request->request->get('prenom') != ""){
            $prenom = htmlspecialchars($request->request->get('prenom'));
            $user->setPrenom($prenom);
         }
        if($request->request->get('age') != ""){
            $age = htmlspecialchars( $request->request->get('age') );
            $user->setAge($age);
         }
        if($request->request->get('voiture') != ""){
            $voiture = htmlspecialchars( $request->request->get('voiture') );
            $user->setVoitureId($voiture);
         }
        if($request->request->get('telephone') != ""){
            $tel = htmlspecialchars( $request->request->get('telephone') );
            $user->setTelephone($tel);
         }

            // On persiste notre user.
            $em->merge($user);
         
            // On ne passe pas du tout par le client ici en fait, donc pas besoin de persist du tout.
         
            // On déclenche la modification.
            $em->flush();

            //on rétablie les modifications de la nouvelle session
            $_SESSION['user_connected'] = $user;

        return $this->render('home/index_action_complete.html.twig', array(
            'user' => $_SESSION['user_connected'],
            'my_theme' => $_SESSION['theme'],
            'nb_user' => $nb_user,
            'nb_annonce' => $nb_annonce,
        ));
    }




    /**
     * Deletes a utilisateur entity.
     *
     * @Route("/delete/{id}", name="_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush($utilisateur);
        }

        return $this->redirectToRoute('_index');
    }

    /**
     * Creates a form to delete a utilisateur entity.
     *
     * @param Utilisateur $utilisateur The utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Affiche le formulaire d'inscription
     *
     * @Route("/incription_form", name="incription_form")
     */
    public function inscriptionAction(Request $request)
    {
        return $this->render('utilisateur/inscription.html.twig');


    }

    /**
     * Affiche la page de login en créeant un nouvel utilisateur
     *
     * @Route("/inscription_complete", name="inscription_complete")
     * @Method({"POST"})
     */
    public function inscription_completeAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
      
         $user = new Utilisateur();

        if($request->request->get('email') != "" 
            && $request->request->get('nom') != "" 
            && $request->request->get('mdp') != ""
            && $request->request->get('prenom') != ""){

            $email = htmlspecialchars($request->request->get('email'));
            $user->setEmail($email);
            $nom = htmlspecialchars($request->request->get('nom'));
            $user->setNom($nom);
            $mdp = htmlspecialchars($request->request->get('mdp'));
            $user->setMdp($mdp);
            $prenom = htmlspecialchars($request->request->get('prenom'));
            $user->setPrenom($prenom);

            // On persiste notre user.
            $em->persist($user);
                  
            // On déclenche l'insertion'.
            $em->flush();

        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm(UtilisateurType::class,$user,array(
            'action' => $this->generateUrl('myhomepage'),
            'method' => 'POST'
        ));

            return $this->render('utilisateur/login.html.twig', array(
            'form' => $form->createView(),
        ));
         }
         else{
            return $this->render('utilisateur/inscription_non_correcte.html.twig');
         }
       
        




        


    }


    
}
