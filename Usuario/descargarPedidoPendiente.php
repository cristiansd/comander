<?php
require_once('../includes/funcionesUsuario.php');

//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$id = substr(filter_input(INPUT_GET, 'pedido'), 7);
if(filter_input(INPUT_GET, 'local')){
 $idLocal = filter_input(INPUT_GET, 'local');
}

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);

//CONSULTAMOS EL LOCAL DEL PEDIDO
$consultaLocal = "SELECT * FROM pedidos WHERE id_pedido = '$id'";
$comprobarLocal_query = mysqli_query($comcon, $consultaLocal);
$row_comprobarLocal = mysqli_fetch_assoc($comprobarLocal_query);
$total_rows_local = mysqli_num_rows($comprobarLocal_query);

//SETEAMOS LA VARIABLE IDLOCAL
do{
$idLocal = $row_comprobarLocal['id_local'];
}while($row_comprobarLocal = mysqli_fetch_assoc($comprobarLocal_query));

//CONSULTAMOS LA BASE DE DATOS DEL LOCAL
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = '$idLocal'";
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);

//SETEAMOS VARIABLES PARA CONECTAR CON LA BD DEL ESTABLECIMIENTO
    do{
    $database_establecimiento = $row_comprobarUsuario['name_database'];
    $username_establecimiento = $row_comprobarUsuario['username_database'];
    $password_establecimiento = $row_comprobarUsuario['password_database'];
    }while($row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query));
    
//CREAMOS LA VARIABLE DE CONEXION
$comcon_establecimiento = mysqli_connect($hostname_comcon, $username_establecimiento, $password_establecimiento);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon_establecimiento, $database_establecimiento);

$consulta_establecimiento = "SELECT * FROM comandas WHERE idPedidoComanda = '$id' AND cantidadPedidaComanda > cantidadEntregaComanda";
$comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
$row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
$total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);

do{
//RECUPERAMOS EL NOMBRE DEL PRODUCTO
    $idProducto = $row_comprobarUsuario_establecimiento['idProductoComanda'];
    $query_RegProducto = "SELECT * FROM productos WHERE idProducto=$idProducto";
    $RegProducto = mysqli_query($comcon_establecimiento, $query_RegProducto);
    $row_RegProducto = mysqli_fetch_assoc($RegProducto);
    
//PARSEAMOS LA VARIABLES OBTENIDAS
    $nombre = recuperarString($row_RegProducto['id_string']);
    $cantidad = $row_comprobarUsuario_establecimiento['cantidadPedidaComanda'];

//CARGAMOS TODO A JSON
$jsondata[$control]['nombre'] = $nombre;
$jsondata[$control]['cantidad'] = $cantidad;
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));
echo $_GET['callback'].'('.json_encode($jsondata).')';
exit;

?>

