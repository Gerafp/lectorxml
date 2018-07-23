<?php
  function Abstrct($seccion){
    $texto = '';
    #echo $seccion->h->emph;
    foreach ($seccion as $elemento) {
      if($elemento->emph){
        $texto .= h($elemento);
      }
      else {
        $texto .= p($elemento);
      }
    }
    return $texto;
  }

?>
