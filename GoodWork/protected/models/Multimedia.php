    <!-- mp-menu -->
    <nav id="mp-menu" class="mp-menu">
        <?php //on ajoute un id qui nous servira dans le fichier js pour enlever le scroll dans le sous-menu ?>
        <div class="mp-level" id="scrollMenu">

            <div id"PlaisirPart" >
                    
                    <div class="iconsMultimedia">
                        <!--<a href="#" onClick="typeAnimation('Profil');" class="typeAnimation profil huerotate"></a>-->
                        <a href="#" onClick="typeAnimation('Music');" class="typeAnimation music"></a>
                        <a href="#" onClick="typeAnimation('Video');" class="typeAnimation video"></a>
                        <a href="#" onClick="typeAnimation('Game');" class="typeAnimation game"></a>                         
                        <a href="#" onClick="typeAnimation('Facebook');" class="typeAnimation facebook"></a>
                        <a href="#" onClick="typeAnimation('SocialNetwork');" class="typeAnimation socialnetwork"></a>
                        <a href="#" onClick="typeAnimation('affichageNavigateurWrapper');" class="typeAnimation internet"></a>
                    </div> 

                    <div id="affichageProfil" style="display : none;" >
                        <?php




                            //PERMET D'AFFICHER JQUERY PARTOUT DANS LE SITE
                            //ERREUR A MODIFIER PROCHAINEMENT
                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'name'=>'selectUsername',
                                'value'=> ''  ,
                                'source'=>$this->createUrl('autocompleteTest'),
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                        'showAnim'=>'fold',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => "Search...",
                                    'style'=>'visibility:hiddent; display:none;',
                                ),
                            ));




                            //Si personne n'est connecte 
                            if( Yii::app()->user->name  == 'Guest'){   ?>

                                    <link rel="stylesheet" type="text/css" href="extensions/account/css/style.css" />
                                    <style> 
                                        @import url(http://fonts.googleapis.com/css?family=Montserrat:400,700|Handlee);
                                        
                                    </style>



                                    <form class="form-5 clearfix" id="connexion" method="post"  action="">
                                        <p>
                                            <input type="text" id="login" name="login" placeholder="Username">
                                            <input type="password" name="password" id="password" placeholder="Password" autocomplete="off"> 
                                        </p>
                                        <button type="submit" name="submit" id="askLogin">
                                            <i class="icon-arrow-right"></i>
                                            <span>Login</span>
                                        </button>     
                                    </form>​​​​

                                    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
                                    <script src="ajax/login.js"></script>
                                               


                            <?php 
                            //SInon on affiche profil
                            }else{ ?>
                           
                              
                                <?php

                                //On recupere l'id de l'user connecte
                                if(isset($_SESSION['Goodwork_id'])){

                                    $idusrCo = $_SESSION['Goodwork_id'];


                                    $connection=Yii::app()->db; 

                                    $sql="SELECT Usr.usr_login, Usr.usr_nom, Usr.usr_prenom, City.city_name, Country.country_name  from gw_usr as Usr, gw_city as City, gw_country as Country WHERE Usr.usr_id='$idusrCo' AND  City.city_id=Usr.usr_city AND Country.country_id=Usr.usr_country ";

                                    $rows=$connection->createCommand($sql)->query();

                                    $rows->bindColumn(1,$usr_login);
                                    $rows->bindColumn(2,$usr_nom);
                                    $rows->bindColumn(3,$usr_prenom);

                                    $rows->bindColumn(4,$city_name);
                                    $rows->bindColumn(5,$country_name);
                                

                                    // each $row is an array representing a row of data
                                    foreach($rows as $row){ ?>  


                                        <form method="post" enctype="multipart/form-data"  action="ajax/uploadavatar.php">
                                            <input type="file" name="images" id="images" class="formbouton_formulaire_upload"/>

                                            <button type="submit" id="btn" >  </button>

                                            <div class="circle">
                                                      <div class="profile">

                                                        <div class="profile-avatar-wrap">

                                                            <?php
                                                                // IMAGE DE PROFIL 
                                                                $imageAvatar = false;
                                                                //On crée un tableau d'extension d'image
                                                                $extensions_img = array('jpg', 'jpeg', 'png', 'gif');
                                                                foreach ($extensions_img as $ext_img) {
                                                                    if(file_exists('upload/avatar/'.$idusrCo.'.'.$ext_img)) {
                                                                        //Si un fichier à le meme nom que l'id en cours et que c'est une image, on l'affiche
                                                                        echo '<img src="upload/avatar/'.$idusrCo.'.'.$ext_img.'" class="imgcircle" id="profile-avatar" alt="Image for Profile">';
                                                                        echo 'upload/avatar/'.$idusrCo.'.'.$ext_img;

                                                                        //On met la variable a true;
                                                                        $imageAvatar = true;
                                                                        break;
                                                                    }
                                                                }

                                                                //Si on a pas d'avatar, on met celui par default
                                                                if(!$imageAvatar){
                                                                    //Sinon on affiche l'image par defaut
                                                                    echo '<img src="extensions/dragavatar/images/256.jpg" class="imgcircle" id="profile-avatar" alt="Image for Profile">';
                                                                }
                                                            ?>

                                                        </div>

                                                    </div>
                                                </div> 


                                        </form>
                                        <script src="ajax/uploadavatar.js"></script>

                                        <!-- In real life, these scripts are combined -->
                                        <script src="extensions/dragavatar/resample.js"></script>
                                        <script src="extensions/dragavatar/avatar.js"></script>
                                        <script>
                                            $(".circle").click(function () {
                                                $("#images").trigger('click');
                                            });

                                        </script>



                                    <br><br>

                                    <?php
                                            $login = strtoupper($usr_login);
                                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                'name'=>'selectUsername',
                                                'value'=> $login  ,
                                                'source'=>$this->createUrl('autocompleteTest'),
                                                // additional javascript options for the autocomplete plugin
                                                'options'=>array(
                                                        'showAnim'=>'fold',
                                                ),
                                                'htmlOptions' => array(
                                                    'placeholder' => "Search...",
                                                    'style'=>'background:none; border:none;',
                                                ),
                                            ));
                                    ?>
                                    <p class="ProfilName"> <?php echo $usr_prenom." ".strtoupper($usr_nom); ?>  </p>
                                    
                                    <p class="ProfilCountries"> <?php echo $country_name; ?>  </p>
                                    <p class="ProfilCity"> <?php echo $city_name; ?>  </p> 



                                    <?php
                                    } ?>



                                    <p class="ProfilTeam">Works</p>

                                    <?php

                                    $sql="SELECT Work.work_lib, Work.work_link from gw_work as Work WHERE Work.work_usr='$idusrCo'";

                                    $rows=$connection->createCommand($sql)->query();

                                    $rows->bindColumn(1,$work_lib);
                                    $rows->bindColumn(2,$work_link);


                                    // each $row is an array representing a row of data
                                    foreach($rows as $row){  ?>  

                                            <a class="ProfilTeamName" href=" <?php echo $work_link; ?> "><?php echo $work_lib; ?></a><br>
                                    <?php
                                    
                                    }  ?>
                                          






                                            <p class="ProfilRs">Suivez-le</p>

                                    <?php

                                    $sql="SELECT RsUsr.rsuser_rs, RsUsr.rsuser_link from gw_rsuser as RsUsr WHERE RsUsr.rsuser_usr='$idusrCo'";

                                    $rows=$connection->createCommand($sql)->query();

                                    $rows->bindColumn(1,$rsuser_rs);
                                    $rows->bindColumn(2,$rsuser_link); ?>


                                    <div class="iconsRS">
                                                <?php
                                                // each $row is an array representing a row of data
                                                foreach($rows as $row){   

                                                        //Facebook
                                                        if($rsuser_rs == 1) 
                                                          echo'<a class="facebook" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //Vimeo
                                                        if($rsuser_rs == 2)  
                                                          echo'<a class="vimeo" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //Twitter
                                                        if($rsuser_rs == 3)  
                                                          echo'<a class="twitter" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //linkedin
                                                        if($rsuser_rs == 4)  
                                                          echo'<a class="linkedin" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //Google+
                                                        if($rsuser_rs == 5)  
                                                          echo'<a class="googleplus" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //Flickr
                                                        if($rsuser_rs == 6)  
                                                          echo'<a class="flickr" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //tumblr
                                                        if($rsuser_rs == 7)  
                                                          echo'<a class="tumblr" href="'.$rsuser_link.'" target="_blank"></a>';

                                                        //Github
                                                        if($rsuser_rs == 8)  
                                                          echo'<a class="github" href="'.$rsuser_link.'" target="_blank"></a>';

                                                
                                                }  ?>
                                                 
                                    </div>


                                    <div >
                                        <?php echo CHtml::link('Link Text',array('site/logout')); ?>
                                    </div>
                               <?php  
                                }     
                           }// FIn else  ?> 


                    </div>



                    <div id="affichageMusic">
                        
                        <!--<div class="iconsMusic">
                            <!--<a href="#" onClick="typeAnimationMusic('Deezer');" class="typeAnimation deezer"></a>
                            <a href="#" onClick="typeAnimationMusic('Spotify');" class="typeAnimation spotify"></a>
                            <a href="#" onClick="typeAnimationMusic('Grooveshark');" class="typeAnimation grooveshark"></a>
                        </div>-->
                        
                        <img src="../../images/multimedia/Deezer.png" height=100 width=250 style="margin-top : -130px; margin-left : 40px;"/>
                        
                        <style type="text/css">
                            .progressbarplay {
                                cursor:pointer;overflow: hidden;height: 8px;margin-bottom: 8px;background-color: #F7F7F7;background-image: -moz-linear-gradient(top,whiteSmoke,#F9F9F9);background-image: -ms-linear-gradient(top,whiteSmoke,#F9F9F9);background-image: -webkit-gradient(linear,0 0,0 100%,from(whiteSmoke),to(#F9F9F9));background-image: -webkit-linear-gradient(top,whiteSmoke,#F9F9F9);background-image: -o-linear-gradient(top,whiteSmoke,#F9F9F9);background-image: linear-gradient(top,whiteSmoke,#F9F9F9);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5',endColorstr='#f9f9f9',GradientType=0);-webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;
                            }
                            .progressbarplay .bar {
                                cursor:pointer;background: #4496C6;width: 0;height: 8px;color: white;font-size: 12px;text-align: center;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);-webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);-moz-box-shadow: inset 0 -1px 0 rgba(0,0,0,0.15);box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;-webkit-transition: width .6s ease;-moz-transition: width .6s ease;-ms-transition: width .6s ease;-o-transition: width .6s ease;transition: width .6s ease;
                            }
                        </style>

                        <div id="affichageDeezer">
                            <!--<iframe scrolling="no" frameborder="0" allowTransparency="true" src="http://www.deezer.com/plugins/player?autoplay=false&playlist=true&width=270&height=600&cover=true&type=playlist&id=30595446&title=&format=vertical&app_id=undefined" width="270" height="600"></iframe>-->
                            <div id="dz-root"></div>
                            <div id="player" style="width:auto;margin-left : 30px;"></div>
                            <div id="commandDeezer" style="margin-left : 30px;">                                
                                <input type="button" value="Se connecter" onclick="login();"/>
                                <input id="research" type="text"/>
                                <input type="button" onclick="search();" value="Rechercher"/>
                                <input type="button" onclick="getPlaylists();" value="Mes playlists"/>
                                <input type="button" onclick="getAlbums();" value="Mes albums"/>
                            </div>
                            <div id="resultsList" style="height:250px; overflow: auto;">
                               <ul id="results">
                               </ul>
                            </div>
                        </div>

                        <!-- les différents appels à l'API Deezer -->
                        <script type="text/javascript">
                            
                            //id de l'utilisateur connecté à deezer
                            var userId = "";
                            var ok = false;

                            //initialisation du player deezer
                            DZ.init({
                                appId  : '134391',
                                channelUrl : 'http://www.goodworkonline.com/channel.html',
                                player: {
                                     container: 'player',
                                     width : 500,
                                     height : 300,
                                     onload : function(){}
                                }
                            });
                            

                            //Permet de se connecter a son compte deezer
                            function login()
                            {
                                DZ.login(function(response) {
                                    if (response.authResponse) {
                                        DZ.api('/user/me', function(user) {    
                                            userId = user.id;
                                            ok = true;
                                        });
                                    } 
                                }, 
                                {
                                    perms: 'basic_access,email'
                                });
                            }

                            //permet de récupérer les playlists associées à l'utilisateur connecté
                            function getPlaylists()
                            {
                                $('#results').empty();

                                //a changer en fonction de l'utilisateur connecté
                                var request = "/user/" + userId + "/playlists";

                                DZ.api(request, function(json) {
                                    for(var i = 0, len = json.data.length; i < len; i++)
                                    {
                                        var li = "<li><a href='#' onclick='DZ.player.playPlaylist(" + json.data[i].id + ");'>" + json.data[i].title + "</a></li>";
                                        //var ul = "<ul id=playlist" + id + "></ul>";
                                        //li.append(ul);
                                        $('#results').append(li);
                                    }
                                });

                            }

                            //permet de récupérer les albums de la bilbiotheque de l'utilisateur connecté
                            function getAlbums()
                            {
                                $('#results').empty();

                                var request = "/user/" + userId + "/albums";
                                DZ.api(request, function(json) {
                                    for(var i = 0 , len = json.data.length ; i < len ; i++)
                                    {
                                        var li = "<li><a href='#' onclick='DZ.player.playAlbum(" + json.data[i].id + ");'>" + json.data[i].title + " - " + json.data[i].artist.name + "</a></li>";
                                        $('#results').append(li);
                                    }
                                });
                            }

                            //permet de faire une recherche dans la base de données de Deezer
                            function search(){
                                $('#results').empty();
                                var request = "/search/autocomplete?q=" + $("#research").val();
                                DZ.api(request, function(json){
                                    for (var i=0, len = json.tracks.data.length; i<len ; i++)
                                    {
                                      //var a = "<a href='#' onclick=DZ.player.playTracks([" + json.tracks.data[i].id + "]);>" + json.tracks.data[i].title + " - " + json.tracks.data[i].artist.name + "</a>"; 
                                      var li = "<li><strong>" + json.tracks.data[i].title + " - " + json.tracks.data[i].artist.name + "</strong>";
                                      var playButton = "<input id='playSong' type='button' onclick='DZ.player.playTracks([" + json.tracks.data[i].id + "]);' value='Jouer'/>";
                                      var addToQueueButton = "<input id='addSongToQueue' type='button' onclick='DZ.player.addToQueue([" + json.tracks.data[i].id + "]);' value='Ajouter file attente'/>";
                                      li += playButton + addToQueueButton + "</li>";
                                      $('#results').append(li);
                                    }
                                });
                            }
                        </script>


                    </div>
                     
                     
                    <div id="affichageVideo" >

                        <script type="text/javascript">
                            $(document).ready(function()
                            {
                                $(".search_input").focus();
                                $(".search_input").keyup(function() 
                                {

                                    var search_input = $(this).val();
                                    var keyword= encodeURIComponent(search_input);

                                    var yt_url='http://gdata.youtube.com/feeds/api/videos?q='+keyword+'&format=5&max-results=1&v=2&alt=jsonc'; 


                                    $.ajax({
                                        type: "GET",
                                        url: yt_url,
                                        dataType:"jsonp",
                                        success: function(response)
                                        {
                                            if(response.data.items)
                                            {
                                                $.each(response.data.items, function(i,data)
                                                {
                                                var video_id=data.id;
                                                var video_title=data.title;
                                                var video_viewCount=data.viewCount;

                                                var video_frame="<iframe class='videoYtb' src='http://www.youtube.com/embed/"+video_id+"' frameborder='0' type='text/html'></iframe>";

                                                var final="<div id='titlevideoYtb'>"+video_title+"</div><div>"+video_frame+"</div>";
                                                $("#result").html(final);
                                                });
                                            }
                                            else
                                            {
                                                $("#result").html("<div id='no'>No Video</div>");
                                            }
                                        }

                                    });

                                });
                            });

                        </script>

                        <input type="text" class='search_input' placeholder="Recherche Youtube..."  /><br/>

                        <div id="result"></div>



                    </div>



                    <div id="affichageGame">

                        <?php //MENU
                        include ("extensions/game/invasion/invasion.php");
                        ?>
                    </div>


                    <div id="affichageSocialNetwork">
                        <a class="twitter-timeline" href="https://twitter.com/PierreMenes" data-widget-id="445681392500748288">Tweets favoris de @PierreMenes</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                    </div>
                
                    <div id="affichageWeb" style="width : auto; height : auto; margin-top : -250px; margin-left : 55px;">
                        <iframe id="affichageNavigateurWrapperFrame" width="110%" height="100%" seamless sandbox="allow-scripts allow-same-origin allow-forms" src="http://1.my-proxy.com/browse.php?u=https://www.google.fr/" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                
                
                    <div id="affichageFacebook" style="width : auto; margin-top : -250px; margin-left : 55px;">
			            <iframe id="facebookFrame" width="100%" height="100%" seamless sandbox="allow-scripts allow-same-origin allow-forms" src="extensions/Proxy_glype-1.4.6/browse.php?u=https%3A%2F%2Fm.facebook.com%2Fmessages" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                


            </div>


        </div>


        <!-- mp-menu -->
        <script type="text/javascript">

            //var profil = document.getElementById('affichageProfil');
            var music = document.getElementById('affichageMusic');
            var video = document.getElementById('affichageVideo');
            var game = document.getElementById('affichageGame');
            var socialNetwork = document.getElementById('affichageSocialNetwork');
            var facebook =  document.getElementById('affichageFacebook');
            var navigateur = document.getElementById('affichageWeb');
            
            //Music
            var deezer = document.getElementById('affichageDeezer');

            //On met par défaut le profil et on cache les deux autres
            music.style.display = 'none';
            video.style.display = 'none';
            game.style.display = 'none';
            socialNetwork.style.display = 'none';
            facebook.style.display = 'none';
            navigateur.style.display = 'none';

            //Music
            //deezer.style.display  = deezer.style.display = 'none';
            
            //On change la hauteur de la div a afficher
            //Celle ci doit etre egale a la hateur de la page
            //profil.style.height = document.body.offsetHeight+"px";


            window.onload = function () { 
                /*
                //On met par défaut le profil et on cache les deux autres
                music.style.display = music.style.display = 'none';
                video.style.display = video.style.display = 'none';
                game.style.display = game.style.display = 'none';
                socialNetwork.style.display = socialNetwork.style.display = 'none';

                //Music
                deezer.style.display  = deezer.style.display = 'none';
                spotify.style.display = spotify.style.display = 'none';
                grooveshark.style.display = grooveshark.style.display = 'none';
                */


                //On change la hauteur de la div a afficher
                //Celle ci doit etre egale a la hateur de la page
                profil.style.height = document.body.offsetHeight+"px";


                //Hauteur de la page pour
                // mp-menu et scrollMenu
                //Afin d'afficher la partie game
                var mpmenu = document.getElementById('mp-menu');
                var scrollMenu = document.getElementById('scrollMenu');
                mpmenu.style.height = document.body.offsetHeight+"px";
                scrollMenu.style.height = document.body.offsetHeight+"px";

            }


            function typeAnimation(Annimation) {

                //Hauteur page
                var hauteur =  document.body.offsetHeight;
                
                /*if(Annimation == 'Profil'){
                     
                    music.style.display = 'none';
                    video.style.display = 'none';
                    game.style.display = 'none';
                    profil.style.display = (profil.style.display == 'none' ? '' : 'none');
                    socialNetwork.style.display = 'none';                    
                    facebook.style.display = 'none';


                    //On change la hauteur de la div a afficher
                    //Celle ci doit etre egale a la hateur de la page
                    profil.style.height = hauteur+"px";                 
                }*/

                if(Annimation == 'Music'){

                    music.style.display = (music.style.display == 'none' ? '' : 'none');
                    video.style.display = 'none';
                    game.style.display = 'none';
                    //profil.style.display = 'none';
                    socialNetwork.style.display = 'none';                    
                    navigateur.style.display = 'none';
                    facebook.style.display = 'none';

                    //On change la hauteur de la div a afficher
                    //Celle ci doit etre egale a la hateur de la page
                    music.style.height = hauteur+"px";

                }

                if(Annimation == 'Video'){
                    
                    music.style.display = 'none';
                    video.style.display = (video.style.display == 'none' ? '' : 'none');
                    game.style.display = 'none';
                    //profil.style.display = 'none';
                    socialNetwork.style.display = 'none';                    
                    navigateur.style.display = 'none';
                    facebook.style.display = 'none';

                    //On change la hauteur de la div a afficher
                    //Celle ci doit etre egale a la hateur de la page
                    video.style.height = hauteur+"px";          
                    
                }

                if(Annimation == 'Game'){
                    
                    music.style.display = 'none';
                    video.style.display = 'none';
                    //profil.style.display = 'none';
                    socialNetwork.style.display = 'none';                    
                    facebook.style.display = 'none';                    
                    navigateur.style.display = 'none';                    
                    game.style.display = (game.style.display == 'none' ? '' : 'none');

                    //On change la hauteur de la div a afficher
                    //Celle ci doit etre egale a la hateur de la page
                    game.style.height = "300px";
                }
                //document.getElementById('mp-menu').innerHTML = "";

                if(Annimation == 'SocialNetwork'){
                    music.style.display = 'none';
                    socialNetwork.style.display = (socialNetwork.style.display == 'none' ? '' : 'none');
                    game.style.display = 'none';
                    //profil.style.display = 'none';
                    video.style.display = 'none';
                    facebook.style.display = 'none';
                    
                    navigateur.style.display = 'none';

                    //On change la hauteur de la div a afficher
                    //Celle ci doit etre egale a la hateur de la page
                    socialNetwork.style.height = hauteur+"px";          
                    
                }
                
                if(Annimation == 'Facebook') {
                    music.style.display = 'none';
                    socialNetwork.style.display = 'none';
                    game.style.display = 'none';
                    //profil.style.display = 'none';
                    video.style.display = 'none';
                    navigateur.style.display = 'none';
                    facebook.style.display = (facebook.style.display == 'none' ? '' : 'none');
                    //document.getElementById("affichageFacebook").style.display = (document.getElementById("affichageFacebook").style.display == 'none' ? '' : 'none');
                    //on change la hauteur de la div a afficher
                    //doit être egale à la hauteur de la page
                    
                    facebook.style.height = hauteur + "px";
                }
                
                if(Annimation == 'affichageNavigateurWrapper'){
                    music.style.display = 'none';
                    socialNetwork.style.display = 'none';
                    game.style.display = 'none';
                    video.style.display = 'none';
                    facebook.style.display = 'none';
                    navigateur.style.display = (navigateur.style.display == 'none' ? '' : 'none');
                    
                    navigateur.style.height = hauteur + "px";
                }
                

                
            }


            function typeAnimationMusic(Annimation) {
                if(Annimation == 'Deezer'){
                    deezer.style.display = (deezer.style.display == 'none' ? '' : 'none');
                    spotify.style.display = 'none';
                    grooveshark.style.display = 'none';
                }

                if(Annimation == 'Spotify'){
                    spotify.style.display = (spotify.style.display == 'none' ? '' : 'none');
                    deezer.style.display = 'none';
                    grooveshark.style.display = 'none';
                }

                if(Annimation == 'Grooveshark'){
                    grooveshark.style.display = (grooveshark.style.display == 'none' ? '' : 'none');
                    spotify.style.display = 'none';
                    deezer.style.display = 'none';
                }
            }


        </script>


    </nav>




