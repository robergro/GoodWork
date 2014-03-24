<!DOCTYPE html>
<html lang="fr">
<head>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bigvideo.css">
    <script src="js/modernizr-2.5.3.min.js"></script>

    <script src="http://code.jquery.com/jquery-1.9.0b1.js"></script>
    <script src="js/pageloader.js"></script>
    <script>
    // Le DOM est pret
    $(document).ready(function() {
        $.pageLoader();
    });
    </script>
    
    
</head>
<body>
    
    <div id="FirstChargement">
        <header>
            <div id="chargement">Chargement...<span id="chargement-infos"></span></div>
        </header>


        <div class="wrapper">
            <div class="screen" id="screen-1" data-video="vid/goodwork1.mp4"></div>
        </div>



        <!-- BigVideo Dependencies -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.8.1.min.js"><\/script>')</script>
        <script src="js/jquery-ui-1.8.22.custom.min.js"></script>
        <script src="js/jquery.imagesloaded.min.js"></script>
        <script src="http://vjs.zencdn.net/c/video.js"></script>




        <!-- BigVideo -->
        <script src="js/bigvideo.js"></script>




        <!-- Tutorial Demo -->
        <script src="js/jquery.transit.min.js"></script>
        <script>
            $(function() {

                // Use Modernizr to detect for touch devices, 
                // which don't support autoplay and may have less bandwidth, 
                // so just give them the poster images instead
                var screenIndex = 1,
                    numScreens = $('.screen').length,
                    isTransitioning = false,
                    transitionDur = 1000,
                    BV,
                    videoPlayer,
                    isTouch = Modernizr.touch,
                    $bigImage = $('.big-image'),
                    $window = $(window);
                
                if (!isTouch) {
                    // initialize BigVideo
                    BV = new $.BigVideo({forceAutoplay:isTouch});
                    BV.init();
                    showVideo();
                    
                    BV.getPlayer().addEvent('loadeddata', function() {
                        onVideoLoaded();
                    });

                    // adjust image positioning so it lines up with video
                    $bigImage
                        .css('position','relative')
                        .imagesLoaded(adjustImagePositioning);
                    // and on window resize
                    $window.on('resize', adjustImagePositioning);
                }
                
                // Next button click goes to next div
                $('#next-btn').on('click', function(e) {
                    e.preventDefault();
                    if (!isTransitioning) {
                        next();
                    }
                });

                function showVideo() {
                    BV.show($('#screen-'+screenIndex).attr('data-video'),{ambient:true});
                }

                function next() {
                    isTransitioning = true;
                    
                    // update video index, reset image opacity if starting over
                    if (screenIndex === numScreens) {
                        $bigImage.css('opacity',1);
                        screenIndex = 1;
                    } else {
                        screenIndex++;
                    }
                    
                    if (!isTouch) {
                        $('#big-video-wrap').transit({'left':'-100%'},transitionDur)
                    }
                        
                    (Modernizr.csstransitions)?
                        $('.wrapper').transit(
                            {'left':'-'+(100*(screenIndex-1))+'%'},
                            transitionDur,
                            onTransitionComplete):
                        onTransitionComplete();
                }

                function onVideoLoaded() {
                    $('#screen-'+screenIndex).find('.big-image').transit({'opacity':0},500)
                }

                $(window).load(function() {
                    BV.getPlayer().pause();
                });

                function onTransitionComplete() {
                    isTransitioning = false;
                    if (!isTouch) {
                        $('#big-video-wrap').css('left',0);
                        showVideo();
                    }
                }

                function adjustImagePositioning() {
                    $bigImage.each(function(){
                        var $img = $(this),
                            img = new Image();

                        img.src = $img.attr('src');

                        var windowWidth = $window.width(),
                            windowHeight = $window.height(),
                            r_w = windowHeight / windowWidth,
                            i_w = img.width,
                            i_h = img.height,
                            r_i = i_h / i_w,
                            new_w, new_h, new_left, new_top;

                        if( r_w > r_i ) {
                            new_h   = windowHeight;
                            new_w   = windowHeight / r_i;
                        }
                        else {
                            new_h   = windowWidth * r_i;
                            new_w   = windowWidth;
                        }

                        $img.css({
                            width   : new_w,
                            height  : new_h,
                            left    : ( windowWidth - new_w ) / 2,
                            top     : ( windowHeight - new_h ) / 2
                        })

                    });

                }
            });
        </script>
    </div>


    <div id="container">
        <h1>pageLoader.js</h1>
        
        <img src="http://img.hebus.com/hebus_2012/12/20/1356022994_44923.jpg" width="100" height="50" />
        <p>&quot;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>
        <img src="http://img.hebus.com/hebus_2012/12/20/1355963632_44166.jpg" width="100" height="50" />
        <p>&quot;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>
        <img src="http://zone.wallpaper.free.fr/galleries/Animaux/Belugas/Belugas_02_1600x1200.jpg" width="100" height="50" />
        <p>&quot;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>
        <div style="height:200px; background:url(http://img.hebus.com/hebus_2012/12/14/1355494682_14173.jpg); background-size: 25%;">background-image</div>
        <p>&quot;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;</p>
    </div>
</body>
</html>