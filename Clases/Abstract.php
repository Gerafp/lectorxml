<?php
  function Abstrct($seccion){
    $texto = '';
    #echo $seccion->h->emph;
    foreach ($seccion as $elemento) {
      if((string)$elemento->getName() == "h"){
        $texto .= h($elemento);
      }elseif ((string)$elemento->getName() == "p") {
        $texto .= p($elemento);
      }
    }
    return $texto;
  }
?>
