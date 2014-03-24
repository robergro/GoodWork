

  <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="extensions/markdown/wmd/wmd.css"/>
    <link type="text/css" rel="stylesheet" href="extensions/markdown/css/style.css"/>
    <link type="text/css" rel="stylesheet" href="extensions/markdown/css/theme-balupton.css"/> 


      <div id="editor">      
        <div id="affiEditeur">
            <div id="toolbar" class="wmd-toolbar"></div>

            <div >
                <?php //on passe par le controller pour exporter le fichier en .md ?>
                <form id="mkEditeur" action="index.php?r=site/exporterMd" name="upmarkdown" method="post">
                  <textarea id="input" name="fichierMarkdown" class="wmd-input" rows="30" cols="80"></textarea>
                  <input type="submit" name="creerfichier" value="enregistrer sous" class="saveFile"/>                             
                </form>
            </div>
        </div>

        <div id="preview" class="wmd-preview"></div>

      </div>



<!-- jQuery and Syntax Highlight -->

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<!--<script type="text/javascript" src="extensions/jquery-2.1.0.min.js"></script>-->
<script type="text/javascript" src="extensions/markdownEditor/js/jquery.syntaxhighlighter.min.js"></script>

<!-- WMD -->
<script type="text/javascript" src="extensions/markdownEditor/wmd/showdown.js"></script>
<script type="text/javascript" src="extensions/markdownEditor/wmd/wmd.js"></script>

<!-- Additional scripts -->
<script type="text/javascript" src="extensions/markdownEditor/js/functions.js"></script>

<!-- jQuery listener for syntax highlight -->
<script type="text/javascript">


  /*document.getElementById('wrapper').style.width = '100%';
  document.getElementById('affiEditeur').style.width = '50%';
  document.getElementById('input').style.width = '100%';*/


  $(document).ready(function() {
    $("#highlightCode").click(function(){
      $.SyntaxHighlighter.init({
      'lineNumbers': false,
      'debug': true
      });
    });
    new WMD("input", "toolbar", { preview: "preview" });
  });
</script>
      


    
<?php //ID correspond à la balise rel de <a> ?>
<div id="popupJQ" class="popup_blockJQ">
    <?php  
      //include le fichier Convertiseeur Markdown/Html
      require_once('extensions/markdown/markdownParse/Michelf/Markdown.php');

      # Install PSR-0-compatible class autoloader
      spl_autoload_register(function($class){
          require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
      });

      # Read file and pass content through the Markdown praser
      $text = file_get_contents('extensions/markdown/infoArticle.md');
      $html = Michelf\Markdown::defaultTransform($text);

      echo $html;
    ?>
</div>
