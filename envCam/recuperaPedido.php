<?php require_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";include '../includes/restriccionCam.php';date_default_timezone_set("Europe/Madrid");$fecha = date("Y-m-d");$hora = date("H:i");$estado = 1;$idUsuario = recuperaUsuario($_SESSION['MM_Username']);if ((isset($_GET["idMesa"]))) {    $idMesa = $_GET["idMesa"];    mysqli_select_db($comcon, $database_comcon);    $query_recogeIdPedido = "SELECT idPedido FROM pedidos WHERE idMesaPedido=$idMesa AND estadoMesaPedido=1";    $recogeIdPedido = mysqli_query($comcon, $query_recogeIdPedido) or die(mysqli_connect_error());    $row_recogeIdPedido = mysqli_fetch_assoc($recogeIdPedido);    $totalRows_recogeIdPedido = mysqli_num_rows($recogeIdPedido);    mysqli_free_result($recogeIdPedido);    if ($totalRows_recogeIdPedido > 1){        echo "MULT";    }else{        echo $row_recogeIdPedido['idPedido'];    }}?>