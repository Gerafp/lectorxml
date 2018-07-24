<?php
  function Cover($seccion){
    #echo "Hola, i'am here :3";
    $texto = '';
    foreach ($seccion->p as $elemento) {
      if($elemento->emph){
        $texto .= "### ".$elemento->emph."\n\n";
      }
      elseif ($elemento->object) {
        $texto .= obj($elemento->object);
      }
      else {
        $texto .= "#### ".$elemento."\n\n";
      }
    }
    return $texto;
  }
?>
