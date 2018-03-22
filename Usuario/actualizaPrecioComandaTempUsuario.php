<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

header("Cache-Control: no-cache, must-revalidate"); // Evitar guardado en cache del cliente HTTP/1.1
header("Pragma: no-cache"); // Evitar guardado en cache del cliente HTTP/1.0

$idPedido = filter_input(INPUT_POST, 'idPedido');

mysql_select_db($database_usuario, $comcon_usuario);
$query_Total = "SELECT SUM(totalComandaTemp) as total FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp IS NULL";
$resultado = mysql_query($query_Total, $comcon_usuario);
$row = mysql_fetch_assoc($resultado);
$totalRows = mysql_num_rows($resultado);
if ($totalRows > 0){
$precio = $row["total"];
} else {
    $precio = 0;
}
mysql_select_db($database_usuario, $comcon_usuario);
$query_RegMenus = "SELECT idMenuComandaTemp FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp IS NOT NULL GROUP BY idGrupoMenuComandaTemp";
$RegMenus= mysql_query($query_RegMenus, $comcon_usuario);
$row_RegMenus = mysql_fetch_assoc($RegMenus);
$totalRows_RegMenus = mysql_num_rows($RegMenus);
if ($totalRows_RegMenus > 0){
do {
    $precio += recuperaNombrePrecioMenu($row_RegMenus['idMenuComandaTemp'],2);
}while($row_RegMenus = mysql_fetch_assoc($RegMenus));
}
if ($totalRows > 0){
    mysql_free_result($resultado);
}
if ($totalRows > 0){
    mysql_free_result($RegMenus);
}

echo $precio;
