<?php

function h($value){
  if($value->emph){
    return "# ".$value->emph."<a name=".$value->emph."></a>\n\n";
  }
  return "# ".(String)$value."<a name=".$value."></a>\n\n";
}

function hc($value, $nivel){
  if($value->emph){
    return $nivel." ".$value->emph."\n\n";
  }
  return $nivel." ".(String)$value."\n\n";
}

function p($value){
  if($value->emph){
    if ($value->emph->object) {
      return obj($value->emph->object)."\n".$value;
    }
    $aux =  $value->asXML();
    return $aux."\n\n";
  } elseif ($value->object) {
    return obj($value->object)."\n".$value;
  }
  return $value."\n\n";
}

function obj($value){
  global $path;
  $texto = "";
  foreach ($value as $objcts) {
    $attb = $objcts->attributes();
    $texto .= "![Aquí va una imagen](".$path.$attb['src'].")\n";
  }
  #$attb = $value->attributes();
  #return "![Texto Alternativo](".$attb['src'].")\n\n";
  return $texto;
}

function lst($value){
  $texto = "";
  foreach ($value->item as $element) {
    $texto .= item($element);
  }
  return $texto;
}

function item($value){
  return "- ".$value->p."\n";
}

function qte($value){
  $texto = "> ";
  $texto .= $value->p."\n\n";
  return $texto;
}

?>
