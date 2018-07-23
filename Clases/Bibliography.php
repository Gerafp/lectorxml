<?php
function biBliography($seccion){
  $texto = "";
  $texto .= h($seccion->h);

  $i = 1;
  foreach ($seccion->entry as $entrada) {
    $aux = $entrada->attributes();
    $texto .= $aux['id'].". ".$entrada."\n";
  }
  return $texto;
}

function Apendix($seccion){
  $texto = "";
  foreach ($seccion->section as $apendix) {
    $texto .= h($apendix->h);
    $texto .= Ps($apendix->p);
  }
  return $texto;
}

function Ps($ps){
  $texto = "";
  foreach ($ps as $p) {
    $texto .= p($p);
  }
  return $texto;
}
?>
