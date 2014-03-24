$(document).ready(function(){

   $("#askLogin").click(function(){

    username=$("#login").val();
    password=$("#password").val();
    $.ajax({
         type: "POST",
         url: "index.php?r=site/logUser", /*Methode dans le controller */
         data: "name="+username+"&pwd="+password,
         success: function(html){
          if(html=='true')
          {
           alert(html);

          }
          else
          {
           alert(html);
          }
         }
        });
        return false;
    });
});