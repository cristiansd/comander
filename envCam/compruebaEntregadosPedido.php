<?php require_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";include '../includes/restriccionCam.php';//COMPROBAMOS QUE NO QUEDAN COMANDAS POR ENTREGAR$entregados = "";$idPedido = $_POST["idPedido"]; mysqli_select_db($comcon, $database_comcon);$consulta = "SELECT idComanda FROM comandas WHERE idPedidoComanda=" . $idPedido . " AND cantidadEntregaComanda=0";$resultado = mysqli_query($comcon, $consulta) or die(mysqli_connect_error());if (mysqli_num_rows($resultado) == 0){    $updatePedidosentregado = "UPDATE pedidos SET estadoEntregadoPedido=1 WHERE idPedido=$idPedido";    $entregados = "OK";}else{    $updatePedidosentregado = "UPDATE pedidos SET estadoEntregadoPedido=0 WHERE idPedido=$idPedido";    $entregados = "NO";}$Result1 = mysqli_query($comcon, $updatePedidosentregado) or die(mysqli_connect_error());if ($Result1){    echo $entregados;}?>