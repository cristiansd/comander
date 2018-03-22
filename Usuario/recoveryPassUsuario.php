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
$passwordUsuario = filter_input(INPUT_POST, 'password');
$emailUsuario = filter_input(INPUT_POST, 'email');

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

//COMPROBAMOS QUE EL EMAIL EXISTE
$comprobarUsuario = "SELECT * FROM usuarios_comander WHERE  email_usuario = '$emailUsuario'";
$comprobarUsuario_query = mysqli_query($comcon, $comprobarUsuario);
$num_rows_comprobarUsuario = mysqli_num_rows($comprobarUsuario_query);
$row_comprobarUsuario = mysqli_fetch_array($comprobarUsuario_query);

//SI EL NO EMAIL EXISTE PARAMOS AQUI Y LO MOSTRAMOS EN MENSAJE
if ($num_rows_comprobarUsuario) {
    
//PARSEAMOS LAS VARIABLE OBTENIDAS
//$nick = strtolower($row_comprobarUsuario['nick_usuario']);
    $id = $row_comprobarUsuario['id_usuario'];

//COMPROBAMOS SI EXISTE UNA TABLA TEMPORAL DEL USUARIO Y SI EXISTE SE ELIMINA
$compruebaTabla = "DROP TABLE IF EXISTS recoveryPassUsuario_".$id."";
mysqli_query($comcon, $compruebaTabla);

//CREAMOS UNA TABLA TEMPORAL CON LOS DATOS 
  $tablaTemporal = "CREATE TABLE recoveryPassUsuario_".$id." (password_usuario VARCHAR(20) NOT NULL,"
            . "passTemporary VARCHAR(50) NOT NULL)";    
    mysqli_query($comcon, $tablaTemporal) or die (mysqli_error($comcon));
    
//INSERTAMOS LOS DATOS EN LA TABLA TEMPORAL
   $regitserUsuario = "INSERT INTO recoveryPassUsuario_".$id." (password_usuario, passTemporary) "
            . "VALUES ('$passwordUsuario','$passUnique')";
    if (mysqli_query($comcon, $regitserUsuario)) {        
        $destinatario = $emailUsuario ; 
        $asunto = "Validación cambio de contraseña Comander"; 
        $cuerpo = "Para terminar el proceso de cambio de contraseña en el siguiente enlace"
                . " http://comander.es/Comander/Usuario/validarModificacionPass.php?email=".$emailUsuario."&clave=".$passUnique."&id=".$id."";

    mail($destinatario,$asunto,$cuerpo) ;
        echo "OK";
    } else {
        echo "ERROR";
}    
}else{
    echo "EXISTE EMAIL";
    }