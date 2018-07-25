<?php

function h($value){
  if($value->emph){
    return "# ".$value->emph."<a name=".$value->emph."></a>\n\n";
  }
  return "# ".(String)$value."<a name=".$value."></a>\n\n";
}

function hc($value, $nivel){
  if($value->emph){
    #return $nivel." ".$value->emph."\n\n";
    if ($value->emph->i){
      return $nivel." ".$value->emph->asXML()."<a name=".ForInt($value->emph->i)."></a>\n\n";
    }
    return $nivel." ".$value->emph."<a name=".ForInt($value->emph)."></a>\n\n";
  }
  #return $nivel." ".(String)$value."\n\n";
  return $nivel." ".(String)$value."<a name=".ForInt($value)."></a>\n\n";
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
  if($value->u){
    if($value->u->object){
      return obj($value->u->object);
    }
    return "_".$value->u."_";
  }
  return $value->asXML()."\n\n";
}

function obj($value){
  global $path;
  $texto = "";
  foreach ($value as $objcts) {
    $attb = $objcts->attributes();
    $texto .= "![](".$path.$attb['src'].")\n";
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
  $texto .= p($value->p)."\n\n";
  return $texto;
}

function ForInt($value){
  $aux = preg_replace('(\s[0-9]*)','',$value);
  return mb_strtolower(str_replace('.',"",str_replace('*','',$aux)), 'UTF-8');
}

function verse($value){
  return $value->asXML()."\n\n";
}

function table($value){
  //echo $value->asXML();
  return $value->asXML()."\n\n";
}
?>
