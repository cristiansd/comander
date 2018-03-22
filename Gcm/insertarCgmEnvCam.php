<?php
$establecimiento = filter_input(INPUT_POST, 'establecimiento');
$cgmId = filter_input(INPUT_POST, 'cgmId');
$idDevice = filter_input(INPUT_POST, 'idDevice');
//CONEXIONES

$hostname_main = "localhost";
$database_main = "eh1w1ia3_main";
$username_main = "eh1w1ia3_sangar";
$password_main = "290172crissan";

$conn_main = mysqli_connect($hostname_main, $username_main, $password_main) or trigger_error(mysqli_connect_error(),E_USER_ERROR);
mysqli_select_db($conn_main, $database_main);
$establecimiento__query="SELECT hostname_database, name_database, username_database,password_database FROM establecimientos WHERE id_establecimiento='$establecimiento'";
$establecimientoRS = mysqli_query($conn_main, $establecimiento__query) or die(mysqli_connect_error());  
$establecimientoRS_rows = mysqli_fetch_array($establecimientoRS);
$hostname_database = $establecimientoRS_rows['hostname_database'];
$name_database = $establecimientoRS_rows['name_database'];
$username_database = $establecimientoRS_rows['username_database'];
$password_database = $establecimientoRS_rows['password_database'];
echo $hostname_database;
echo $name_database;
echo $username_database;
echo $password_database;
$conn_establecimiento = mysqli_connect($hostname_database, $username_database, $password_database) or die(mysqli_connect_error());

//COMPRUEBO QUE NO EXISTE E INSERTAMOS
mysqli_select_db($conn_establecimiento, $name_database);
$sql_comprueba = "SELECT registration_id FROM tblregistration WHERE registration_id='$cgmId'";
$compruebaRS = mysqli_query($conn_establecimiento, $sql_comprueba) or die(mysqli_connect_error());
$cgmUser = mysqli_num_rows($compruebaRS);
$respuesta = "OKCORRECTO";
if (!$cgmUser) {
  $insertSQL = "INSERT INTO tblregistration (registration_id, idDevice) VALUES ('$cgmId','$idDevice')";
  $Result = mysqli_query($conn_establecimiento, $insertSQL) or die(mysqli_connect_error());
  if (!$Result){
    $respuesta = "NOOK";
  }
}
echo $respuesta;
