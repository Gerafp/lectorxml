<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    include('lib/Parsedown.php');

    include('Clases/Common.php');
    include('Clases/Clean.php');
    include('Clases/FrontMatter.php');
    include('Clases/Charper.php');
    include('Clases/Bibliography.php');

    $Parsedown = new Parsedown();

    //Creacion de los paths
    $codigo = $_GET['code'];
    $path = "Pruebas/".$codigo."/";
    $pathxml = $path.$codigo.".xml";
     ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Visor XML</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
          <div class="menu-bar">
            <div class="context-toggles">
              <a href="#Figures" title="Figures" class="context-toggle figures" id="Figures"><i class="fa fa-picture-o"></i>Figuras</a>
              <a href="#Contents" title="Contents" class="context-toggle toc" id="Contents"><i class="fa fa-align-left"></i>Índice</a>
            </div>
          </div>
          <ul class="sidebar-nav">
                <li class="sidebar-brand" id = "menu">
                    <a href="#" id = "sidebartitle">
                        INICIO
                    </a>
                </li>
                <div class="entries" id = "entries">
                </div>
              </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Contenido</a>
                <?php
                  if (file_exists($pathxml)) {
                    $texto = DebXML($pathxml);
                    $xml = new SimpleXMLElement($texto , 0);

                    foreach ($xml->body->section as $principal) {
                      switch ($principal['role']) {
                        case "frontmatter":
                          FrontMatter($principal, $Parsedown);
                          echo "<br><br>";
                          break;
                        case 'bodymatter':
                          BodyMatter($principal, $Parsedown);
                          echo "<br><br>";
                          break;
                        case 'backmatter':
                          BackMatter($principal, $Parsedown);
                          echo "<br><br>";
                          break;
                        default:
                          echo "Sección desconocida";
                          break;
                      }
                    }
                    CreateIndex();
                  } else {
                      header('Location: '.$uri.'404.php');
                  }

                # -----------------------------------------------------------------------------
                # Funcion del FrontMatter
                # -----------------------------------------------------------------------------
                 function FrontMatter($padre, $Parsedown){
                   #Primera parte Cover y Abstract
                   foreach ($padre as $seccion) {
                     switch ($seccion->getName()) {
                      case 'section':
                        SectionFrontmatter($seccion, $Parsedown);
                        break;
                      default:
                        break;
                     }
                   }
                 }
                 function BodyMatter($padre, $Parsedown){
                   echo "<div class=BodyMatter align=justify>";
                   foreach ($padre->section as $seccion){
                       echo Seccion($seccion,"");
                     }
                   echo "</div>";
                 }

                 function BackMatter($padre, $Parsedown){
                   echo "<div class=BackMatter align=justify>";
                   foreach ($padre as $seccion) {
                     switch ($seccion->getName()) {
                      case 'bibliography':
                        echo $Parsedown->text(biBliography($seccion));
                        break;
                      case 'section':
                        if ($seccion['role'] == "apendix") {
                          echo $Parsedown->text(Apendix($seccion));
                        }
                        break;
                      default:
                        //code
                        break;
                     }
                   }
                   echo "</div>";
                 }
                ?>
            </div>
            <div id="modal01" class="w3-modal" onclick="HideModal(this)">
              <img class="w3-modal-content" id="img01" style="width:50%">
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
      $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
      });

      window.onload= function(){
        var list = "<?php echo $indice ?>";
        document.getElementById("entries").innerHTML = list;
      }
      $("#Figures").click(function(e) {
          var figuras = "<?php echo $imagenes ?>"
          document.getElementById("sidebartitle").innerHTML = "FIGURAS";
          document.getElementById("entries").innerHTML = figuras;
      });
      $("#Contents").click(function(e) {
        var list = "<?php echo $indice ?>";
        document.getElementById("sidebartitle").innerHTML = "ÍNDICE";
        document.getElementById("entries").innerHTML = list;
      });

      function ShowModal(element) {
        $("#wrapper").toggleClass("toggled");
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
      }
      function HideModal(element) {
        $("#wrapper").toggleClass("toggled");
        document.getElementById("modal01").style.display = "none";
      }
    </script>
</body>

</html>
