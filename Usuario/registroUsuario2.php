<?php

function generaPass() {
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena = strlen($cadena);

    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass = 30;

    //Creamos la contraseña
    for ($i = 1; $i <= $longitudPass; $i++) {
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos = rand(0, $longitudCadena - 1);
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$nickUsuario = filter_input(INPUT_POST, 'nick');
$passwordUsuario = filter_input(INPUT_POST, 'password');
$emailUsuario = filter_input(INPUT_POST, 'email');
$cgmIdUsuario = filter_input(INPUT_POST, 'idCgm');

//GENERAMOS UNA CLAVE UNICA PARA LA VALIDACION

$passUnique = generaPass();

//ESTABLECEMOS PARAMETROS DE CONEXIÓN A BD
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan"; 

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);


//COMPROBAMOS QUE EL EMAIL NO EXISTE
$comprobarUsuario = "SELECT * FROM usuarios_comander WHERE  email_usuario = '$emailUsuario'";
$comprobarUsuario_query = mysqli_query($comcon, $comprobarUsuario) or die (mysqli_error($comcon)); 
$num_rows_comprobarUsuario = mysqli_num_rows($comprobarUsuario_query);
$row_comprobarUsuario = mysqli_fetch_array($comprobarUsuario_query);

//SI EL EMAIL EXISTE PARAMOS AQUI Y LO MOSTRAMOS EN MENSAJE
if ($num_rows_comprobarUsuario) {
        if($row_comprobarUsuario['password_usuario'] == null){
            $insertar_pass = "UPDATE usuarios_comander SET password_usuario = '$passwordUsuario' WHERE email_usuario = '$emailUsuario'";
            mysqli_query($comcon, $insertar_pass) or die (mysqli_error($comcon));
            echo "OK";
        } else {
            echo "EXISTE EMAIL";
        }
        
//SI NO EXISTE LO REGISTRAMOS
   } else {
       $insert_user = "INSERT INTO usuarios_comander (email_usuario, password_usuario, key_access) VALUES ('$emailUsuario', '$passwordUsuario', '$passUnique')";
       if (mysqli_query($comcon, $insert_user)){       
        echo "OK";
    } else {
        echo "ERROR";
    }
}