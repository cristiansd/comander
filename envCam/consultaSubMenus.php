<?php require_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";include '../includes/restriccionCam.php';$idUsuario = recuperaUsuario($_SESSION['MM_Username']);mysqli_select_db($comcon, $database_comcon);$query_RegProductosMenus = "SELECT * FROM productosmenu WHERE idMenu=" . $_POST['idMenu'] . " AND idSubmenu=" . $_POST['idSubmenu'];$RegProductosMenus = mysqli_query($comcon, $query_RegProductosMenus) or die(mysqli_connect_error());while($rs = $RegProductosMenus->fetch_array(MYSQLI_ASSOC)) {    $query_ImagenProducto= "SELECT id_imagen FROM productos WHERE idProducto=" . $rs["idProducto"];    $RegImagenProducto = mysqli_query($comcon, $query_ImagenProducto) or die(mysqli_connect_error());    $row_ImagenProducto = mysqli_fetch_assoc($RegImagenProducto);    //$imagen = $row_ImagenProducto['imagenProducto'];    $imagen = $row_ImagenProducto['id_imagen'];    $nombreProducto = recuperaNombreProducto($rs["idProducto"]);    if ($outp != "") {$outp .= ",";}    $outp .= '{"idProducto":"'  . $rs["idProducto"] . '",';    $outp .= '"imagenProducto":"'  . $imagen . '",';    $outp .= '"nombreProducto":"'   . $nombreProducto . '"}';}$outp ='{"clientes":['.$outp.']}';echo($outp);?>