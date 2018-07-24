<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Lector XML</title>
	</head>
	<body>
		<?php
			include('lib/Parsedown.php');

			include('Clases/Common.php');
			include('Clases/Clean.php');
			include('Clases/Cover.php');
			include('Clases/Abstract.php');
			include('Clases/Charper.php');
			include('Clases/Bibliography.php');

			$Parsedown = new Parsedown();
			$codigo = $_GET['code'];

			$path = "C:/xampp/htdocs/lectorxml/".$codigo."/"; #Aquí va el Path de acceso a los recursos
			$pathxml = $path.$codigo.".xml";
			//echo $pathxml;


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
			 foreach ($padre->section as $seccion){
				 switch ($seccion['role']) {
					 case 'cover':
						 echo "<div class=portada align=center>";
						 echo $Parsedown->text(Cover($seccion));
						 echo "</div>";
						 break;
					 case 'abstract':
						 echo "<div class=resumen align=justify>";
						 echo $Parsedown->text(Abstrct($seccion));
						 echo "</div>";
						 break;
					 default:
						 // code...
						 break;
				 }
			 }
			 foreach ($padre as $seccion){
				 if($seccion->getName()=='toc'){
					 echo "<div class=resumen align=justify>";
					 echo $Parsedown->text(Tc($seccion));
					 echo "</div>";
				 }
			 }
		 }
		 function BodyMatter($padre, $Parsedown){
			 echo "<div class=BodyMatter align=justify>";
			 foreach ($padre->section as $seccion){
					 echo $Parsedown->text(Seccion($seccion,""));
				 }
			 echo "</div></div>";
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
	</body>
</html>
