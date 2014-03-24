        <div id="TravailPart">
            <div id="wrapper">
                <div id="menuWrapper" class="iconsWORK" style="padding-left: 85px;">
                    <a href="#" onClick="clicElementTravail('affichageEditeur');" class="typeAnimation writte"></a>
                    <a href="#" onClick="clicElementTravail('affichagePresentation');" class="typeAnimation slides"></a>
                    <a href="#" onClick="clicElementTravail('affichageMarkdown');" class="typeAnimation markdown"></a>
                    <a href="#" onClick="clicElementTravail('affichageCorrecteur');" class="typeAnimation correct"></a>
                    <a href="#" onClick="clicElementTravail('affichageProgrammation');" class="typeAnimation codeall"></a>
                    <a href="#" onClick="clicElementTravail('affichageDevWeb');" class="typeAnimation codew"></a>
                    <a href="#" onClick="clicElementTravail('affichageNavigateurWrapper');" class="typeAnimation internet"></a>
                </div>

                <div id="content">

                    <div id="affichageMarkdown">
                            <div id="editeur">
                                <?php 
                                    include ("extensions/markdown/markdown.php");
                                ?>   
                            </div> 
                    </div>

                    <div id="affichagePresentation">
                    			<iframe width="100%" height="100%" seamless id="affichagePresentationFrame" src="http://slid.es/" sandbox="allow-scripts allow-same-origin allow-forms"></iframe>
                    </div>

                    <div id="affichageProgrammation">
                    			<iframe width="100%" height="100%" seamless id="affichageProgrammationFrame" src="https://ideone.com/" sandbox="allow-scripts allow-same-origin allow-forms"></iframe>

                    </div>

                    <div id="affichageEditeur">
                    			<iframe width="100%" height="100%" seamless id="affichageEditeurFrame" src="http://shutterb.org/" sandbox="allow-scripts allow-same-origin allow-forms"></iframe>
                    </div>


                    <style>
						#affichageNavigateurWrapperFrame { -ms-zoom: 0.9; -moz-transform: scale(0.9); -moz-transform-origin: 0px 0; -o-transform: scale(0.9); -o-transform-origin: 0 0; -webkit-transform: scale(0.9); -webkit-transform-origin: 0 0; }
                    </style>

                    <div id="affichageNavigateurWrapper">
                       			<iframe id="affichageNavigateurWrapperFrame" width="110%" height="96%" seamless sandbox="allow-scripts allow-same-origin allow-forms" src="http://1.my-proxy.com/browse.php?u=https://www.google.fr/" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>

                    <div id="affichageCorrecteur">
                   			<iframe width="100%" height="100%" seamless id="affichageCorrecteurFrame" src="http://bonpatron.com/" sandbox="allow-scripts allow-same-origin allow-forms"> </iframe>
                    </div>

                    <div id="affichageDevWeb">
                   			<iframe width="100%" height="100%" seamless id="affichageDevWebFrame" src="http://jsfiddle.net/" sandbox="allow-scripts allow-same-origin allow-forms"></iframe>
                    </div>

                                                             
                </div>

            </div>

        </div>


        <img  id="imgStart" src="<?php echo Yii::app()->request->baseUrl; ?>/images/titreAlpha.png" width="100%" alt="Texte remplaçant l'image" title="Texte à afficher">


    
        <script>
            
            var clicked = false;


            //Par defaut on cache les differents affichages
            cacherMenuTravail();
            
            function cacherMenuTravail()
            {  
                $("#affichageEditeur").hide();
                $("#affichagePresentation").hide();
                $("#affichageMarkdown").hide();
                $("#affichageCorrecteur").hide();
                $("#affichageProgrammation").hide();
                $("#affichageDevWeb").hide();
                $("#affichageNavigateurWrapper").hide();
            }

            function clicElementTravail(Element) 
            {                
                if(Element == 'affichageEditeur' && !clicked)
                {
                    $('#affichageEditeurFrame').attr('src',$('#affichageEditeurFrame').attr('src'));
                    clicked = true;
                }
                
                cacherMenuTravail();
                $("#"+Element).show();

                //Hauteur
                $("#"+Element).show();
                var hauteur =  document.body.offsetHeight;
                $("#"+Element).css("height", hauteur);
                $("#"+Element).css("margin-top", "20px");

                //On cache l'image GoodWork
                $("#imgStart").css("display", "none");
                $("#imgStart").css("margin-top", "20px");
                



            }
            document.getElementById("scrollMenu").style.background = "gray";
            //document.getElementById('editeur').style.visibility = 'hidden';

        </script>
