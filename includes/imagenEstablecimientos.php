<?php

//DECLARAMOS LAS VARIABLES RECIBIDAS
$id = filter_input(INPUT_GET, 'id');

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);

//REALIZAMOS LA CONSULTA
$query_RegSubCategorias= "SELECT id_imagen, tipo FROM establecimientos WHERE id_establecimiento='$id'";
$result = mysqli_query($comcon, $query_RegSubCategorias)or die(mysqli_error($comcon));
$result_array = mysqli_fetch_array($result);
$tipo = $result_array['1'];
header("Content-Type: $tipo");
echo $result_array['0'];