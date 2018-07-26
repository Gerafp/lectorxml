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
    $path = "".$codigo."/";
    $pathxml = $path.$codigo.".xml";

     ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css"/>

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Start Bootstrap
                    </a>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Shortcuts</a>
                </li>
                <li>
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#"></a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>
                <?php
                  if (file_exists($pathxml)) {
                    $texto = DebXML($pathxml);
                    $xml = new SimpleXMLElement($texto , 0);

                    foreach ($xml->body->section as $principal) {
                      switch ($principal['role']) {
                        case "frontmatter":
                          FrontMatter($principal, $Parsedown);
                          break;
                        case 'bodymatter':
                          BodyMatter($principal, $Parsedown);
                          break;
                        case 'backmatter':
                          BackMatter($principal, $Parsedown);
                          break;
                        default:
                          echo "Sección desconocida";
                          break;
                      }
                    }

                  } else {
                      exit('--Error-- <br>'.$codigo.".xml no existe");
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
                      case 'toc':
                        echo "<div class=indice align=justify>";
                        echo $Parsedown->text(Tc($seccion));
                        echo "</div>";
                        break;
                      default:
                        // code...
                        break;
                     }
                   }
                 }
                 function BodyMatter($padre, $Parsedown){
                   echo "<div class=BodyMatter align=justify>";
                   foreach ($padre->section as $seccion){
                       echo $Parsedown->text(Seccion($seccion,""));
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
    </script>

</body>

</html>
