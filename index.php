<?php
	include('lib/Parsedown.php');

	include('Clases/Cover.php');
	include('Clases/Abstract.php');

	$Parsedown = new Parsedown();



	if (file_exists('cover.xml')) {
		$xml = new SimpleXMLElement('cover.xml', 0, true);

	    #Primera parte Cover y Abstract
	    foreach ($xml->body->section->section as $seccion){
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

			#Segunda parte

	} else {
	    exit('Error abriendo test.xml.');
	}

?>
