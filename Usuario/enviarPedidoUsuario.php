<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
        <script type="text/javascript" charset="UTF-8" src="jquery-mobile/jquery.js"></script>
    </head>
<?php
include '../includes/importacionesUsuario.php';
require_once('../includes/funcionesUsuario.php');
include '../includes/GoogleTranslate.php';

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";


include '../includes/errorIdentificacionUsuario.php';

include '../Gcm/sending_push.php';

include '../classes/pdf.php';

date_default_timezone_set("Europe/Madrid");

if (filter_input(INPUT_GET, 'amount')) {
    $amount = filter_input(INPUT_GET, 'amount');
}

//DECLARAMOS UN PDF, AÑADIMOS UNA PAGINA Y DECLARAMOS EL TIPO DE LETRA Y TAMAÑO
$pdf=new PDF();

//DECLARAMOS CONEXION A LA BD
mysql_select_db($database_usuario, $comcon_usuario);

//COMPROBAMOS SI LA TABLA TEMPORAL EXISTE
$result = "show tables like 'comandaTemp_".$_SESSION['id_usuario']."'";
$resultados=mysql_query($result, $comcon_usuario) or die(mysql_error());
$existe = mysql_num_rows($resultados);
if(!$existe){
    header('Location:principalUsuario.php');
}

//REVISAMOS LA TABLA MESAS POR SI HAY ASIGNADO YA UN CAMARERO A ESA MESA
$mesas = "SELECT idUsuarioMesa FROM mesas WHERE idMesa= ".$_SESSION['mesa']."";
$queryMesas = mysql_query($mesas, $comcon_usuario) or die(mysql_error());
$row_mesas = mysql_fetch_assoc($queryMesas);

//ASIGNAMOS EL CAMARERO A UNA VARIABLE DE USUARIO SI ES QUE LA MESA YA TIENE ASIGNADO CAMARERO
//y CONDICIONAMOS EN BASE A SI TIENE ASIGANDO EL CAMARERO

