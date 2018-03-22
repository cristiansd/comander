<?php

$filename  = dirname(__FILE__).'/data.txt';//ruta del archivo

// Se almacena un nuevo mensaje en el archivo
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
if ($msg != '')
{
  file_put_contents($filename,$msg);
  die();
}

// Bucle infinito hasta que el archivo de datos no se modifica 

$lastmodif    = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;//si tiene algun dato se asigna a $lastmodif, si no se iguala a 0
$currentmodif = filemtime($filename);//extrae la ultima fecha de modificacion
$dato2 = 2;
//$dato2 = $_GET['dato2'];

while ($currentmodif <= $lastmodif) // comprobar si el archivo de datos se ha modificado
{
  usleep(10000); // dormir 10 ms para descargar la CPU
  clearstatcache();
  $currentmodif = filemtime($filename);//si la fecha/hora de modificacion es diferente a la del archivo, se rompe el ciclo y avanza despues del while
}

// return json array
$response = array();
$response['msg']       = file_get_contents($filename);
$response['timestamp'] = $currentmodif;
$response['dato2'] = $dato2;



echo json_encode($response);
flush();//Vaciar el búfer de salida del sistema

?>