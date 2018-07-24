<?php
  function Seccion($seccion, $nivel){
    $texto = "";
    foreach ($seccion as $tipe) {
      if ((string)$tipe->getName() == "h"){
        $texto .= hc($tipe, $nivel."#");
      }elseif ((string)$tipe->getName() == "p"){
          $texto .= p($tipe);
      }elseif ((string)$tipe->getName() == "section"){
          $texto .= Seccion($tipe, $nivel."#");
      }
    }
    return $texto;
  }
?>