if($row_mesas['idUsuarioMesa'] !=null){
    $_SESSION['idCamarero'] = $row_mesas['idUsuarioMesa'];


//CREAMOS UN PEDIDO NUEVO YA PAGADO POR QUE SI NO, NO PUEDE LLEGAR HASTA AQUI

mysql_select_db($database_usuario, $comcon_usuario);

$insertPedido = sprintf("INSERT INTO pedidos (idMesaPedido, estadoMesaPedido,"
        . "idUsuarioPedido, idVisitantePedido,estadoCobroPedido,ImportePedido,"
        . "horaCobroPedido,fechaPedido,horaPedido,fechaHoraPedidio) "
        . "VALUES (%s, %s,%s, %s,%s,%s,%s,%s,%s,%s)", 
        GetSQLValueString($_SESSION['mesa'], "int"),
        GetSQLValueString(1, "int"), 
        GetSQLValueString($_SESSION['idCamarero'], "int"), 
        GetSQLValueString($_SESSION['id_usuario'], "int"), 
        GetSQLValueString(1, "int"), 
        GetSQLValueString($amount, "double"), 
        GetSQLValueString(date('H:i:s'), "date"),
        GetSQLValueString(date('Y-m-d'), "date"), 
        GetSQLValueString(date('H:i:s'), "date"), 
        GetSQLValueString(date('Y-m-d H:i:s'), "date"));

$RegInsertPedido = mysql_query($insertPedido, $comcon_usuario) or die(mysql_error());


//RECUPERAMOS EL ID DEL PEDIDO

mysql_select_db($database_usuario, $comcon_usuario);

$idPedido = "SELECT idPedido FROM pedidos WHERE idMesaPedido= " . $_SESSION['mesa'] . " AND idVisitantePedido= " . $_SESSION['id_usuario'] . " ORDER BY idPedido DESC";
$RegIdPedio = mysql_query($idPedido, $comcon_usuario) or die(mysql_error());
$row_idPedido = mysql_fetch_assoc($RegIdPedio);


//ASIGNAMOS EL ID DE PEDIDO A UNA VARIABLE DE USUARIO 

$_SESSION['idPedido'] = $row_idPedido['idPedido'];

//SELECCIONAMOS LAS COMANDAS TEMPORALES DEL USUARIO

mysql_select_db($database_usuario, $comcon_usuario);

$comandaTemporal_Query = "SELECT * FROM comandatemp_" . $_SESSION['id_usuario'] . "";
$RegComandasTemp = mysql_query($comandaTemporal_Query, $comcon_usuario) or die(mysql_error());
$row_ComandaTemp = mysql_fetch_assoc($RegComandasTemp);

do {

//COMPARAMOS LA VARIABLES QUE PUEDEN TENER DISTINTO VALOR  


    $estadoComentarioComanda = 0;
    $totalComanda = 0;

    if ($row_ComandaTemp['comentarioComandaTemp'] != NULL) {
        $estadoComentarioComanda = 1;
    }
    if ($row_ComandaTemp['totalComandaTemp'] != NULL) {
        $totalComanda = $row_ComandaTemp['totalComandaTemp'];
    }

//RECUPERAMOS LA DIRECCION DE ENVIO DE LA COMANDA

    mysql_select_db($database_usuario, $comcon_usuario);

    $query_EnvioComanda = "SELECT envioProducto FROM productos WHERE idProducto=" . $row_ComandaTemp['idProductoComandaTemp'] . "";
    $RegEnvioComanda = mysql_query($query_EnvioComanda, $comcon_usuario) or die(mysql_error());
    $row_RegEnvioComanda = mysql_fetch_assoc($RegEnvioComanda);

//TRADUCIMOS A LOS DIFERENTES IDIOMAS     
    $traslator = new GoogleTranslate();
    
    for ($i=0;$i<10;$i++){
        switch ($i){
            case 0:
                $source = $_SESSION['idioma'];
                $target = 'en';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $inglesCategoria = $resultado;
                break;
            case 1:
                $source = $_SESSION['idioma'];
                $target = 'ca';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $catalanCategoria = $resultado;
                break;
            case 2:
                $source = $_SESSION['idioma'];
                $target = 'fr';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $francesCategoria = $resultado;
                break;      
            case 3:
                $source = $_SESSION['idioma'];
                $target = 'de';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $alemanCategoria = $resultado;
                break;
            case 4:
                $source = $_SESSION['idioma'];
                $target = 'it';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);    
                $resultado = str_replace('"', '', $resultado);
                $italianoCategoria = $resultado;
                break;   
            case 5:
                $source = $_SESSION['idioma'];
                $target = 'ru';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $rusoCategoria = $resultado;
                break;
            case 6:
                $source = $_SESSION['idioma'];
                $target = 'zh-CN';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);    
                $resultado = str_replace('"', '', $resultado);
                $chinoCategoria = $resultado;
                break;   
            case 7:
                $source = $_SESSION['idioma'];
                $target = 'ja';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);
                $resultado = str_replace('"', '', $resultado);
                $japonesCategoria = $resultado;
                break;   
            case 8:
                $source = $_SESSION['idioma'];
                $target = 'ar';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $arabeCategoria = $resultado;
                break;  
            case 9:
                $source = $_SESSION['idioma'];
                $target = 'es';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $spanishCategoria = $resultado;
                break;  
        }
    } 
    
//DECLARAMOS LA CONEXION A LA BASE DE DATOS
    mysql_select_db($database_usuario, $comcon_usuario);
    
//INSERTAMOS EN LA TABLA STRINGS EL NOMBRE DE LA CATEGORIA EN DIFERENTE INDIOMAS
    $insertIdiomas = sprintf("INSERT INTO strings (spanish, ingles, catalan, frances, aleman, italiano, ruso, chino, japones, arabe) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", 
            GetSQLValueString($spanishCategoria, "text"), 
            GetSQLValueString($inglesCategoria, "text"), 
            GetSQLValueString($catalanCategoria, "text"), 
            GetSQLValueString($francesCategoria, "text"),
            GetSQLValueString($alemanCategoria, "text"), 
            GetSQLValueString($italianoCategoria, "text"),
            GetSQLValueString($rusoCategoria, "text"), 
            GetSQLValueString($chinoCategoria, "text"),
            GetSQLValueString($japonesCategoria, "text"),
            GetSQLValueString($arabeCategoria, "text"));    
    $ResultdoIdioma = mysql_query($insertIdiomas, $comcon_usuario) or die(mysql_error());
    
    //RECUPERAMOS EL ID DE STRING
    $consultaString = "SELECT * FROM strings ORDER BY id DESC";
    $query_String = mysql_query($consultaString, $comcon_usuario);
    $row_string = mysql_fetch_array($query_String);
    $id_string = $row_string['0'];

