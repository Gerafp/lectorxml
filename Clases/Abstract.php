<?php
  function Abstrct($seccion){
    $texto = '';
    #echo $seccion->h->emph;
    foreach ($seccion as $elemento) {
      if($elemento->emph){
        $texto .= h($elemento->emph);
      }
      else {
        $texto .= p($elemento);
      }
    }
    return $texto;
  }

  function h($value){
    return "# ".(String)$value."\n\n";
  }
  function p($value){
    return (String)$value."\n\n";
  }
?>
