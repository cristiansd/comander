<?php require_once('../includes/funcionesUsuario.php'); 

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";
include '../includes/errorIdentificacionUsuario.php';

//COMPROBAMOS SI EXISTE UNA TABLA TEMPORAL DE COMANDAS DEL USUARIO

mysql_select_db($database_usuario, $comcon_usuario);
$result = "show tables like 'comandaTemp_".$_SESSION['id_usuario']."'";
$resultados=mysql_query($result, $comcon_usuario) or die(mysql_error());
$existe = mysql_num_rows($resultados);

if ($existe){
  echo "OK";
}


?>

