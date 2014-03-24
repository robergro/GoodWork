
function changeColor(){

                      
        var tabColor = ["#f8d135", "#e67e22", "#04a466", "#2980b9","#faae33", "#1abc9c", "#95a5a6", "#f06060","#702fa8", "#96a94b", "#3851bc", "#d54f30"];
        
        var tabColor = ["#f8d135", "#e67e22", "#04a466", "#2980b9","#faae33", "#1abc9c", "#95a5a6", "#f06060","#702fa8", "#96a94b", "#3851bc", "#d54f30"];
        

        //Plus un pour avoir le dernier element du tableau
        var nbaleatoire = Math.floor(Math.random() * tabColor.length);
        console.log(nbaleatoire);
        console.log(tabColor.length);
        
        document.bgColor = tabColor[nbaleatoire];

        
       //Couleur input
       $('input').css('color', tabColor[nbaleatoire]);
       $('input.btn').css('color', "#fff");

       /*Lecteur vidéo Youtube */
       $('#result').css('border-color', tabColor[nbaleatoire]);
       $('#result').css('background-color', "rgba(0,0,0,0.4)");
       $('.search_input').css('border-color', tabColor[nbaleatoire]);


       //Autocomplet
       $('.ui-menu-item').css('color', tabColor[nbaleatoire]);
       

       $(".btn").hover(
        function () {
          $(this).css("color", tabColor[nbaleatoire]);
          $(this).css("background-color", "#fff");
        }, 
        function () {
          $(this).css("color", "#fff");
          $(this).css("background-color", "");
        }
      );


      $(".hi-icon").hover(
        function () {
          $(this).css("color", tabColor[nbaleatoire]);
          $(this).css("background-color", "#fff");
        }, 
        function () {
          $(this).css("color", "#fff");
          $(this).css("background-color", "");
        }
      );


      //Couleur game
      $("#menu div").hover(
        function () {
          $(this).css("color", tabColor[nbaleatoire]);
        }, 
        function () {
          $(this).css("color", "#fff");
        }
      );


      //Menu multimédia
      var scrollMenu = document.getElementById('scrollMenu');
      scrollMenu.style.background = "rgba(0,0,0,0.4)";


     


}
            
$( "html" ).dblclick(function() {
    var game = document.getElementById('affichageGame');
    if(game.style.display == 'none'){
      changeColor();
    }
});

$( "html" ).ready(function() {
  changeColor();
});
       


