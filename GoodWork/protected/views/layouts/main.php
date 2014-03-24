<?php /* @var $this Controller */ ?>
<!doctype html>
<html class="no-js" lang="fr">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="fr" />

		<!-- blueprint CSS framework -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

		<!--Multimedia -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/stylemenu.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/icons.css" />

		<!--Menu -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/extensions/menu/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/extensions/menu/css/icons.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/extensions/menu/css/component.css" />

		<!--Avatar -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/avatar.css" />

	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/extensions/menu/js/modernizr.custom.js"></script>

	    <!--Information -->
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	    <meta name="description" content="Combine work and pleasure wherever you are" />
	    <meta name="keywords" content="markdown, code, vidéos, musiques, réseaux sociaux" />
	    <meta name="author" content="Aurélien ADAM - JOUBERT Adrien - LEMAIRE Robin - POTHIN Jean Philippe" />

	    <link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png" />

	    <!--JQuery -->
	    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

        <link rel="stylesheet" href="extensions/videochargement/css/style.css">
        <script>
        /*Script pour enlever l'affichage de la vidéo de chargement quand la page est complétement chargée*/
        $(window).load(function() {
            $("#FirstChargement").css({display:'none'});
            document.getElementById('FirstChargement').removeAttribute('data-video');
            $( "#big-video-vid_html5_api" ).remove();
            $( "#big-video-vid" ).remove();
            //On affiche la partie principale
            $("#set-6").css({visibility:'visible'});
            $("#bt-menu").css({visibility:'visible'});

        });

        </script>
         <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fontColor.js"></script>
        
        <!-- import du sdk deezer -->
        <script src="http://cdn-files.deezer.com/js/min/dz.js"></script>


	</head>

	<body>
    
            <!-- VIDEO DE CHARGEMENT -->
            <div id="FirstChargement">

                <div class="wrapper">
                    <div class="screen" id="screen-1" data-video="extensions/videochargement/vid/goodwork<?php echo rand(1, 6);?>.mp4"></div>
                </div>
                

                <header>
                    <div id="chargement"<span id="chargement-infos">CHARGEMENT EN COURS...</span></div>
                </header>



                <!-- BigVideo Dependencies -->
                <script src="extensions/videochargement/js/jquery.imagesloaded.min.js"></script>
                <script src="http://vjs.zencdn.net/c/video.js"></script>

                <!-- BigVideo -->
                <script src="extensions/videochargement/js/bigvideo.js"></script>




                <!-- Tutorial Demo -->
                <script src="extensions/videochargement/js/jquery.transit.min.js"></script>
                <script src="js/videoChargement.js"></script>

            </div>




            <!-- PARTIE PRINCIPALE -->
			<section id="set-6">
                <div class="body" id="body">

                    <!-- Push Wrapper -->
                    <div class="mp-pusher" id="mp-pusher">

                        <div id="header">
                            <?php 
                                //MENU
                                include ('protected/models/Multimedia.php');  
                            ?>
                        </div>


                        <div class="scroller"><!-- this is for emulating position fixed of the nav -->
                            <div class="scroller-inner">

                            	<!--Menu multimédia -->
                                <div class="content clearfix">
                                    <div class="block block-40 clearfix" id="MenuJq">
                                        <p id="trigger" class="menu-trigger"><a href="#" ></a></p>
                                    </div>
                                </div>


                                <!-- Partie principale -->
                                <div id="wrapper">
                                    
                                    <div id="content">
                                            <article id="article">

                      													<?php if(isset($this->breadcrumbs)):?>
                      														<?php $this->widget('zii.widgets.CBreadcrumbs', array(
                      															'links'=>$this->breadcrumbs,
                      														)); ?><!-- breadcrumbs -->
                      													<?php endif?>

                      													<?php echo $content; ?>

                                            </article>

                                                                                 
                                    </div>

                                </div>


                            </div><!-- /scroller-inner -->
                        </div><!-- /scroller -->

                    </div><!-- /pusher -->
                </div><!-- /container -->
            </section>
            

			<!-- MENU -->
			<!--<nav id="bt-menu" class="bt-menu">
                <a href="#" class="bt-menu-trigger"><span>Menu</span></a>
                <ul>
                    <li><a href="#" class="bt-icon icon-user-outline">Settings</a></li>
                    <li><a href="#" class="bt-icon icon-sun">Docs</a></li>
                    <li><a href="#" class="bt-icon icon-windows">Logout</a></li>
                    <li><a href="#" class="bt-icon icon-speaker">Ergro</a></li>
                    <li><a href="#" class="bt-icon icon-star">À propos</a></li>
                    <li><a href="#" class="bt-icon icon-bubble">Contact</a></li>
                </ul>
            </nav>-->


            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/borderMenu.js"></script>

		    <script src="<?php echo Yii::app()->request->baseUrl; ?>/extensions/menu/js/classie.js"></script>
		    <script src="<?php echo Yii::app()->request->baseUrl; ?>/extensions/menu/js/mlpushmenu.js"></script>
			
            <script>


	            
	            new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ), {
	                type : 'cover'
	            } );

	            /*
	            document.getElementById('editeur').style.visibility = 'hidden';

	            function masquernotification()
	            {
	              document.getElementById("imgStart").innerHTML="";
	              document.getElementById("imgStart").style.display="none"; 
	              document.getElementById('editeur').style.visibility = 'visible';

	            }
	            window.setTimeout(masquernotification, 4000);
	            */


	        </script>








	</body>
</html>



