<?php
if (!isset($_SESSION)) {
  session_start();
}

function envioGCM($establecimiento, $mensaje, $idUser){
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
    $conn_establecimiento = mysqli_connect($hostname_database, $username_database, $password_database) or trigger_error(mysqli_error(),E_USER_ERROR);
    mysqli_select_db($conn_establecimiento, $name_database);
    
    //RECUPERAMOS A QUIEN ENVIAR
    $ids = array();
    if ($idUser == ""){
            $query_Device = "SELECT idDevice FROM usuarios WHERE estadoUsuario=1 AND estadoNotificacionUsuario=1";
        } else {
            $query_Device = "SELECT idDevice FROM usuarios WHERE idUsuario=$idUser AND estadoUsuario=1 AND estadoNotificacionUsuario=1";
        }
        $RegDevice = mysqli_query($conn_establecimiento, $query_Device) or die(mysqli_connect_error());
            while($row_device = mysqli_fetch_assoc($RegDevice)){
            $destino = $row_Device['idDevice'];
            $sql = "SELECT registration_id FROM tblregistration WHERE idDevice='$destino'";
            $resultado = mysqli_query($conn_establecimiento, $sql) or die(mysqli_connect_error());
            $row_resultado = mysqli_fetch_assoc($resultado);
            array_push($ids, $row_resultado['registration_id']);   
        }
    $title = "Notificacion de Comander";
    $message = $mensaje;
    //ENVIAMOS
    //print_r($ids);
    sendPush($ids,$title,$message);
}

function sendPush($registrationIds,$title,$message){
    // API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AIzaSyDEbxlEugoAC8Ovle09K2J3r4DuCxquvdk');
    $msg = array
    (
    'message' => $message,
    'title' => $title,    
    'vibrate' => 1
    // you can also add images, additionalData
    );
    $fields = array
    (
    'registration_ids' => $registrationIds,
    'data' => $msg
    );
    $headers = array
    (
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    
    //if (strcasecmp ( strval($result) , 'NotRegistered' )) {
    //$db->deleteUser($strRegID);
   //}
   //echo $result;
}
