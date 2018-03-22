<?php
$menus = Array();
$pedidoTotal = 0;
/*$menus[0][0] = "bocadillo del dia";
$menus[0][1] = 12;
$menus[0][2] = 15;

$menus[1][0] = "menu diario";
$menus[1][1] = 15;
$menus[1][2] = 20;

$menus[2][0] = "bocadillo del dia";
$menus[2][1] = 12;
$menus[2][2] = 15;

$menus[3][0] = "menu io";
$menus[3][1] = 2;
$menus[3][2] = 17;

$menus[4][0] = "bocadillo del dia";
$menus[4][1] = 12;
$menus[4][2] = 15;

$menus[5][0] = "menu diario";
$menus[5][1] = 15;
$menus[5][2] = 20;

$menus[6][0] = "menu iorororo";
$menus[6][1] = 3;
$menus[6][2] = 18;

$comprobador = Array();
        if ( count($menus)){
           //recorremos el array buscando si hay duplicados y reasignamos           
           for ($e = 0 ; $e < count($menus); $e++){
               $comprobador[$e] = $menus[$e][1];               
           } 
        }
        $arreglado = (array_count_values($comprobador));
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
        //recorremos el array y colocamos los valores
           for ($w = 0; $w < count($registros); $w++){
                echo $registros[$w][0]."<br>".$registros[$w][1]."<br>".$registros[$w][2]."<br><br><br><br>";
           }*/

$_SESSION['id_usuario'] = 15;
//DECLARAMOS LOS VALORES PARA LA CONEXION A LA BD
        $hostname_main = "localhost";
        $database_main = "eh1w1ia3_coman";
        $username_main = "eh1w1ia3_sangar";
        $password_main = "290172crissan";
        $conn_main = mysql_connect($hostname_main, $username_main, $password_main) or trigger_error(mysql_connect_error(), E_USER_ERROR);        
        mysql_select_db($database_main, $conn_main);
        
        function recuperaNombreEspanishMenu($idProducto) {
            global $database_main, $conn_main;

            mysql_select_db($database_main, $conn_main); 

            $query_RegProducto = "SELECT id_string FROM menus WHERE idMenu=$idProducto";
            $RegProducto = mysql_query($query_RegProducto, $conn_main) or die(mysql_error());
            $row_RegProducto = mysql_fetch_assoc($RegProducto);
            $id_string = $row_RegProducto['id_string'];

            $query_consultaFuncion = sprintf("SELECT spanish FROM strings WHERE id = %s", 
            $id_string);
            $consultaFuncion = mysql_query($query_consultaFuncion, $conn_main);
            $row_consultaFuncion = mysql_fetch_assoc($consultaFuncion);
            return $row_consultaFuncion['spanish'];
        }
        
        function recuperaNombrePrecioMenu($idMenu, $cual) {
            global $database_main, $conn_main;
            mysql_select_db($database_main, $conn_main);
            $query_RegSubMenu = "SELECT nombreMenu, precioMenu, id_string FROM menus WHERE idMenu=$idMenu";
            $RegSubMenu = mysql_query($query_RegSubMenu, $conn_main) or die(mysql_error());
            $row_RegSubMenu = mysql_fetch_assoc($RegSubMenu);
            $totalRows_RegSubMenu = mysql_num_rows($RegSubMenu);
            if ($cual == 1) {
                $devuelve = recuperarString($row_RegSubMenu['id_string']);
            }
            if ($cual == 2) {
                $devuelve = $row_RegSubMenu['precioMenu'];
            }
            mysql_free_result($RegSubMenu);
            return $devuelve;
        }

//PRIMERO COMPROBAMOS SI HAY ALGUN MENU O OFERTA EN LA LISTA
        $consulta_ofertas = "SELECT * FROM comandatemp_" . $_SESSION['id_usuario'] . " WHERE idGrupoMenuComandaTemp IS NOT NULL  GROUP BY idGrupoMenuComandaTemp";
        $query_consulta_ofetras = mysql_query($consulta_ofertas, $conn_main) or die (mysql_error());
        $rows_consulta_ofertas = mysql_fetch_array($query_consulta_ofetras);
        $total_rows_ofertas = mysql_num_rows($query_consulta_ofetras);
        
        echo $total_rows_ofertas;
        echo "<br>";
//COMPROBAMOS SI HAY ALGUNA COINCIDENCIA
        if ($total_rows_ofertas){
            //declaramos variable de array para rellenarla con los id de menu.
            $menus = Array();
            //rellenamos el array
            $i = 0;
            do{
                $menus[$i][0] = recuperaNombreEspanishMenu($rows_consulta_ofertas['idMenuComandaTemp']);
                $menus[$i][1] = $rows_consulta_ofertas['idMenuComandaTemp'];
                $menus[$i][2] = recuperaNombrePrecioMenu($rows_consulta_ofertas['idMenuComandaTemp'], 2);   
                $i++;
            }while($rows_consulta_ofertas = mysql_fetch_array($query_consulta_ofetras));               
            print_r($menus);
            echo "<br>";
            $comprobador = Array();
            if ( count($menus)){
                //recorremos el array buscando si hay duplicados y reasignamos           
                for ($e = 0 ; $e < count($menus); $e++){
                    $comprobador[$e] = $menus[$e][1];               
                } 
            }
            //recontamos y sumamos cantidades y sacamos el precio
            $arreglado = (array_count_values($comprobador));
            print_r($arreglado);
            echo "<br>";
            $ordenado = array_keys($arreglado);
            print_r($ordenado);
            echo "<br>";
            $sinrepetir = array_unique($comprobador);
            print_r($sinrepetir);
            echo "<br>";
            $sinrepetir = array_keys($sinrepetir);
            print_r($sinrepetir);
            echo "<br>";

            $registros = Array();
            for ($i = 0; $i < count($sinrepetir); $i++){
                $registros[$i][0] = $menus[$sinrepetir[$i]][0];
                $registros[$i][1] = $arreglado[$ordenado[$i]];
                $registros[$i][2] = $menus[$sinrepetir[$i]][2];
                $registros[$i][2] = (($registros[$i][2])*$registros[$i][1]);
                $pedidoTotal += $registros[$i][2];
            }
        }   
        
        print_r($registros);

        //REALIZAMOS CONSULTA DE LA SUMA DEL PEDIDO
        $result = mysql_query("SELECT SUM(totalComandaTemp) as total FROM comandatemp_".$_SESSION['id_usuario']." WHERE idMenuComandaTemp IS NULL");	
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $totalrow = mysql_num_rows($result, MYSQL_ASSOC);
        //if ($totalrow > 0){
            $pedidoTotal += $row["total"];
        //}     
echo "<br>";
echo $pedidoTotal;


?>

