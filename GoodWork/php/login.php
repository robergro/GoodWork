<?php   

    //Variables:
    $connexionNonValide = false;

    //************** CONNEXION A LA BDD  *********************\\
    include ("protected/config/pageacces/connexionbdd.php");
    if($connexion){
        // on teste si nos variables sont définies
        if (isset($_POST['login']) && isset($_POST['pwd'])) { 
              
          $login = $_POST['login'];  
          $mdp = $_POST['pwd'];
        
          $result= $connexion->query("SELECT usr_id, usr_pass FROM egr_usr WHERE usr_login='$login' OR usr_mail='$login' LIMIT 1");

          if($donnees = $result->fetch()){

              $id_utilisateur = $donnees["usr_id"];
              //Dehaschage du mot de passe
              $hash = $donnees["usr_pass"];
              $mdp   = sha1($mdp.$hash) ;

              $resultFinal= $connexion->query("SELECT usr_id, usr_login, usr_mdp, usr_compte FROM egr_usr WHERE usr_id='$id_utilisateur' AND usr_mdp='$mdp' LIMIT 1");

              if($donneesFinal = $resultFinal->fetch()){

                  $login_valide = $donneesFinal["usr_login"];
                  $pwd_valide = $donneesFinal["usr_mdp"];
                  $type_compte = $donneesFinal["usr_compte"];

                  // dans ce cas, tout est ok, on peut démarrer notre session
                  session_start (); 

                  // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) (notez bien que l'on utilise pas le $ pour enregistrer ces variables)
                  $_SESSION['rb_egr_14_login'] = $_POST['login']; 
                  $_SESSION['rb_egr_14_id_utilisateur'] = $id_utilisateur;

                  //Récupération du type de compte
                  $resultTypeCompte= $connexion->query("SELECT compte_id, compte_lib FROM egr_compte WHERE compte_id='$type_compte' LIMIT 1");
                  if($donnees_tdc = $resultTypeCompte->fetch()){
                      $type_compte = $donnees_tdc["compte_lib"];
                      $_SESSION['rb_egr_14_typecompte'] = $type_compte; 
                  }
                  $resultTypeCompte->closeCursor(); // Termine le traitement de la requête*/

                  
                  //On met l'username de la personne connecté dans la variable prévue par Yii.
                  Yii::app()->user->name = $_SESSION['rb_egr_14_login'];

                  $connexionNonValide = false;

                  echo '<meta http-equiv="refresh" content="0;URL=index.php/site/Accueil">';            
              //Sinon Si on a pas de résultats:
              //Cela signigie qu'on a pas entré le bon mdp et le bon login
              }else{

                  // Le visiteur n'a pas été reconnu comme étant membre de notre site. On utilise alors un petit javascript lui signalant ce fait
                  echo '<a href="#" data-width="60%" data-rel="popupJQ" class="popuplightJQ" id="liensPopUp"></a>'; 
                  $connexionNonValide = true;
                      
              }//Fin else
          }else{
                  // Le visiteur n'a pas été reconnu comme étant membre de notre site. On utilise alors un petit javascript lui signalant ce fait
                  echo '<a href="#" data-width="60%" data-rel="popupJQ" class="popuplightJQ" id="liensPopUp"></a>';
                  $connexionNonValide = true;

                      
              }//Fin else

          $result->closeCursor(); // Termine le traitement de la requête*/
        }  
        else { 
              echo 'Les variables du formulaire ne sont pas déclarées.';
              echo '<meta http-equiv="refresh" content="0;URL=index.php/site/Accueil">';  
        }  

  }//FIN connexion
?>

<?php if($connexionNonValide){ ?>


    <link rel="stylesheet" type="text/css" href="extensions/popup/css/default.css" />
    <link rel="stylesheet" type="text/css" href="extensions/popup/css/component.css" />

    <!-- All modals added here for the demo. You would of course just have one, dynamically created -->
    <div class="md-modal md-effect-7" id="modal-7">
      <div class="md-content">
        <h3 class="popupTitle">Erreur</h3>
        <div>
          <p class="popupParagraphe">Le login ou le mot de passe est incorrect, veuillez recommencer...</p>
          <button id="boutonPopup" class="md-close">Fermer!</button>
        </div>
      </div>
    </div>

    
    <div class="container">
          <button style="display:none;" class="md-trigger" id="boutonValidConnexion" data-modal="modal-7" name="boutonValidConnexion"></button>
    </div><!-- /container -->
    <div class="md-overlay"></div><!-- the overlay element -->

    <!-- classie.js by @desandro: https://github.com/desandro/classie -->
    <script src="extensions/popup/js/classie.js"></script>
    <script src="extensions/popup/js/modalEffects.js"></script>

    <!-- for the blur effect -->
    <!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill -->
    <script>
      // this is important for IEs
      var polyfilter_scriptpath = '/js/';
    </script>
    <script src="extensions/popup/js/cssParser.js"></script>
    <script src="extensions/popup/js/css-filters-polyfill.js"></script>

    <script>
        boutonValidConnexion.click();
    </script>

    <script>
    $('#boutonPopup').click(function() {
        //redirection  
        document.location.replace("index.php/site/Accueil");
    });

    //Close Popups and Fade Layer
      $('#body').click(function() { //Au clic sur le body...
            //redirection  
            document.location.replace("index.php/site/Accueil");
      });
    </script>
<?php } ?>






