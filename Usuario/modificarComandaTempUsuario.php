<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

$comentario = "";

/* @var $idComanda type */

if (filter_input(INPUT_POST,'id')){
    $idComanda = filter_input(INPUT_POST,'id');
    $producto = filter_input(INPUT_POST,'idProducto');
    
    mysql_select_db($database_usuario, $comcon_usuario);
    $updateSQL = "UPDATE comandaTemp_".$_SESSION['id_usuario']." SET"
    . " idProductoComandaTemp = $producto, comentarioComandaTemp='$comentario'"
    . " WHERE id=$idComanda";
    $Result1 = mysql_query($updateSQL, $comcon_usuario) or die(mysql_error());  
    
}else{

if(filter_input(INPUT_POST,'cantidad')){
$idComanda = filter_input(INPUT_POST,'idComanda');
$cantidad = filter_input(INPUT_POST,'cantidad');
$comentario = filter_input(INPUT_POST,'comentario');

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegComanda = "SELECT idProductoComandaTemp FROM comandaTemp_".$_SESSION['id_usuario']." WHERE id=".$idComanda;
$RegComanda = mysql_query($query_RegComanda, $comcon_usuario) or die(mysql_error());
$row_RegComanda = mysql_fetch_assoc($RegComanda);

$totalComanda = recuperaPrecio($row_RegComanda['idProductoComandaTemp'])*$cantidad;

$updateSQL = "UPDATE comandaTemp_".$_SESSION['id_usuario']." SET"
        . " comandaTemp_".$_SESSION['id_usuario'].".cantidadComandaTemp=$cantidad,"
        . " comandaTemp_".$_SESSION['id_usuario'].".totalComandaTemp=$totalComanda,"
        . " comandaTemp_".$_SESSION['id_usuario'].".comentarioComandaTemp='$comentario'"
        . " WHERE id=$idComanda";
$Result1 = mysql_query($updateSQL, $comcon_usuario) or die(mysql_error());
} else {
    
$idComanda = filter_input(INPUT_POST,'idComanda');    
$comentario = filter_input(INPUT_POST,'comentario');

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegComanda = "SELECT idProductoComandaTemp FROM comandaTemp_".$_SESSION['id_usuario']." WHERE id=".$idComanda;
$RegComanda = mysql_query($query_RegComanda, $comcon_usuario) or die(mysql_error());
$row_RegComanda = mysql_fetch_assoc($RegComanda);

$updateSQL = "UPDATE comandaTemp_".$_SESSION['id_usuario']." SET"
        . " comandaTemp_".$_SESSION['id_usuario'].".comentarioComandaTemp='$comentario'"
        . " WHERE id=$idComanda";
$Result1 = mysql_query($updateSQL, $comcon_usuario) or die(mysql_error());  
}
}
if($Result1){
echo "OK";}
