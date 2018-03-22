<?php
if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

require_once('../Connections/conexionComanderEnvCam.php');
$ids = array();
mysqli_select_db($comcon, $database_comcon);
$sql = "SELECT * FROM tblregistration";
   $result = mysqli_query($comcon, $sql) or die(mysqli_connect_error());
   while($row = mysqli_fetch_assoc($result)){
   array_push($ids, $row['registration_id']);
   }
$title="Notificacion de Comander";
$message="Estas pueden ser las mesas reservadas";
sendPush($ids,$title,$message);

function sendPush($registrationIds,$title,$message)
{
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyDEbxlEugoAC8Ovle09K2J3r4DuCxquvdk');
//$registrationIds = array($to);
$msg = array
(
'message' => $message,
'title' => $title,
'vibrate' => 1,
'sound' => 1,
'additionalData' => 'Oleeee'    
//'soundname' => 'sms.mp3'
    
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
echo $result;

}
