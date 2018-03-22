<?php
require_once('../includes/funcionesAdmin.php');
require_once ('../jpgraph/jpgraph.php');
//require_once ('../jpgraph/jpgraph_bar.php');
require_once ('../jpgraph/jpgraph_line.php');

mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
if (isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
}else{
    $tipo = 0;
}
$DiasVista = Array();
$cantidad = Array();

function cargaArray(){
    $Dias = Array();
    $minus = 0;
    global $DiasVista, $cantidad, $tipo;
    global $database_conexionComanderAdmin, $conexionComanderAdmin;
    mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
    switch ($tipo){
        case 1:
            for ($x=0;$x<=6;$x++){
                $Dias[$x] = date('Y-m-d', strtotime($minus . ' day')) ;
                $query_Datos = "SELECT SUM(importePedido) AS total FROM pedidos WHERE fechaPedido='$Dias[$x]'";
                $Datos = mysqli_query($conexionComanderAdmin, $query_Datos) or die(mysqli_connect_error());
                $row_Datos = mysqli_fetch_assoc($Datos);
                $cantidad[$x] = $row_Datos['total'];
                $DiasVista[$x] = date('d/m', strtotime($minus . ' day')) ;
                $minus--;
            }
            break;
        case 2:
            for ($x=0;$x<=30;$x++){
                $Dias[$x] = date('Y-m-d', strtotime($minus . ' day')) ;
                $query_Datos = "SELECT SUM(importePedido) AS total FROM pedidos WHERE fechaPedido='$Dias[$x]'";
                $Datos = mysqli_query($conexionComanderAdmin, $query_Datos) or die(mysqli_connect_error());
                $row_Datos = mysqli_fetch_assoc($Datos);
                if ($row_Datos['total'] != null){
                    $cantidad[$x] = $row_Datos['total'];
                }else{
                    $cantidad[$x] = 0;
                }
                $DiasVista[$x] = date('d/m', strtotime($minus . ' day')) ;
                $minus--;
            }
            break;
        case 3:
            for ($x=0;$x<=2;$x++){
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
            break;
        case 4:
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
            break;    
    }
}

cargaArray();

//GRAFICO TIPO BARRAS
// Evita que se vean los errores
error_reporting(0);

//Array con los datos del gráfico
//$datos_azul = array(9, 5, 12, 11, 6, 10, 9, 11, 10, 4, 7, 3,9, 5, 12, 11, 6, 10, 9, 11, 10, 4, 7, 3);
//$datos_rojo = array(7,15,30,25,12,8,3,16,26,5,2,13,18,7,15,30,25,12,8,3,16,26,5,2,13,18);

// Clase que genera el gráfico de tamaño 400x300
$grafico = new Graph(1200, 550, "auto");
$grafico->SetScale("textlin");
$grafico->SetFrame(true);//Quitar el color de fondo por defecto
$grafico->SetBackgroundGradient('lightblue','lightblue',GRAD_HOR,BGRAD_PLOT);//Imagen de fondo del cuadro
$grafico->SetMargin(60,30,50,100);
$grafico->SetShadow();
$grafico->xaxis->SetTickLabels($DiasVista);
$grafico->xaxis->SetLabelAngle(40);
$grafico->title->Set("VENTAS");
$grafico->xaxis->title->Set('');
$grafico->yaxis->title->Set('');
$grafico->title->SetFont(FF_FONT1,FS_BOLD);
$grafico->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Creamos un juego de datos, del tipo linea
$lineplot = new LinePlot($cantidad);
$lineplot->SetLegend("Cantidad");
$lineplot->SetColor("red");
$lineplot->value->Show();
$lineplot->value->SetColor("black","darkred");
$lineplot->value->SetFormat('%01.2f');

// Añadimos el juego de datos
$grafico->Add($lineplot);

// Ponemos leyenda en grafico
$grafico->legend->SetFrameWeight(1);
$grafico->legend->SetColumns(2);
$grafico->legend->SetColor('#4E4E4E','#00A78A');

// Generamos el gráfico
$grafico->Stroke();
?>