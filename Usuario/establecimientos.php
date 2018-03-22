<?php

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;

$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = 'SELECT * FROM establecimientos ';
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);
if ($total_rows){
do{
$jsondata[$control]['imagen'] = $row_comprobarUsuario['id_establecimiento'];
$control++;
}while($row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query));
}else{
    $jsondata[$control] = 'vacio';
}
echo $_GET['callback'].'('.json_encode($jsondata).')';
exit;

?>
