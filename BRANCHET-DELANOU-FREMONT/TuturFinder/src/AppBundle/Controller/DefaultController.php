<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use RolesBundle\Entity\Utilisateur;
use RolesBundle\Form\UtilisateurType;
use RolesBundle\Repository\UtilisateurRepository;

/**
 * Default controller.
 *
 * @Route("home")
 */
class DefaultController extends Controller
{    
    /**
    * Connexion utilisateur
    *
    * @Method({"GET", "POST"})
    * @Route("/", name="myhomepage")
    */
    public function loginAction(Request $request)
    {


           $em = $this->getDoctrine()->getManager();
           $nb_user = $em->getRepository('RolesBundle:Utilisateur')->count_nb_user();
           $nb_annonce = $em->getRepository('AnnoncesBundle:Annonce')->count_nb_annonce();

           if(!isset($_SESSION["theme"])) {
            //theme par defaut
            $_SESSION["theme"] = 'base.html.twig';
           }
           //connexion
           if(isset($_POST['rolesbundle_utilisateur']) && $_POST['rolesbundle_utilisateur'] != null){
              // $_POST parameters
             $email = htmlspecialchars($request->request->get('rolesbundle_utilisateur')['email']) ;
             $mdp = htmlspecialchars($request->request->get('rolesbundle_utilisateur')['mdp']) ;


             
             $em = $this->getDoctrine()->getManager();
             $response = $em->getRepository('RolesBundle:Utilisateur')
                        ->test_connexion($email, $mdp);
              //si bon login
                if(count($response) >= 1 ){

                  $_SESSION['user_connected'] = $response[0];
                  return $this->render('home/index.html.twig', array(
                        'user' => $_SESSION['user_connected'],
                        'my_theme' => $_SESSION["theme"],
                        'nb_user' => $nb_user,
                        'nb_annonce' => $nb_annonce,
                          ));

                }
                else{
                  $user = new Utilisateur();
                  // Create the form according to the FormType created previously.
                  // And give the proper parameters
                  $form = $this->createForm(UtilisateurType::class,$user,array(
                      'action' => $this->generateUrl('myhomepage'),
                      'method' => 'POST'
                  ));
                  //si mauvais login
                  return $this->render('utilisateur/mauvais_log.html.twig', array(
                      'email' => $email,
                      'form' => $form->createView(),
                      ));

                }
           }
           elseif (isset($_SESSION['user_connected'])){

                    //redirection vers home, et utilisateur deja conencté
                   if ($_SESSION['user_connected'] != NULL) {
                     return $this->render('home/index.html.twig', array(
                                'user' => $_SESSION['user_connected'],
                                'my_theme' => $_SESSION["theme"],
                                'nb_user' => $nb_user,
                                'nb_annonce' => $nb_annonce,
                            ));
                   }
                   //connexion annonyme
                   else{
                     $_SESSION['user_connected'] = NULL;
                     $_SESSION['theme'] = 'baseLogInOut.html.twig';
                     return $this->render('home/indexAnonyme.html.twig', array(
                                'my_theme' => 'baseLogInOut.html.twig',
                                'nb_user' => $nb_user,
                                'nb_annonce' => $nb_annonce,
                            ));
                   }

          }
           
    }

    



     /**
    * Choix du theme
    * @Method({"GET", "POST"})
    * @Route("/theme/{theme}", name="myhomepageTheme")
    */
    public function choix_themeAction(Request $request, $theme)
    {
           $em = $this->getDoctrine()->getManager();
           $nb_user = $em->getRepository('RolesBundle:Utilisateur')->count_nb_user();
           $nb_annonce = $em->getRepository('AnnoncesBundle:Annonce')->count_nb_annonce();
            if($theme == "Lumen"){
              $my_theme = 'baseLumen.html.twig';
            }
            else{
              $my_theme = 'base.html.twig';
            }
            $_SESSION["theme"] = $my_theme;
         return $this->render('home/index.html.twig', array(
                    'my_theme' => $_SESSION["theme"],
                    'user' => $_SESSION['user_connected'],
                    'nb_user' => $nb_user,
                    'nb_annonce' => $nb_annonce,
                    ));
    }

    /**
    * 
    * @Route("/anonyme", name="utilisateur_anonyme")
    */
    public function loginVisiteurAction(Request $request)
    {

           $em = $this->getDoctrine()->getManager();
           $nb_user = $em->getRepository('RolesBundle:Utilisateur')->count_nb_user();
           $nb_annonce = $em->getRepository('AnnoncesBundle:Annonce')->count_nb_annonce();

          if(!isset($_SESSION["theme"])) {
            //theme par defaut
            $_SESSION["theme"] = 'base.html.twig';
           }

            
        return $this->render('home/indexAnonyme.html.twig', array(
                    'my_theme' => 'baseLogInOut.html.twig',
                    'nb_user' => $nb_user,
                    'nb_annonce' => $nb_annonce,
                    ));
    }

    /**
    * 
    * @Route("/need_login", name="need_login")
    */
    public function need_loginAction(Request $request)
    {

            
        return $this->render('home/need_login.html.twig');  

    }




}
