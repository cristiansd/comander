<?php
//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$lat = filter_input(INPUT_GET, 'lat');
$lng = filter_input(INPUT_GET, 'lng');
$distance = filter_input(INPUT_GET, 'distance');

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;

//CREAMOS FUNCION PARA RECUPERAR POR DISTANCIA
function getBoundaries($lat, $lng, $distance, $earthRadius = 6371)
{
    $return = array();
     
    // Los angulos para cada dirección
    $cardinalCoords = array('north' => '0',
                            'south' => '180',
                            'east' => '90',
                            'west' => '270');

    $rLat = deg2rad($lat);
    $rLng = deg2rad($lng);
    $rAngDist = $distance/$earthRadius;

    foreach ($cardinalCoords as $name => $angle)
    {
        $rAngle = deg2rad($angle);
        $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
        $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));

         $return[$name] = array('lat' => (float) rad2deg($rLatB), 
                                'lng' => (float) rad2deg($rLonB));
    }

    return array('min_lat'  => $return['south']['lat'],
                 'max_lat' => $return['north']['lat'],
                 'min_lng' => $return['west']['lng'],
                 'max_lng' => $return['east']['lng']);
}


/*$lat  =  41.4378689;//LA LATITUD DEL DISPOSITIVO
$lng =  2.196618;//LA LONGITUD DEL DISPOSITIVO
$distance = 1000; // Sitios que se encuentren en un radio de 1KM*/
$box = getBoundaries($lat, $lng, $distance);

$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = 'SELECT *, (6371 * ACOS( 
                                            SIN(RADIANS(lat)) 
                                            * SIN(RADIANS(' . $lat . ')) 
                                            + COS(RADIANS(lng - ' . $lng . ')) 
                                            * COS(RADIANS(lat)) 
                                            * COS(RADIANS(' . $lat . '))
                                            )
                               ) AS distance
                     FROM establecimientos
                     WHERE (lat BETWEEN ' . $box['min_lat']. ' AND ' . $box['max_lat'] . ')
                     AND (lng BETWEEN ' . $box['min_lng']. ' AND ' . $box['max_lng']. ')
                     AND disponible = 1 
                     HAVING distance  < ' . $distance . '                                       
                     ORDER BY distance ASC ';
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);
if ($total_rows){
do{
    if(filter_input(INPUT_GET, 'idioma')){
        $idioma = filter_input(INPUT_GET, 'idioma');
        switch ($idioma){
            case 'es':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimiento'];
                break;
            case 'ca':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoCa'];
                break;
            case 'en':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoEn'];
                break;
            case 'de':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoDe'];
                break;
            case 'fr':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoFr'];
                break;
            case 'it':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoIt'];
                break;
            case 'ru':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoRu'];
                break;
            case 'zh':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoZh'];
                break;
            case 'ja':
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoJa'];
                break;
            default: 
                $jsondata[$control]['definicion'] = $row_comprobarUsuario['definicionEstablecimientoEn'];  
        }
    }
$jsondata[$control]['id'] = $row_comprobarUsuario['id_establecimiento'];
$jsondata[$control]['distance'] = number_format($row_comprobarUsuario['distance'], 2);
$jsondata[$control]['direction'] = $row_comprobarUsuario['direction'];
$jsondata[$control]['imagen'] = $row_comprobarUsuario['imagen'];
$jsondata[$control]['lat'] = $row_comprobarUsuario['lat'];
$jsondata[$control]['lng'] = $row_comprobarUsuario['lng'];
$jsondata[$control]['nombre_establecimiento'] = $row_comprobarUsuario['nombre_establecimiento'];
$jsondata[$control]['puntuacion'] = $row_comprobarUsuario['puntuacion'];
$jsondata[$control]['cant_comentarios'] = $row_comprobarUsuario['cant_comentarios'];
$jsondata[$control]['apertura'] = date("H:i", strtotime($row_comprobarUsuario['apertura_'.date("l")]));
$jsondata[$control]['cierre'] = date("H:i", strtotime($row_comprobarUsuario['cierre_'.date("l")]));
$control++;
}while($row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query));
}else{
    $jsondata[$control] = 'vacio';
}
echo $_GET['callback'].'('.json_encode($jsondata).')';
exit;

?>
