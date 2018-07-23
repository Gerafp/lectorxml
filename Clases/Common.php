<?php

function h($value){
  if($value->emph){
    return "# ".$value->emph."\n\n";
  }
  return "# ".(String)$value."\n\n";
}

function p($value){
  if($value->emph){
    return $value->emph."\n\n";
  }
  return $value."\n\n";
}

?>
