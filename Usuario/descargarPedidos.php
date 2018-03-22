<?php

//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$id = filter_input(INPUT_GET, 'idUser');

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
$consulta = "SELECT * FROM pedidos WHERE id_usuario='$id' ORDER BY id DESC";
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);

//SETEAMOS VARIABLES PARA CONECTAR CON LA BD DEL ESTABLECIMIENTO
do {
    $jsondata[$control]['tiquet'] = $row_comprobarUsuario['tiquet'];
    $jsondata[$control]['estado'] = $row_comprobarUsuario['estado'];
    $jsondata[$control]['fecha'] = $row_comprobarUsuario['fecha'];
    $control++;
} while ($row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query));

echo $_GET['callback'] . '(' . json_encode($jsondata) . ')';
exit;
?>

