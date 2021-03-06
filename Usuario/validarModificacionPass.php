<?php

//INCLUIMOS ARCHIVOS NECESARIO
include '../Gcm/sending_push.php';

//ASIGNAMOS A VARIABLE LOS GET RECIBIDOS Y CONVERTIMOS EN MINUSCULAS EL NICK PARA QUE COINCIDA CON LA BD
$emailUsuario = strtolower(filter_input(INPUT_GET, 'email'));
$clave = filter_input(INPUT_GET, 'clave');
$id = filter_input(INPUT_GET, 'id');

//CREAMOS VARIABLE DE CONTROL
$control;

//ESTABLECEMOS PARAMETROS DE CONEXIÓN A BD
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysql_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysql_select_db($database_comcon, $comcon);

//COMPROBAMOS QUE EXISTE LA TABLA DE ACCESO TEMPORAL 
$result = "show tables like 'recoveryPassUsuario_".$id."'";
$resultados = mysql_query($result, $comcon) or die(mysql_error());
$existe = mysql_num_rows($resultados);

//CONDICIONAMOS SI EXISTE O NO
if (!$existe) {
    $control = 0;
    
//SI EXISTE SEGUIMOS
} else {
    
//RECUPERAMOS LA VARIABLE DE ACCESO
    $comprobarUsuario = "SELECT * FROM recoveryPassUsuario_".$id."";
    $comprobarUsuario_query = mysql_query($comprobarUsuario, $comcon);
    $num_rows_comprobarUsuario = mysql_num_rows($comprobarUsuario_query);
    $row_comprobarUsuario = mysql_fetch_array($comprobarUsuario_query);
    
//PARSEAMOS LAS VARIABLES NECESARIAS
    $password = $row_comprobarUsuario['password_usuario'];

//COMPROBAMOS QUE LA CLAVE RECIBIDA ES LA MISMA QUE LA RECUPERADA DE LA BD SI NO ES ASI SE LE PEDIRÁ REGISTRARSE DE NUEVO
    if (strcmp ($clave , $row_comprobarUsuario['passTemporary'] ) !== 0){
        $control = 0;
        
//SI ES IGUAL ACTUALIZAMOS LOS DATOS DE LA TABLA TEMPORAL EN LA TABLA DE USUARIOS COMANDER
    } else {
        $insertSQL = "UPDATE usuarios_comander SET password_usuario = '".$password."' WHERE email_usuario = '".$emailUsuario."'";
        $resultado = mysql_query( $insertSQL, $comcon) or die(mysql_error());
        
//SI HA FUNCIONADO TODO CORRECTO 
        if ($result) {
            
            //PONEMOS CONTROL EN TRUE
            $control = 2;            
         
//ELIMINAMOS LA TABLA TEMPORAL
            $deleteTable = "DROP table recoveryPassUsuario_".$id."";
            $deleteQuery = mysql_query($deleteTable, $comcon);
            
//COMPROBAMOS QUE SE HA REALIZADO EL QUERY SI NO MOSTRAMOS MENSAJE DE ERROR
        } else {
            $control = 1;
        }
    }
}
?>

<!DOCTYPE html> 
<html>
    <head>
        <meta charset="utf-8">
        <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../estilos/w3.css">
        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">
        <style>
            .no-seleccionable {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none; 
            }
        </style>

        <script type="text/javascript">

            function mostrar(control) {
                if (control === 0) {
                    document.getElementById('id2').style.display = 'block';
                } else if (control === 1) {
                    document.getElementById('id3').style.display = 'block';
                } else if (control === 2) {
                    document.getElementById('id1').style.display = 'block';
                }
            }

            $(document).ready(function () {
                mostrar(<?php echo $control; ?>);
            });
        </script>

    </head> 
    <body class="w3-light-grey">
        <div class="no-seleccionable">
            <header class="w3-container w3-card-4 w3-theme header">
                <h3 class=" w3-center" style="margin-top: 10px;">
                    <img src="../imagenes/mano.png" class="w3-round-small w3-centered" alt="Norway" style="width:25px;height: 40px;">Comander
                </h3>
            </header>
            <div class="w3-panel  w3-card-2 w3-border-top w3-border-bottom w3-container w3-padding-4 w3-theme-l5" style="margin-top: 0px!important;">            
                <div class="w3-large w3-center w3-text-indigo">VALIDACION REGISTRO</div>              
            </div>
            <div id="id1" class="w3-modal" style="display: none; margin-top: 50px;">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2 w3-center"> 
                        <h4 id="elemento">Enhorabuena!!!</h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <b>El proceso de se ha realizado.</b>
                        <br><br>
                    </div>
                </div>    
            </div>
            <div id="id2" class="w3-modal" style="display: none; margin-top: 50px;">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-yellow w3-center"> 
                        <h4 id="elemento">Atención!!!</h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <b>La clave enviada ya ha sido utilizada.</b>
                        <br><br>
                    </div>
                </div>    
            </div>
            <div id="id3" class="w3-modal" style="display: none; margin-top: 50px;">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-yellow w3-center"> 
                        <h4 id="elemento">Atención!!!</h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <b>Se ha producido un error.</b>
                        <b>Prueba de nuevo</b>
                        <br><br>
                    </div>
                </div>    
            </div>
        </div>
    </body>
</html>



