<?php
require_once('../Connections/conexionComanderEnvCam.php');
require_once('../includes/funcionesEnvCam.php');

$idMesa = $_POST['idMesa'];
$updateMesas = "UPDATE mesas SET estadoMesa=0, peticionMesa=0, ocupacionMesa=0, idUsuarioMesa=NULL WHERE idMesa=$idMesa";
$updateComandas = "UPDATE comandas SET estadoCerradoComanda=1 WHERE idMesaComanda=$idMesa";
$updateMesaPedido = "UPDATE pedidos SET estadoMesaPedido=0 WHERE idMesaPedido=$idMesa";
mysqli_select_db($comcon, $database_comcon);
$Result1 = mysqli_query($comcon, $updateMesas) or die(mysqli_connect_error());
$Result2 = mysqli_query($comcon, $updateComandas) or die(mysqli_connect_error());
$Result3 = mysqli_query($comcon, $updateMesaPedido) or die(mysqli_connect_error());
echo "OK";
?>