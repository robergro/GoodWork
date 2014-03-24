<?php   
    //************** CONNEXION A LA BDD  *********************\\
    try
    {
        if ($_SERVER['SERVER_NAME'] =='localhost' || $_SERVER['SERVER_NAME'] =='192.168.0.47'){
            $connexion = new PDO('mysql:host=localhost;dbname=GoodWork', 'root', 'root');
            $connexion->exec("set names utf8");
        }else{            
            $connexion = new PDO('mysql:host=localhost;dbname=web1418_db', 'web1418_db', 'terEGRalrg1909BDD');
            $connexion->exec("set names utf8");
        }

    }catch (Exception $e){ ?>


        <link rel="stylesheet" type="text/css" href="extensions/popup/css/default.css" />
        <link rel="stylesheet" type="text/css" href="extensions/popup/css/component.css" />

        <!-- All modals added here for the demo. You would of course just have one, dynamically created -->
        <div class="md-modal md-effect-7" id="modal-7">
          <div class="md-content">
            <h3 class="popupTitle">BIG PROBLEME !!</h3>
            <div>
              <p class="popupParagraphe">Il y a un probl&egrave;me d'acc&egrave;s &agrave; la base de donn&eacute;es d'GoodWork...</p>
              <p class="popupParagraphe">Si tu as le temps et l'envie, envoie nous un mail &agrave; l'adresse suivante: pour que l'on corrige l'erreur.</p>
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

        <?php 
        //die('Erreur de connexion a la Base de donnees: ' . $e->getMessage());
        die();
    }
?> 
