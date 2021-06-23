<?php

  $data = array();
  session_start();
  if($_SESSION["servidor"]!=""){
    $servidor=$_SESSION["servidor"];
    $usuario=$_SESSION["usuario"];
    $pass=$_SESSION["password"];
    $base=$_SESSION["base"];

    $conexion_db = mysqli_connect($servidor,$usuario,$pass,$base);
  }else{
    $conexion_db = mysqli_connect("localhost","root","root","club");
  }

  if($conexion_db->connect_error){
    die("Unable to connect database: " . $conexion_db->connect_error);
  }
    
  if(!empty($_GET["tabla"])){
    $query=mysqli_query($conexion_db,"DESCRIBE ".$_GET["tabla"]);
  }

  $cant=0;
  while ($col = mysqli_fetch_array( $query,MYSQLI_NUM )){
    $nom=$col[0];

    $atr=array();
    $atr['type']= 'atributo';
    $atr['message0']= $nom;
    $atr['previousStatement']= 'atributo';
    $atr['nextStatement']= 'atributo';
    $atr['colour']= 80;
    $atr['tooltip']= '';
    $atr['helpUrl']= '';

    $elem=array();
    $elem["datos"]=$atr;
    $elem["nombre"]=$nom;
    array_push($data,$elem);

    $cant=$cant+1;
  }	
  $arreglo=array();
  $arreglo['cant']=$cant;
  for($i=0;$i<count($data);$i++){
    $arreglo['a'.$i]=$data[$i];
  }
  $tab=array();
  $tab['type']= "tabla";
  $tab['lastDummyAlign0']= "CENTRE";
  $tab['message0']=$_GET["tabla"];
  $tab['previousStatement']= "Tabla";
  $tab['colour']= 135;
  $tab['tooltip']= "";
  $tab['helpUrl']= "";
    
  $arreglo['tabla']=$tab;

  echo( json_encode($arreglo));

?>
