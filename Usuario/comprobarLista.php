<?php require_once('../includes/funcionesUsuario.php');
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";
include '../includes/errorIdentificacionUsuario.php';

$totalRows_RegMenus=0;

mysql_select_db($database_usuario, $comcon_usuario);
$result = "show tables like 'comandaTemp_".$_SESSION['id_usuario']."'";
$resultados=mysql_query($result, $comcon_usuario) or die(mysql_error());
$existe = mysql_num_rows($resultados);

if($existe){

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegMenus = "SELECT * FROM comandaTemp_".$_SESSION['id_usuario']."";
$RegMenus= mysql_query($query_RegMenus, $comcon_usuario) or die(mysql_error());
$row_RegMenus = mysql_fetch_assoc($RegMenus);
$totalRows_RegMenus = mysql_num_rows($RegMenus);
}
if(!$totalRows_RegMenus){
    echo "VACIA";
}