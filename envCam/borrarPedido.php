<?phprequire_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');$idPedido = $_POST['idPedido'];mysqli_select_db($comcon, $database_comcon);$deleteGrupoMenu = "DELETE FROM comandas WHERE idPedidoComanda=$idPedido";$result = mysqli_query($comcon, $deleteGrupoMenu) or die(mysqli_connect_error());if ($result){echo "OK";}?>