//INSERTAMOS TODO LO RECUPERADO EN COMANDAS
    $insertComandas = sprintf("INSERT INTO comandas (idMesaComanda, idPedidoComanda,idUsuarioComanda,idVisitanteComanda, idProductoComanda, "
            . "cantidadPedidaComanda, totalComanda, estadoComentarioComanda, comentarioComanda, id_string_comentario, horaComandaPedida, horaComandaEnviada,"
            . "estadoPedirComanda, envioComanda, idMenuProductosComanda, idSubmenuProductosComanda, idGrupoMenuComanda) "
            . "VALUES (%s, %s, %s,%s,%s,%s,%s,%s, %s,%s, %s,%s,%s,%s,%s,%s,%s)", 
            GetSQLValueString($_SESSION['mesa'], "int"), 
            GetSQLValueString($_SESSION['idPedido'], "int"),
            GetSQLValueString($_SESSION['idCamarero'], "int"), 
            GetSQLValueString($_SESSION['id_usuario'], "int"), 
            GetSQLValueString($row_ComandaTemp['idProductoComandaTemp'], "int"), 
            GetSQLValueString($row_ComandaTemp['cantidadComandaTemp'], "int"), 
            GetSQLValueString($totalComanda, "double"), 
            GetSQLValueString($estadoComentarioComanda, "int"), 
            GetSQLValueString($row_ComandaTemp['comentarioComandaTemp'], "text"), 
            GetSQLValueString($id_string, "int"),
            GetSQLValueString(date('H:i:s'), "date"), 
            GetSQLValueString(date('H:i:s'), "date"), 
            GetSQLValueString(1, "int"), 
            GetSQLValueString($row_RegEnvioComanda['envioProducto'], "int"), 
            GetSQLValueString($row_ComandaTemp['idMenuComandaTemp'], "int"), 
            GetSQLValueString($row_ComandaTemp['idSubmenuComandaTemp'], "int"), 
            GetSQLValueString($row_ComandaTemp['idGrupoMenuComandaTemp'], "double"));

    mysql_query($insertComandas, $comcon_usuario) or die(mysql_error());
} while ($row_ComandaTemp = mysql_fetch_assoc($RegComandasTemp));
?>
<script language="javascript">
sendPushCamarero(3, <?php echo $_SESSION['idCamarero']; ?>, <?php echo $_SESSION['idPedido']; ?>, <?php echo $_SESSION['id_usuario']; ?>, <?php echo $_SESSION['mesa']; ?> );
</script>
<?php
}else{


//CAMBIAMOS EL ESTADO DE LA MESA A RESERVADA
    
mysql_select_db($database_usuario, $comcon_usuario);

$update = "UPDATE mesas SET peticionMesa = 1 WHERE idMesa=".$_SESSION['mesa']."";
mysql_query($update, $comcon_usuario) or die(mysql_error());

//CREAMOS UN PEDIDO NUEVO YA PAGADO POR QUE SI NO, NO PUEDE LLEGAR HASTA AQUI

mysql_select_db($database_usuario, $comcon_usuario);

$insertPedido = sprintf("INSERT INTO pedidos (idMesaPedido, estadoMesaPedido,"
        . "idVisitantePedido,estadoCobroPedido,ImportePedido,"
        . "horaCobroPedido,fechaPedido,horaPedido,fechaHoraPedidio) "
        . "VALUES (%s, %s, %s,%s,%s,%s,%s,%s,%s)", 
        GetSQLValueString($_SESSION['mesa'], "int"), 
        GetSQLValueString(1, "int"), 
        GetSQLValueString($_SESSION['id_usuario'], "int"),
        GetSQLValueString(1, "int"), 
        GetSQLValueString($amount, "double"),
        GetSQLValueString(date('H:i:s'), "date"),
        GetSQLValueString(date('Y-m-d'), "date"), 
        GetSQLValueString(date('H:i:s'), "date"),
        GetSQLValueString(date('Y-m-d H:i:s'), "date"));

$RegInsertPedido = mysql_query($insertPedido, $comcon_usuario) or die(mysql_error());


//RECUPERAMOS EL ID DEL PEDIDO

mysql_select_db($database_usuario, $comcon_usuario);

$idPedido = "SELECT idPedido FROM pedidos WHERE idMesaPedido= " . $_SESSION['mesa'] . " AND idVisitantePedido= " . $_SESSION['id_usuario'] . " ORDER BY idPedido DESC";
$RegIdPedio = mysql_query($idPedido, $comcon_usuario) or die(mysql_error());
$row_idPedido = mysql_fetch_assoc($RegIdPedio);


//ASIGNAMOS EL ID DE PEDIDO A UNA VARIABLE DE USUARIO

$_SESSION['idPedido'] = $row_idPedido['idPedido'];

//SELECCIONAMOS LAS COMANDAS TEMPORALES DEL USUARIO

mysql_select_db($database_usuario, $comcon_usuario);

$comandaTemporal_Query = "SELECT * FROM comandatemp_" . $_SESSION['id_usuario'] . "";
$RegComandasTemp = mysql_query($comandaTemporal_Query, $comcon_usuario) or die(mysql_error());
$row_ComandaTemp = mysql_fetch_assoc($RegComandasTemp);

do {

//COMPARAMOS LA VARIABLES QUE PUEDEN TENER DISTINTO VALOR  


    $estadoComentarioComanda = 0;
    $totalComanda = 0;

    if ($row_ComandaTemp['comentarioComandaTemp'] != NULL) {
        $estadoComentarioComanda = 1;
    }
    if ($row_ComandaTemp['totalComandaTemp'] != NULL) {
        $totalComanda = $row_ComandaTemp['totalComandaTemp'];
    }

//RECUPERAMOS LA DIRECCION DE ENVIO DE LA COMANDA

    mysql_select_db($database_usuario, $comcon_usuario);

    $query_EnvioComanda = "SELECT envioProducto FROM productos WHERE idProducto=" . $row_ComandaTemp['idProductoComandaTemp'] . "";
    $RegEnvioComanda = mysql_query($query_EnvioComanda, $comcon_usuario) or die(mysql_error());
    $row_RegEnvioComanda = mysql_fetch_assoc($RegEnvioComanda);

//TRADUCIMOS A LOS DIFERENTES IDIOMAS     
    $traslator = new GoogleTranslate();
    
    for ($i=0;$i<10;$i++){
        switch ($i){
            case 0:
                $source = $_SESSION['idioma'];
                $target = 'en';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $inglesCategoria = $resultado;
                break;
            case 1:
                $source = $_SESSION['idioma'];
                $target = 'ca';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $catalanCategoria = $resultado;
                break;
            case 2:
                $source = $_SESSION['idioma'];
                $target = 'fr';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $francesCategoria = $resultado;
                break;      
            case 3:
                $source = $_SESSION['idioma'];
                $target = 'de';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $alemanCategoria = $resultado;
                break;
            case 4:
                $source = $_SESSION['idioma'];
                $target = 'it';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);    
                $resultado = str_replace('"', '', $resultado);
                $italianoCategoria = $resultado;
                break;   
            case 5:
                $source = $_SESSION['idioma'];
                $target = 'ru';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $rusoCategoria = $resultado;
                break;
            case 6:
                $source = $_SESSION['idioma'];
                $target = 'zh-CN';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);    
                $resultado = str_replace('"', '', $resultado);
                $chinoCategoria = $resultado;
                break;   
            case 7:
                $source = $_SESSION['idioma'];
                $target = 'ja';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);
                $resultado = str_replace('"', '', $resultado);
                $japonesCategoria = $resultado;
                break;   
            case 8:
                $source = $_SESSION['idioma'];
                $target = 'ar';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $arabeCategoria = $resultado;
                break;  
            case 9:
                $source = $_SESSION['idioma'];
                $target = 'es';
                $text = $row_ComandaTemp['comentarioComandaTemp'];
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);   
                $resultado = str_replace('"', '', $resultado);
                $spanishCategoria = $resultado;
                break;  
        }
    } 
    
