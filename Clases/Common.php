<?php

function h($value){
  if($value->emph){
    return "# ".$value->emph."\n\n";
  }
  return "# ".(String)$value."\n\n";
}

function hc($value, $nivel){
  if($value->emph){
    return $nivel." ".$value->emph."\n\n";
  }
  return $nivel." ".(String)$value."\n\n";
}

function p($value){
  if($value->emph){
    return $value->emph."\n\n";
  }
  return $value."\n\n";
}

function obj($value){
  $attb = $value->attributes();
  return "![Texto Alternativo](".$attb['src'].")\n\n";
}

?>
