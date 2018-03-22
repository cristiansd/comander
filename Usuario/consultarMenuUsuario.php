<?php

require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

$idProducto = filter_input(INPUT_GET, 'idSubmenu');
$informacionProducto = array();

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegProducto = "SELECT * FROM productosmenu WHERE idSubmenu=" . $idProducto . "";
$RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
$row_RegProducto = mysql_fetch_assoc($RegProducto);
$totalRows_RegProducto = mysql_num_rows($RegProducto);

$jsonData = Array();
$x = 0;
do {
    $informacionProducto = recuperarInformacionProducto($row_RegProducto['idProducto']);
    $jsonData[$x][0] = utf8_encode($row_RegProducto['idProductosMenu']);
    $jsonData[$x][1] = $row_RegProducto['idProducto'];
    $jsonData[$x][2] = $row_RegProducto['idMenu'];
    $jsonData[$x][3] = recuperaNombreProducto($row_RegProducto['idProducto']);
    $jsonData[$x][4] = recuperaimagenProducto($row_RegProducto['idProducto']);
    $jsonData[$x][5] = utf8_encode($informacionProducto[0]);
    $jsonData[$x][6] = utf8_encode($informacionProducto[1]);
    $jsonData[$x][7] = utf8_encode($informacionProducto[2]);
    $x++;
} while ($row_RegProducto = mysql_fetch_assoc($RegProducto));

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonData, JSON_FORCE_OBJECT);
?>