//DECLARAMOS LA CONEXION A LA BASE DE DATOS
    mysql_select_db($database_usuario, $comcon_usuario);
    
//INSERTAMOS EN LA TABLA STRINGS EL NOMBRE DE LA CATEGORIA EN DIFERENTE INDIOMAS
    $insertIdiomas = sprintf("INSERT INTO strings (spanish, ingles, catalan, frances, aleman, italiano, ruso, chino, japones, arabe) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", 
            GetSQLValueString($spanishCategoria, "text"), 
            GetSQLValueString($inglesCategoria, "text"), 
            GetSQLValueString($catalanCategoria, "text"), 
            GetSQLValueString($francesCategoria, "text"),
            GetSQLValueString($alemanCategoria, "text"), 
            GetSQLValueString($italianoCategoria, "text"),
            GetSQLValueString($rusoCategoria, "text"), 
            GetSQLValueString($chinoCategoria, "text"),
            GetSQLValueString($japonesCategoria, "text"),
            GetSQLValueString($arabeCategoria, "text"));    
    $ResultdoIdioma = mysql_query($insertIdiomas, $comcon_usuario) or die(mysql_error());
    
    //RECUPERAMOS EL ID DE STRING
    $consultaString = "SELECT * FROM strings ORDER BY id DESC";
    $query_String = mysql_query($consultaString, $comcon_usuario);
    $row_string = mysql_fetch_array($query_String);
    $id_string = $row_string['0'];
    
    
