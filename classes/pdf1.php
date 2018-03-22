<?php

require_once '../includes/funcionesUsuario.php';
require('fpdf181/fpdf.php');

//Creamos la nueva clase pdf que hereda de fpdf

class PDF extends FPDF {
    
    var $pedido;

    function consulta() {
        define('EURO',chr(128));
        global $database_usuario, $comcon_usuario;
        mysql_select_db($database_usuario, $comcon_usuario);
        
//PRIMERO COMPROBAMOS SI HAY ALGUN MENU O OFERTA EN LA LISTA
       /* $consulta_ofertas = "SELECT * FROM comandatemp_" . $_SESSION['id_usuario'] . " WHERE idGrupoMenuComandaTemp > 0 GROUP BY idGrupoMenuComandaTemp ORDER BY id DESC";
        $query_consulta_ofetras = mysql_query($consulta_ofertas, $comcon_usuario) or die (mysql_error());
        $rows_consulta_ofertas = mysql_fetch_assoc($query_consulta_ofetras);
        $total_rows_ofertas = mysql_num_rows($query_consulta_ofetras);*/
        
//COMPROBAMOS SI HAY ALGUNA COINCIDENCIA
       /*if ($total_rows_ofertas){
            //declaramos variable de array para rellenarla con los id de menu.
            $menus = Array();
            $i = 0;
            //rellenamos el array
            do{
                $menus[$i][0] = recuperaNombreEspanishMenu($rows_consulta_ofertas['idMenuComandaTemp']);
                $menus[$i][1] = $rows_consulta_ofertas['idMenuComandaTemp'];
                $menus[$i][2] = recuperaNombrePrecioMenu($rows_consulta_ofertas['idMenuComandaTemp'], 2);               
                $i++;
            }while($rows_consulta_ofertas = mysqli_fetch_array($query_consulta_ofetras));
            $comprobador = Array();
        if ( count($menus)){
           //recorremos el array buscando si hay duplicados y reasignamos           
           for ($e = 0 ; $e < count($menus); $e++){
               $comprobador[$e] = $menus[$e][1];               
           } 
        }
    }*/
        //recontamos y sumamos cantidades y sacamos el precio
        /*$arreglado = (array_count_values($comprobador));
        $ordenado = array_keys($arreglado);
        $sinrepetir = array_unique($comprobador);
        $sinrepetir = array_keys($sinrepetir);
        
        $registros = Array();
        for ($i = 0; $i < count($sinrepetir); $i++){
            $registros[$i][0] = $menus[$sinrepetir[$i]][0];
            $registros[$i][1] = $arreglado[$ordenado[$i]];
            $registros[$i][2] = $menus[$sinrepetir[$i]][2];
            $registros[$i][2] = (($registros[$i][2])*$registros[$i][1]);
        }
        }*/

//HACEMOS CONSULTA DE LA TABLA TEMPORAL DEL USUARIO
        $comandaTemporal_Query = "SELECT * FROM comandatemp_" . $_SESSION['id_usuario'] . " WHERE idGrupoMenuComandaTemp IS NULL";
        $RegComandasTemp = mysql_query($comandaTemporal_Query, $comcon_usuario) or die(mysql_error());
        $row_ComandaTemp = mysql_fetch_assoc($RegComandasTemp);     


//REALIZAMOS CONSULTA DE LA ULTIMA FACTURA PARA OBTENER EL NUMERO
        $consulta_factura = "SELECT numero_factura FROM facturas ORDER BY id DESC";
        $consulta_factura_query = mysql_query($consulta_factura, $comcon_usuario) or die(mysql_error());
        $row_consulta_factura = mysql_fetch_array($consulta_factura_query);
        
//ASIGNAMOS LOS DATOS OBTENIDOS A VARIABLES
        $numeroFactura = $row_consulta_factura['0'] + 1;
        
//REALIZAMOS CONSULTA DE LA SUMA DEL PEDIDO
        $result = mysql_query("SELECT SUM(totalComandaTemp) as total FROM comandatemp_".$_SESSION['id_usuario']."");	
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $pedidoTotal = $row["total"];
        //comprobamos si hay menus y si es asi le sumamos los valores
        /*if ( count($registros)){
            //si existen registros recorremos estos para sumar cada uno al total
            for ($a = 0; $a < count($registros); $a++){
                $pedidoTotal += $registros[$i][2];
            }
        }*/
        //para finalizar colocamos el caracter del euro
        //$pedidoTotal = $pedidoTotal.EURO;
        
//DECLARAMOS LOS VALORES PARA LA CONEXION A LA BD
        $hostname_main = "localhost";
        $database_main = "eh1w1ia3_main";
        $username_main = "eh1w1ia3_sangar";
        $password_main = "290172crissan";
        $conn_main = mysql_connect($hostname_main, $username_main, $password_main) or trigger_error(mysql_connect_error(), E_USER_ERROR);
        
        mysql_select_db($database_main, $conn_main);
        
//DECLARAMOS LAS VARIABLES NECESARIAS
        $id_establecimiento = $_SESSION['establecimiento'];
        
//REALIZAMOS CONSULTA DE LOS DATOS DEL LOCAL
        $consulta_local = "SELECT nombre_establecimiento, nombre_fiscal, CIF, direction, iva FROM establecimientos WHERE id_establecimiento = '$id_establecimiento'";
        $consulta_local_query = mysql_query($consulta_local, $conn_main) or die (mysql_error());
        $row_consulta_local = mysql_fetch_array($consulta_local_query);
        
//ASIGNAMOS LAS VARIABLES CONSULTADAS
        $nombreEstablecimiento = utf8_decode($row_consulta_local['nombre_establecimiento']);
        $nombreFiscal = utf8_decode($row_consulta_local['nombre_fiscal']);
        $cif = $row_consulta_local['CIF'];
        $direccion = utf8_decode($row_consulta_local['direction']);        
        $iva = $row_consulta_local['iva'];
        $textoIva = "I.V.A del ".$iva." % incluido";
        
        //Instaciamos la clase para genrear el documento pdf
        $pdf = new FPDF();

//Agregamos la primera pagina al documento pdf
        $pdf->AddPage();

//Seteamos el tiupo de letra y creamos el titulo de la pagina. No es un encabezado no se repetira
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(185, 6, $nombreEstablecimiento, 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(185, 6, $nombreFiscal, 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(20, 6, 'CIF/NIF: ', 0, 0, 'L');
        $pdf->Cell(20, 6, $cif, 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(30, 6, 'DIRECCION: ', 0, 0, 'L');
        $pdf->Cell(155, 6, $direccion, 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(55, 6, 'FACTURA SIMPLIFICADA: ', 0, 0, 'L');
        $pdf->Cell(20, 6, $numeroFactura, 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(20, 6, 'FECHA: ', 0, 0, 'L');
        $pdf->Cell(20, 6, date('d/m/Y'), 0, 0, 'L');
        $pdf->Ln(10);

//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
        $pdf->SetFillColor(232, 232, 232);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(125, 6, 'Producto', 1, 0, 'C', 1);
        $pdf->Cell(30, 6, 'Cantidad', 1, 0, 'C', 1);
        $pdf->Cell(30, 6, 'Total', 1, 0, 'C', 1);
        $pdf->Ln(10);

        do {
            $producto = utf8_decode(recuperaNombreEspanishProducto($row_ComandaTemp['idProductoComandaTemp']));
            $cantidad = $row_ComandaTemp['cantidadComandaTemp'];
            $total = $row_ComandaTemp['totalComandaTemp'].EURO;
            
            $pdf->Cell(125, 15, $producto, 1, 0, 'L', 0);
            $pdf->Cell(30, 15, $cantidad, 1, 0, 'C', 1);
            $pdf->Cell(30, 15, $total, 1, 0, 'C', 1);
            
            $pdf->Ln(15);
            
        } while ($row_ComandaTemp = mysql_fetch_assoc($RegComandasTemp));
        
//COMPROVAMOS SI HAY MENUS Y SI ES ASI SE COLOCAN AL FINAL
        /*if ( count($registros)){
           //recorremos el array buscando si hay duplicados y reasignamos           
           
            
            //recorremos el array y colocamos los valores
            for ($w = 0; $w < count($registros); $w++){
                
                $pdf->Cell(125, 15, $menu_1[$w][0], 1, 0, 'L', 0);
                $pdf->Cell(30, 15, $menu_1[$w][1], 1,  0, 'C', 1);
                $pdf->Cell(30, 15, $menu_1[$w][2].EURO, 1, 0, 'C', 1);

                $pdf->Ln(15);
            }
        }*/
        
        $pdf->Cell(125, 15, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 15, 'TOTAL PEDIDO', 1, 0, 'C', 1);
        $pdf->Cell(30, 15, $pedidoTotal, 1, 0, 'C', 1);
        $pdf->Ln(5);
        $pdf->Cell(185, 6, $textoIva, 0, 0, 'L');
        $documento = 'tiquets/pedido_'.$this->pedido.'.pdf';
        $pdf->Output($documento,'F');
        
//GENERAMOS LA SUBIDA DEL PDF A LA BD DEL LOCAL
//CODIFICAMOS LA IMAGEN EN BINARIO PARA SUBIRLA A LA BASE DE DATOS
    $tipo = "application/pdf";
    $fd = fopen ($documento, "r");
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        $imagen = addslashes($buffer);
    }
        
//CALCULAMOS EL IVA Y LA BASE IMPONIBLE
        $operadorIva = '1.'.$iva;
        $ivaOperacion = floatval($operadorIva); 
        $base_imponible = round(($pedidoTotal/$ivaOperacion), 2);   
        $iva_del_total = $pedidoTotal - $base_imponible;
        $fecha = date('Y-m-d');
        
//INSERTAMOS NUEVA FACTURA EN LA TABLA FACTURAS DEL LOCAL
        mysql_select_db($database_usuario, $comcon_usuario);
        $insert_factura = "INSERT INTO facturas (numero_factura, base_imponible, tipo_iva, fecha, iva, total, pdf, tipo_pdf) VALUES ('$numeroFactura', '$base_imponible', '$iva', '$fecha', '$iva_del_total', '$pedidoTotal', '$imagen', '$tipo')";
        mysql_query($insert_factura, $comcon_usuario) or die(mysql_error());       
        
    }

}