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
      $indices["'".strip_tags($value->emph->asXML())."'"] = ForInt(strip_tags($value->emph->asXML()));
      return $nivel." ".$value->emph->asXML()."<a name=".ForInt(strip_tags($value->emph->asXML()))."></a>\n\n";
    } elseif ($value->emph->u) {
      $indices["'".strip_tags($value->emph->asXML())."'"] = ForInt(strip_tags($value->emph->asXML()));
      return $nivel." ".$value->emph->asXML()."<a name=".ForInt(strip_tags($value->emph->asXML()))."></a>\n\n";
    }
    $indices["'".strip_tags($value->emph)."'"] = ForInt(strip_tags($value->emph));
    return $nivel." ".$value->asXML()."<a name=".ForInt(strip_tags($value->emph))."></a>\n\n";
  }elseif ($value->i) {
    $indices["'".strip_tags($value->asXML())."'"] = ForInt(strip_tags($value->asXML()));
    return $nivel." ".$value->asXML()."<a name=".ForInt(strip_tags($value->asXML()))."></a>\n\n";
  }
  $indices["'".strip_tags($value)."'"] = ForInt(strip_tags($value));
  return $nivel." ".(String)$value."<a name=".ForInt(strip_tags($value))."></a>\n\n";
}

function p($value){
  global $path;
  global $imagenes;

  if($value->emph){
    if ($value->emph->object) {
      return obj($value->emph->object)."\n".$value;
    }elseif ($value->emph->i->object) {
      return obj($value->emph->i->object)."\n".$value;
    } elseif ($value->object) {
      $attb = $value->object->attributes();
      $imagenes .= "<img class='img-fluid' src=".$path.$attb['src']." onclick='ShowModal(this)'/>";
      $aux = $value->asXML();
      $aux = str_replace("object", "img", $aux);
      $aux = str_replace($attb['src'], $path.$attb['src'], $aux);
      return $aux;
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
    $imagenes .= "<img class='img-fluid' src=".$path.$attb['src']." onclick='ShowModal(this)'>";
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
  return CheckImg($value->asXML())."\n\n";
  //return $value->asXML()."\n\n";
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

function CheckImg($value){
  global $path;
  global $imagenes;
  $patron = '-src\s*=\s*"([^"]+)"-';
  $encontrado = preg_match_all($patron, $value, $coincidencias, PREG_OFFSET_CAPTURE);

  if ($encontrado) {
      foreach ($coincidencias[1] as $coincide) {
          $aux =  str_replace("object", "img", str_replace($coincide[0], $path.$coincide[0], $value));
          $imagenes .= "<img class='img-fluid' src=".$path.$coincide[0]." onclick='ShowModal(this)'>";
          return $aux;
      }
  } else {
      return $value;
  }
}
?>
