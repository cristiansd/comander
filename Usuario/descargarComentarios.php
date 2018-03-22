<?php
//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$id = filter_input(INPUT_GET, 'id');

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;
$idCat;
$imagen;
$nombre;
$precio;

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = '$id'";
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

$consulta_establecimiento = "SELECT * FROM comentarios ORDER BY fecha DESC";
$comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
$row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
$total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);

//PARSEAMOS LA VARIABLES OBTENIDAS
do{
$nick = $row_comprobarUsuario_establecimiento['nick'];
$puntuacion = $row_comprobarUsuario_establecimiento['puntuacion'];
$comentario = $row_comprobarUsuario_establecimiento['comentario'];
$fecha = date("d/m/Y",strtotime($row_comprobarUsuario_establecimiento['fecha'])); 

//CARGAMOS TODO A JSON
$jsondata[$control]['nick'] = utf8_encode($nick);
$jsondata[$control]['puntuacion'] = $puntuacion;
$jsondata[$control]['comentario'] = utf8_encode($comentario);
$jsondata[$control]['fecha'] = $fecha;
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));
echo $_GET['callback'].'('.json_encode($jsondata).')';
exit;

?>

