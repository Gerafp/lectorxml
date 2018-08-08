<?php

$indices = array();
$indice = "";
$imagenes = "";

function h($value){
  global $indices;
  if($value->emph){
    $indices["'".$value->emph->asXML()."'"] = ForInt(strip_tags($value->emph->asXML()));
    return "# ".$value->emph->asXML()."<a name=".ForInt(strip_tags($value->emph->asXML()))."></a>\n\n";
  }
  $indices["'".(String)$value."'"] = ForInt(strip_tags($value));
  return "# ".(String)$value."<a name=".ForInt(strip_tags($value))."></a>\n\n";
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
  $texto = "<ul>";
  foreach ($value->item as $element) {
    $texto .= item($element);
  }
  return $texto."</ul>";
}

function item($value){
  return "<li>".pc($value->p)."</li>";
}

function qte($value){
  $texto = "<blockquote>";
  $texto .= pc($value->p)."</blockquote>";
  return $texto;
}

function ForInt($value){
  $aux = preg_replace('(\s[0-9]*)','',$value);
  return mb_strtolower(str_replace('.',"",str_replace('*','',$aux)), 'UTF-8');
}

function verse($value){
  return "<div class=cita>".$value->ln->asXML()."</div>";
}


function tablec($value){
  $texto = $value->asXML();
  $re = '/'.'<object id="[a-zA-Z0-9]*"\ssrc="[a-zA-Z0-9_-]*\-[a-zA-Z0-9.]*"\/>'.'/';
  if (preg_match_all($re, strval($value->asXML()), $matches)){
      foreach ($matches[0] as $match) {
        $texto = str_replace($match, objc($match), $texto);
      }
  }
  return $texto;
}


function caption($value){
  return "<figcaption>".$value->asXML()."</figcaption>";
}

function CreateIndex(){
  global $indices;
  global $indice;
  foreach ($indices as $clave => $valor) {
    $indice .= "<li><a href=#{$valor}>$clave</a></li>";
  }
}


function hcc($value, $nivel){
  $xmlText = new DOMDocument();
  global $indices;

  $texto = strip_tags(strval($value->asXML()), '<emph><i><strong><u>');
  $indice = scanear_string(strip_tags(strval($value->asXML())));
  $indices["'".$indice."'"] = ForInt($indice);
  return "<h".strval($nivel).">".$texto."</h".strval($nivel)."><a name=".ForInt($indice)."></a>";
}

function pc($value){
    $texto = $value->asXML();
    $re = '/'.'<object id="[a-zA-Z0-9]*"\ssrc="[a-zA-Z0-9_-]*\-[a-zA-Z0-9.]*"\/>'.'/';
    if (preg_match_all($re, strval($value->asXML()), $matches)){
        foreach ($matches[0] as $match) {
          $texto = str_replace($match, objc($match), $texto);
        }
    }
    return $texto;
}

function objc($value){
  global $path;
  global $imagenes;
  $xml = new SimpleXMLElement($value, 0);
  $texto = "";
  $attb = $xml->attributes();
  //$texto .= "![](".$path.$attb['src'].")";
  $texto = "<img class='img-fluid' src=".$path.$attb['src'].">";
  $imagenes .= "<img class='img-fluid' src=".$path.$attb['src']." onclick='ShowModal(this)'>";
  return $texto;
}

function scanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño


    return $string;
}
?>
