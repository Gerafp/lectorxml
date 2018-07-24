<?php
	include('lib/Parsedown.php');

	include('Clases/Common.php');
	include('Clases/Clean.php');
	include('Clases/Cover.php');
	include('Clases/Abstract.php');
	include('Clases/Charper.php');
	include('Clases/Bibliography.php');

	$Parsedown = new Parsedown();

	if (file_exists('014377.xml')) {
		$texto = DebXML('014377.xml');
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
	    exit('Error abriendo test.xml.');
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
 }
 function BodyMatter($padre, $Parsedown){
	 echo "<div class=resumen align=justify>";
	 foreach ($padre->section as $seccion){
			 echo $Parsedown->text(Seccion($seccion,""));
		 }
	 echo "</div>";
 }

 function BackMatter($padre, $Parsedown){
	echo $Parsedown->text(biBliography($padre->bibliography));
	echo $Parsedown->text(Apendix($padre));
 }
?>
