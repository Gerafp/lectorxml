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
  function Tc($seccion){
    $texto = "";
    foreach ($seccion as $tipe) {
      switch ((string)$tipe->getName()) {
        case 'h':
          $texto .= h($tipe);
          break;
        case 'entry':
          $texto .= Ntr($tipe);
          break;
        default:
          // code...
          break;
      }
    }
    return $texto;
  }
  function Ntr($value){
    return "- ".$value."\n\n";
    #return "1. [".$value."](#'".$value."') \n";
  }
?>
