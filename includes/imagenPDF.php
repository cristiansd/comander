<?php

$id = filter_input(INPUT_GET, 'id');

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "cristian";
$password_comcon = "comander";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = 1";
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

//REALIZAMOS LA CONSULTA
$query_RegSubCategorias= "SELECT * FROM facturas WHERE id='$id'";
$result = mysqli_query($comcon_establecimiento, $query_RegSubCategorias)or die(mysqli_error($comcon_establecimiento));
$result_array = mysqli_fetch_array($result);
$tipo = $result_array['tipo_pdf'];
header("Content-Type: $tipo");
echo $result_array['pdf'];