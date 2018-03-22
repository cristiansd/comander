<?php
//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$id = filter_input(INPUT_GET, 'id');
$idioma = filter_input(INPUT_GET, 'idioma');

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = '$id' AND disponible = 1 ";
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);

switch ($idioma){
    case "es":
        $definicion = $row_comprobarUsuario['definicionEstablecimiento'];
        break;
    case "ca":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoCa'];
        break;
    case "en":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoEn'];
        break;
    case "de":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoDe'];
        break;
    case "fr":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoFr'];
        break;
    case "it":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoIt'];
        break;
    case "ru":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoRu'];
        break;
    case "zh":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoZh'];
        break;
    case "ja":
        $definicion = $row_comprobarUsuario['definicionEstablecimientoJa'];
        break;
    default:
        $definicion = $row_comprobarUsuario['definicionEstablecimientoEn'];
}


do{
 


$nombre = $row_comprobarUsuario['nombre_establecimiento'];
$direccion = $row_comprobarUsuario['direction'];
$aperturaSunday = $row_comprobarUsuario['apertura_Sunday'];
$cierreSunday = $row_comprobarUsuario['cierre_Sunday'];
$aperturaMonday = $row_comprobarUsuario['apertura_Monday'];
$cierreMonday = $row_comprobarUsuario['cierre_Monday'];
$aperturaTuesday = $row_comprobarUsuario['apertura_Tuesday'];
$cierreTuesday = $row_comprobarUsuario['cierre_Tuesday'];
$aperturaWednesday = $row_comprobarUsuario['apertura_Wednesday'];
$cierreWednesday = $row_comprobarUsuario['cierre_Wednesday'];
$aperturaThursday = $row_comprobarUsuario['apertura_Thursday'];
$cierreThursday = $row_comprobarUsuario['cierre_Thursday'];
$aperturaFriday = $row_comprobarUsuario['apertura_Friday'];
$cierreFriday = $row_comprobarUsuario['cierre_Friday'];
$aperturaSaturday = $row_comprobarUsuario['apertura_Saturday'];
$cierreSaturday = $row_comprobarUsuario['cierre_Saturday'];



//CARGAMOS TODO A JSON
$jsondata[$control]['nombre'] = $nombre;
$jsondata[$control]['definicion'] = $definicion;
$jsondata[$control]['direction'] = $direccion;
$jsondata[$control]['metalico'] = $row_comprobarUsuario['pago_metalico'];
$jsondata[$control]['tarjeta'] = $row_comprobarUsuario['pago_tarjeta'];
$jsondata[$control]['autopago'] = $row_comprobarUsuario['auto_pago'];
$jsondata[$control]['maxAutopago'] = $row_comprobarUsuario['max_autopago'];
$jsondata[$control]['apertura_sunday'] = $aperturaSunday;
$jsondata[$control]['cierre_sunday'] = $cierreSunday;
$jsondata[$control]['apertura_monday'] = $aperturaMonday;
$jsondata[$control]['cierre_monday'] = $cierreMonday;
$jsondata[$control]['apertura_tuesday'] = $aperturaTuesday;
$jsondata[$control]['cierre_tuesday'] = $cierreTuesday;
$jsondata[$control]['apertura_wednesday'] = $aperturaWednesday;
$jsondata[$control]['cierre_wednesday'] = $cierreWednesday;
$jsondata[$control]['apertura_thursday'] = $aperturaThursday;
$jsondata[$control]['cierre_thursday'] = $cierreThursday;
$jsondata[$control]['apertura_friday'] = $aperturaFriday;
$jsondata[$control]['cierre_friday'] = $cierreFriday;
$jsondata[$control]['apertura_saturday'] = $aperturaSaturday;
$jsondata[$control]['cierre_saturday'] = $cierreSaturday;

$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));
echo $_GET['callback'].'('.json_encode($jsondata).')';
exit;

?>

