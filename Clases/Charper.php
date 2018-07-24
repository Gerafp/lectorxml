<?php
  function Seccion($seccion, $nivel){
    $texto = "";
    foreach ($seccion as $tipe) {
      switch ((string)$tipe->getName()) {
        case 'h':
          $texto .= hc($tipe, $nivel."#");
          break;
        case 'p':
          $texto .= p($tipe);
          break;
        case 'list':
          $texto .= lst($tipe);
          break;
        case 'quote':
            $texto .= qte($tipe);
            break;
        case 'section':
          $texto .= Seccion($tipe, $nivel."#");
          break;
        default:
          // code...
          break;
      }
      /*
      if ((string)$tipe->getName() == "h"){
        $texto .= hc($tipe, $nivel."#");
      }elseif ((string)$tipe->getName() == "p"){
          $texto .= p($tipe);
      }elseif ((string)$tipe->getName() == "section"){
          $texto .= Seccion($tipe, $nivel."#");
      }*/
    }
    return $texto;
  }
?>
