<?php
  function Cover($seccion){
    #echo "Hola, i'am here :3";
    $texto = '';
    foreach ($seccion->p as $elemento) {
      if($elemento->emph){
        $texto .= "### ".$elemento->emph."\n\n";
      }
      elseif ($elemento->object) {
        $attb = $elemento->object->attributes();
        $texto .= "![Texto Alternativo](".$attb['src'].")\n\n";
      }
      else {
        $texto .= "#### ".$elemento."\n\n";
      }
    }
    return $texto;
  }
?>
