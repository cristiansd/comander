<?php require_once('../includes/funcionesUsuario.php');
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";
include '../includes/errorIdentificacionUsuario.php';
if(filter_input(INPUT_POST, 'idComanda')){
$idComanda = filter_input(INPUT_POST, 'idComanda');
mysql_select_db($database_usuario, $comcon_usuario);
$deleteComandas = "DELETE FROM comandaTemp_".$_SESSION['id_usuario']." WHERE id=$idComanda";
$result = mysql_query($deleteComandas, $comcon_usuario) or die(mysql_error());
}
if(filter_input(INPUT_POST, 'idGrupoMenu')){
$idComanda = filter_input(INPUT_POST, 'idGrupoMenu');
mysql_select_db($database_usuario, $comcon_usuario);
$deleteComandas = "DELETE FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp=$idComanda";
$result = mysql_query($deleteComandas, $comcon_usuario) or die(mysql_error());
}
if ($result){echo "OK";}