//INSERTAMOS TODO LO RECUPERADO EN COMANDAS

    mysql_select_db($database_usuario, $comcon_usuario);

    $insertComandas = sprintf("INSERT INTO comandas (idMesaComanda, idPedidoComanda,idVisitanteComanda, idProductoComanda, "
            . "cantidadPedidaComanda, totalComanda, estadoComentarioComanda, comentarioComanda, id_string_comentario, horaComandaPedida, horaComandaEnviada,"
            . "estadoPedirComanda, envioComanda, idMenuProductosComanda, idSubmenuProductosComanda, idGrupoMenuComanda) "
            . "VALUES (%s, %s, %s,%s,%s,%s,%s,%s, %s, %s,%s,%s,%s,%s,%s,%s)", 
            GetSQLValueString($_SESSION['mesa'], "int"), 
            GetSQLValueString($_SESSION['idPedido'], "int"),
            GetSQLValueString($_SESSION['id_usuario'], "int"), 
            GetSQLValueString($row_ComandaTemp['idProductoComandaTemp'], "int"), 
            GetSQLValueString($row_ComandaTemp['cantidadComandaTemp'], "int"), 
            GetSQLValueString($totalComanda, "double"),
            GetSQLValueString($estadoComentarioComanda, "int"), 
            GetSQLValueString($row_ComandaTemp['comentarioComandaTemp'], "text"),
            GetSQLValueString($id_string, "int"), 
            GetSQLValueString(date('H:m:s'), "date"),
            GetSQLValueString(date('H:m:s'), "date"), 
            GetSQLValueString(1, "int"),
            GetSQLValueString($row_RegEnvioComanda['envioProducto'], "int"), 
            GetSQLValueString($row_ComandaTemp['idMenuComandaTemp'], "int"),
            GetSQLValueString($row_ComandaTemp['idSubmenuComandaTemp'], "int"),
            GetSQLValueString($row_ComandaTemp['idGrupoMenuComandaTemp'], "double"));
    
    mysql_query($insertComandas, $comcon_usuario) or die(mysql_error());  
    
} while ($row_ComandaTemp = mysql_fetch_assoc($RegComandasTemp));
?>
<script language="javascript">
    sendPush(3,<?php echo $_SESSION['id_usuario']; ?>, <?php echo $_SESSION['idPedido']; ?>);  
</script>

<?php
}
//CREAMOS EL TIQUET Y LO AÑADIMOS A LA CARPETA
$pdf->pedido = $_SESSION['idPedido']."_".$_SESSION['establecimiento'];
$pdf->consulta();

//TERMINADA LA CARGA DE COMANDAS BORRAMOS LA TABLA TEMPORAL DE COMANDAS
    
$query_DropTable = "DROP TABLE comandaTemp_" . $_SESSION['id_usuario'] . "";
mysql_query($query_DropTable, $comcon_usuario) or die(mysql_error());

//CERRAMOS LA CONEXION

mysql_close($comcon_usuario);

//TERMINADA LA CREACION DEL PDF CARGAMOS TODO A LA PATBLA PEDIDOS
//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysql_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysql_select_db($database_comcon, $comcon);
$insertTiquets = sprintf("INSERT INTO pedidos (id_usuario, tiquet, id_pedido, id_local) "
            . "VALUES (%s, %s, %s, %s)", 
            GetSQLValueString($_SESSION['id_usuario'], "int"),
            GetSQLValueString("pedido_".$_SESSION['idPedido'], "text"),
            GetSQLValueString($_SESSION['idPedido'], "int"),
            GetSQLValueString($_SESSION['establecimiento'], "int"));
mysql_query($insertTiquets, $comcon) or die(mysql_error());

mysql_close($comcon);
?>
        
    <?php include '../includes/importacionesUsuario.php'; ?>  
    <body class="w3-light-grey">
        <?php cabeceraNavegacionUsuario($autoayment, 0, 0); ?>
        <div id="sesionCaducada" class="w3-modal w3-top" style="display: block;">
            <div class= "w3-container  w3-center w3-light-grey">
                <br> 
                <img src="../imagenes/UsuarioImages/ok.png" width="128" height="128"><br>
                <br>
                <div class="w3-large w3-margin-top">
                    <?php echo $paymentSucces; ?>
                    <br><br>
                    <?php echo $succesSentOrder; ?>
                    <br><br>
                    <?php echo $lookYourOrders; ?>
                </div><br> 
                <a class="w3-btn w3-white w3-border w3-round w3-card-4 w3-margin-bottom" style="width: 100%;" onclick="conection('principalUsuario.php')"><?php echo $okButton; ?></a>
            </div> 
        </div>  
    </body>
</html>