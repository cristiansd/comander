<?php
//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
if(filter_input(INPUT_POST, 'local')){
$idLocal = filter_input(INPUT_POST, 'local');
}else{
    echo 'ERROR';
    exit;
}
if(filter_input(INPUT_POST, 'mesa')){
$idMesa = filter_input(INPUT_POST, 'mesa');
}else{
    echo 'ERROR';
    exit;
}

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = '$idLocal' AND disponible = 1 ";
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);

//COMPROBAMOS SI EXISTE Y HACEMOS SEGUN LO OBTENIDO
if (!$total_rows){
    echo 'ERROR';
    exit;    
}

//SI EXISTE EL LOCAL RECUPERAMOS LAS VARIABLES DE CONEXION Y CONECTAMOS AL LOCAL
$hostname_comcon = $row_comprobarUsuario['hostname_database'];
$database_comcon = $row_comprobarUsuario['name_database'];
$username_comcon = $row_comprobarUsuario['username_database'];
$password_comcon = $row_comprobarUsuario['password_database'];

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consultaMesa = "SELECT * FROM mesas WHERE idMesa = '$idMesa'";
$comprobarMesa_query = mysqli_query($comcon, $consultaMesa);
$row_comprobarMesa = mysqli_fetch_assoc($comprobarMesa_query);
$total_rows_Mesa = mysqli_num_rows($comprobarMesa_query);

//COMPROBAMOS SI EXISTE Y HACEMOS SEGUN LO OBTENIDO
if ($total_rows_Mesa){
    echo 'OK';
    exit;
}else{
    echo 'ERROR';
    exit;
}
?>

