<?php

//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$emailUsuario = filter_input(INPUT_POST, 'email');

//ESTABLECEMOS PARAMETROS DE CONEXIÓN A BD
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);

//COMPROBAMOS QUE EL EMAIL Y LA EL PASSWORD EXISTE
$comprobarUsuario = "SELECT * FROM usuarios_comander WHERE  email_usuario = '".$emailUsuario."'";
$comprobarUsuario_query = mysqli_query($comcon, $comprobarUsuario);
$num_rows_comprobarUsuario = mysqli_num_rows($comprobarUsuario_query);


//SI EL EMAIL EXISTE 
if ($num_rows_comprobarUsuario) {
    echo "OK";
}

