<?phprequire_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";include '../includes/restriccionCam.php';if ((isset($_POST['idProducto']))) {    date_default_timezone_set("Europe/Madrid");    $hora = date("H:i");    $idUsuario = recuperaUsuario($_SESSION['MM_Username']);    $estadoComentario = 1;    $comentario = $_POST['comentario'];    if ($comentario == ""){        $estadoComentario = 0;    }    $idPedido = $_POST['idPedido'];    $idProducto = $_POST['idProducto'];    $cantidad = $_POST['cantidad'];    $precioProducto = recuperaPrecio($idProducto);    $precioTotal = $precioProducto * $cantidad;    $envioComanda = recuperaEnvioProducto($idProducto);    $idMesa = recuperaIdMesa($idPedido);    $estadoPedir = 1;    mysqli_select_db($comcon, $database_comcon);    $insertSQL = "INSERT INTO comandas (idMesaComanda, idPedidoComanda, idUsuarioComanda, idProductoComanda, cantidadPedidaComanda, totalComanda, comentarioComanda, estadoComentarioComanda, horaComandaPedida, horaComandaEnviada, estadoPedirComanda, envioComanda ) VALUES "            . "($idMesa, $idPedido, $idUsuario, $idProducto, $cantidad, $precioTotal, '$comentario', $estadoComentario, '$hora', '$hora', $estadoPedir, $envioComanda)";    $Result1 = mysqli_query($comcon, $insertSQL) or die(mysqli_connect_error());    if ($Result1){        echo "OK";                }else{        echo "fail";    }}