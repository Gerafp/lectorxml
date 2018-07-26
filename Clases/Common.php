<?php

$indices = array();
$indice = "";
$imagenes = "";

function h($value){
  global $indices;
  if($value->emph){
    $indices["'".$value->emph."'"] = ForInt(strip_tags($value->emph));
    return "# ".$value->emph."<a name=".ForInt(strip_tags($value->emph))."></a>\n\n";
  }
  $indices["'".(String)$value."'"] = ForInt(strip_tags($value));
  return "# ".(String)$value."<a name=".ForInt(strip_tags($value))."></a>\n\n";
}

function hc($value, $nivel){
  global $indices;

  if($value->emph){
    if ($value->emph->i){
      $indices["'".$value->emph->asXML()."'"] = ForInt(strip_tags($value->emph->asXML()));
      return $nivel." ".$value->emph->asXML()."<a name=".ForInt(strip_tags($value->emph->asXML()))."></a>\n\n";
    }
    $indices["'".$value->emph."'"] = ForInt(strip_tags($value->emph));
    return $nivel." ".$value->asXML()."<a name=".ForInt(strip_tags($value->emph))."></a>\n\n";
  }elseif ($value->i) {
    $indices["'".$value->i->asXML()."'"] = ForInt(strip_tags($value->i->emph));
    return $nivel." ".$value->i->asXML()."<a name=".ForInt(strip_tags($value->i->emph))."></a>\n\n";
  }
  $indices["'".$value."'"] = ForInt(strip_tags($value));
  return $nivel." ".(String)$value."<a name=".ForInt(strip_tags($value))."></a>\n\n";
}

function p($value){
  if($value->emph){
    if ($value->emph->object) {
      return obj($value->emph->object)."\n".$value;
    }elseif ($value->emph->i->object) {
      return obj($value->emph->i->object)."\n".$value;
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
  global $imagenes;
  $texto = "";
  foreach ($value as $objcts) {
    $attb = $objcts->attributes();
    $texto .= "![](".$path.$attb['src'].")\n";
    $imagenes .= "<img class='img-fluid' src=".$path.$attb['src']." onclick='ImgModal(this)'>";
  }
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
  return $value->asXML()."\n\n";
}

function caption($value){
  return $value->asXML()."\n\n";
}

function CreateIndex(){
  global $indices;
  global $indice;
  foreach ($indices as $clave => $valor) {
    //echo "{$clave} => {$valor} ";
    //echo "<li><a href=#{$valor}>$clave</a></li>";
    $indice .= "<li><a href=#{$valor}>$clave</a></li>";
  }
}
?>
