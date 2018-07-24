<?php
function biBliography($seccion){
  $texto = "";
  foreach ($seccion as $tipe) {
    switch ((string)$tipe->getName()) {
      case 'h':
        $texto .= h($tipe);
        break;
      case 'entry':
        $texto .= Entry($tipe);
        break;
      default:
        break;
    }
  }
  return $texto;
}

function Entry($entrada){
  $aux = $entrada->attributes();
  return $aux['id'].". ".$entrada."\n";
}

function Apendix($seccion){
  $texto = "";
  foreach ($seccion as $tipe) {
    switch ((string)$tipe->getName()) {
      case 'h':
        $texto .= h($tipe);
        break;
      case 'p':
        $texto .= p($tipe);
        break;
      default:
        //code
        break;
    }
  }
  return $texto;
}

?>
