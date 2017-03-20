/**
 * Created by thiba on 07/03/2017.
 */

 function getClasses() {
    document.getElementsByTagName("form").classname = "login-container";

    $('#rolesbundle_utilisateur_email').attr('placeholder' , 'Email');
    $('#rolesbundle_utilisateur_mdp').attr('placeholder' , 'Password');
    $( "input" ).wrap( "<p></p>" );
}

 ;
