<?php

  if(!empty($_GET["consulta"])){
    $consulta=$_GET["consulta"]; 

  }else{
    $consulta="show tables";
  }
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
  $res=mysqli_query($conexion_db,$consulta);  
  $salida="";  
if(!$res){
  $codigo=mysqli_errno($conexion_db);
  switch($codigo){
    case 1366:
      $salida="Error: valor incorrecto para uno de los atributos";
      break;
    case 1364:
      $salida="Error: para uno de los atributos es obligatorio ingresar un valor";
      break;
    case 1265:
      $salida="Error: valor incorrecto para uno de los atributos";	
      break;
    case 1062:
      $salida="Error: la clave ingresada ya existe";	
      break;

    default:
      $salida=mysqli_errno($conexion_db) ." - ".mysqli_error($conexion_db);        
      break;
  }

}else{
  if(substr($consulta, 0, 6) == "SELECT"){
    $salida=$salida."<table border='1'>";
    $atributos=strstr($consulta,"FROM",true);
    $atributos=substr($atributos,7);
    $salida=$salida."<tr>";
    $posComa=strpos($atributos,",");
    $cantAtributos=1;
    while($posComa!=false){
      $salida=$salida."<th> ".trim(substr($atributos, 0, $posComa))." </th>";
      $atributos=substr($atributos,$posComa+1);
      $posComa=strpos($atributos,",");
      $cantAtributos++;
    }
    $salida=$salida."<th> ".trim($atributos)." </th>";
    $salida=$salida."</tr>";
    while($col = mysqli_fetch_array( $res,MYSQLI_NUM )){      
      $salida=$salida."<tr>";
      for($a=0;$a<$cantAtributos;$a++){
        $salida=$salida."<td> ".$col[$a]." </td>";
      }
      $salida=$salida."</tr>";
    }
    $salida=$salida."</table>"; // Fin de la tabla
  }else{
    $salida="Consulta realizada con éxito";
  }
}
  $arreglo=array();
  $arreglo['salida']=$salida;
  echo( json_encode($arreglo));

?>
