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
$passwordUsuario = filter_input(INPUT_GET, 'password');
$emailUsuario = filter_input(INPUT_GET, 'email');
$idGoogle = filter_input(INPUT_GET, 'idgcm');
$plataforma = filter_input(INPUT_GET, 'plataforma');
$nick = filter_input(INPUT_GET, 'nick');


//GENERAMOS UNA CLAVE UNICA PARA LA VALIDACION

$passUnique = generaPass();

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();

//ESTABLECEMOS PARAMETROS DE CONEXIÓN A BD
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);

//COMPROBAMOS LA PLATAFORMA CON LA QUE ESTA LOGUEANDO Y SI ESTA REGISTRADO
switch ($plataforma){
    case 'facebook':
        $comprobarFacebook = "SELECT * FROM usuarios_comander WHERE email_usuario = '$emailUsuario'";
        $query_facebook = mysqli_query($comcon, $comprobarFacebook) or die (mysqli_error($comcon));
        $row_facebook = mysqli_fetch_assoc($query_facebook);
        $total_facebook = mysqli_num_rows($query_facebook);
        if($total_facebook){
            if($row_facebook['id_facebook'] == null){
                $insert_facebook = "UPDATE usuarios_comander SET id_facebook='$passwordUsuario' WHERE email_usuario = '$emailUsuario'";
                mysqli_query($comcon, $insert_facebook) or die (mysqli_error($comcon));
            }
        } else {
            $insert_user = "INSERT INTO usuarios_comander (nick_usuario, id_facebook, "
                    . "email_usuario, registration_id, key_access) VALUES('$nick', '$passwordUsuario', '$emailUsuario', '$idGoogle', '$passUnique')";
            mysqli_query($comcon, $insert_user) or die (mysqli_error($comcon));
        }
        $comprobarUsuario = "SELECT * FROM usuarios_comander WHERE  email_usuario = '".$emailUsuario."'";
        break;
    case 'google':
        $comprobarFacebook = "SELECT * FROM usuarios_comander WHERE email_usuario = '$emailUsuario'";
        $query_facebook = mysqli_query($comcon, $comprobarFacebook) or die (mysqli_error($comcon));
        $row_facebook = mysqli_fetch_assoc($query_facebook);
        $total_facebook = mysqli_num_rows($query_facebook);
        if($total_facebook){
            if($row_facebook['id_google_plus'] == null){
                $insert_facebook = "UPDATE usuarios_comander SET id_google_plus='$passwordUsuario' WHERE email_usuario = '$emailUsuario'";
                mysqli_query($comcon, $insert_facebook) or die (mysqli_error($comcon));
            }
        } else {
            $insert_user = "INSERT INTO usuarios_comander (nick_usuario, id_google_plus, "
                    . "email_usuario, registration_id, key_access) VALUES('$nick', '$passwordUsuario', '$emailUsuario', '$idGoogle', '$passUnique')";
            mysqli_query($comcon, $insert_user) or die (mysqli_error($comcon));
        }
        $comprobarUsuario = "SELECT * FROM usuarios_comander WHERE  email_usuario = '".$emailUsuario."'";
        break;
    case 'comander':
        $comprobarUsuario = "SELECT * FROM usuarios_comander WHERE  email_usuario = '".$emailUsuario."' AND password_usuario='".$passwordUsuario."'";
        break;
}

//REALIZAMOS LA CONSULTA CON LOS DATOS 
$comprobarUsuario_query = mysqli_query($comcon, $comprobarUsuario);
$row_usuario = mysqli_fetch_array($comprobarUsuario_query);
$num_rows_comprobarUsuario = mysqli_num_rows($comprobarUsuario_query);

//ASIGNAMOS A VARIABLES DATOS RECOGIDOS
$id_usuario = $row_usuario['id_usuario'];
$nick_usuario = $row_usuario['nick_usuario'];
$idgcm = $row_usuario['registration_id'];

//COMPROBAMOS SI EL ID GOOGLE ES EL MISMO 
if($idgcm != $idGoogle){
    $updateId = "UPDATE usuarios_comander SET"
        . " registration_id = '$idGoogle'"
        . "WHERE  email_usuario = '$emailUsuario'";
mysqli_query($comcon, $updateId);
}


//SI EL EMAIL Y EL PASSWORD EXISTEN SETEAMOS CLAVE DE ACCESO
if ($num_rows_comprobarUsuario) {
    $updateSQL = "UPDATE usuarios_comander SET"
        . " key_access = '$passUnique'"
        . "WHERE  email_usuario = '$emailUsuario'";
mysqli_query($comcon, $updateSQL);

//Y GENERAMOS EL ARCHIVO DE DEVOLUCION
$jsondata['success'] = "OK";
$jsondata['key'] = $passUnique;
$jsondata['idUser'] = $id_usuario;
$jsondata['nickUser'] = $nick_usuario;
    
//SI NO EXISTE GENERAMOS ARCHIVO DE DEVOLUCION NEGATIVO
   } else {
       $jsondata['success'] = "KO";
       $jsondata['msg'] = $comprobarUsuario;
}

//POR ULTIMO DEVOLVEMOS EL ARCHIVO
    echo $_GET['callback'].'('.json_encode($jsondata).')';
    exit;

