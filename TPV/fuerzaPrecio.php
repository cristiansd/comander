<?php
require_once('../Connections/conexionComanderEnvCam.php');
require_once('../includes/funcionesEnvCam.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "3,2,1";
$MM_donotCheckaccess = "false";

include '../includes/restriccionCam.php';

if (isset($_POST['idPedido'])){
    $idPedido = $_POST['idPedido'];
    $precioForzado = $_POST['precioForzado'];
    mysqli_select_db($comcon, $database_comcon);
    $updatePrecioForzado = "UPDATE pedidos SET importeForzadoPedido=$precioForzado WHERE idPedido=$idPedido";
    $Result = mysqli_query($comcon, $updatePrecioForzado) or die(mysqli_connect_error());
    if ($Result){
       echo "OK"; 
    }else{
       echo "ERROR";
    }            
}
?>


