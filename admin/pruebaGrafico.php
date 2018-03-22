<?php
require_once('../includes/funcionesAdmin.php');

echo "PREPARADO <br>";

$dt_Ayer= date('Y-m-d', strtotime('-1 day')) ; // resta 1 día
$dt_laSemanaPasada = date('Y-m-d', strtotime('-1 week')) ; // resta 1 semana
$dt_elMesPasado = date('Y-m-d', strtotime('-1 month')) ; // resta 1 mes
$dt_ElAnioPasado = date('Y-m-d', strtotime('-1 year')) ; // resta 1 año
//Mostrar fechas
/*echo $dt_Ayer . " ";
echo $dt_laSemanaPasada . " ";
echo $dt_elMesPasado . " ";
echo $dt_ElAnioPasado . "<br>";*/

function extraeMes(){
    $actual = date('Y-m-d');
    $mes = date('m', strtotime($actual));
    
}

extraeMes();

$DiasVista = Array();
$cantidad = Array();

function cargaArray(){
    /*$Dias = Array();
    $minus = 0;
    global $Dias, $cantidad;
    global $database_conexionComanderAdmin, $conexionComanderAdmin;
    mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
    for ($x=0;$x<=30;$x++){
       $Dias[$x] = date('Y-m-d', strtotime($minus . ' day')) ;
       //global $Dias, $cantidad;
       $query_Datos = "SELECT  SUM(importePedido) AS total FROM pedidos WHERE fechaPedido='$Dias[$x]'";
       $Datos = mysqli_query($conexionComanderAdmin, $query_Datos) or die(mysqli_connect_error());
       $row_Datos = mysqli_fetch_assoc($Datos);
       if ($row_Datos['total'] != null){
           $cantidad[$x] = $row_Datos['total'];
       }else{
           $cantidad[$x] = 0;
       }
       $minus--;
    }*/
    
    $Dias = Array();
    $minus = 0;
    global $DiasVista, $cantidad, $tipo;
    global $database_conexionComanderAdmin, $conexionComanderAdmin;
    mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
    for ($x=0;$x<=12;$x++){
                $referencia = date('Y-m-d', strtotime($minus . ' month')) ;
                $mes = date('m', strtotime($referencia));
                $anyo = date('Y', strtotime($referencia));
                $query_Datos = "SELECT SUM(importePedido) AS total FROM pedidos WHERE YEAR(fechaPedido)=$anyo AND MONTH(fechaPedido)=$mes";
                $Datos = mysqli_query($conexionComanderAdmin, $query_Datos) or die(mysqli_connect_error());
                $row_Datos = mysqli_fetch_assoc($Datos);
                if ($row_Datos['total'] != null){
                    $cantidad[$x] = $row_Datos['total'];
                }else{
                    $cantidad[$x] = 0;
                }
                $DiasVista[$x] = date('m/Y', strtotime($minus . ' month')) ;
                $minus--;
            }
}

cargaArray();
print_r($cantidad);
echo "<br>";
print_r($DiasVista);

?>