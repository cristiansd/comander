<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

$idProducto = filter_input(INPUT_GET, 'idGrupo');

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegProducto = "SELECT * FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp=".$idProducto." ORDER BY idSubmenuComandaTemp ASC";
$RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
$row_RegProducto = mysql_fetch_assoc($RegProducto);
$totalRows_RegProducto = mysql_num_rows($RegProducto);

$jsonData = Array();
$x=0;
do{    
    $jsonData[$x][0] = $row_RegProducto['id'];
    $jsonData[$x][1] = recuperaNombreProducto($row_RegProducto['idProductoComandaTemp']);   
    $x++;
}while($row_RegProducto = mysql_fetch_assoc($RegProducto)); 

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonData, JSON_FORCE_OBJECT);


?>
