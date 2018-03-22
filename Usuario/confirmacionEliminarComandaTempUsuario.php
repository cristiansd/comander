<?php require_once('../includes/funcionesUsuario.php'); 

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "errorIdentificacionEnvCam.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$esmenu = 0;
$mensaje = "ESTA A PUNTO DE BORRAR UNA LINEA DE COMANDA. ¿ESTA SEGURO?";
//$idPedido = $_GET['idPedido'];
//$idMesa = $_GET['idMesa'];
$idProducto = $_GET['idProducto'];
$idComandaTemp = $_GET['idComandaTemp'];
$idGrupoMenuComandaTemp = $_GET['idGrupoMenuComandaTemp'];
$textoBoton = "ELIMINAR COMANDA";

if (isset($_GET['esmenu'])){    
    $esmenu = 1;
    $idMenu = $_GET['idMenu'];
}
if (isset($_GET['idGrupoMenuComandaTemp'])) {
    $idGrupoMenuComandaTemp = $_GET['idGrupoMenuComandaTemp'];
    $mensaje = "ESTA A PUNTO DE BORRAR UN MENU COMPLETO, SI POR EL CONTRARIO DESEA CAMBIAR EL PRODUCTO, SELECIONE ATRAS Y PULSE EN EL PRODUCTO";
    $textoBoton = "ELIMINAR MENU";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Lista del pedido</title>
<!--<link href="jquery-mobile/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>-->
<link href="jquery-mobile/jquery.mobile.theme-1.4.5.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile.structure-1.4.5.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="jquery-mobile/jquery.js"></script>
<script type="text/javascript" src="jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
<style type="text/css">
    * #container {
        margin-bottom: 50px;
    }
    .centrar {
        text-align: center;
        margin-right: 10px;
        margin-left: 10px;
        padding-top: 10px;
    }
    .derecha {
        text-align: right;
        margin-right: 5px;
        float: right;
    }
    .izquierda {
        text-align: left;
        width: 50%;
        float: left;
        margin-top: 20px;
        margin-bottom: 40px;
    }
    .centro {;
             text-align: center;
    }
    body {
    }
    .ui-page {
        background: transparent;
        background-color:#E2E1E1;
    }
    .ui-content {
        background: transparent;
    }
    .bienvenido {
        margin-bottom: 10px;
        color: #CF3;
    }
    #page #container div .centrar .bienvenido em strong {
        color: #FFFFFF;
    }
    .botonsalir {
        width: 50%;
        margin-top: 0px;
        margin-right: auto;
        margin-bottom: 0px;
        margin-left: auto;
    }
    .margensup {
        margin-top: 60px;
    }
    #titulopedido {
        margin-right: auto;
        margin-bottom: 15px;
        margin-left: auto;
        text-align: center;
    }
    table tr th {
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: #333333;
        font-size: medium;
        color: #000;
    }
    table tr td {
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: #333333;
        font-size: medium;
    }

    .custom-btn {
        width: 130px !important;
        font-size: 0.9em;
    }
    .imgbg {
        background-color:#ef975d;
    }
</style>        
    </head>
    <meta name="viewport" content="width=device-width"/>
    <body>
        <div data-role="page" id="page"> 
            <div data-role="header" data-position="fixed" data-theme="b" class="imgbg">
                <img src="../imagenes/adminImages/Primary_logo.png" width="150" height="60" alt="Titulo" style="margin-left: 130px;">
            </div>
            <div data-role="content">
                <div id="titulopedido">
                    <strong>MESA: <?php echo recuperaNombreMesa($_SESSION['mesa']) ?></strong>
                    <br><br>
                    <h3 align="center"><?php echo $mensaje ?></h3>
                    <br><br>
                    <?php if ($esmenu == 0){ ?>
                    <a href="eliminarComandaTempUsuario.php?idProducto=<?php echo $idProducto ?>&idComandaTemp=<?php echo $idComandaTemp; ?>&idGrupoMenuComandaTemp=<?php echo $idGrupoMenuComandaTemp; ?>" data-role="button" data-theme="e" data-ajax="false" ><?php echo $textoBoton; ?></a>
                    <?php } else { ?>
                    <a href="eliminarComandaTempUsuario.php?idProducto=<?php echo $idProducto ?>&idComandaTemp=<?php echo $idComandaTemp; ?>&idGrupoMenuComandaTemp=<?php echo $idGrupoMenuComandaTemp; ?>&esmenu=<?php echo $esmenu; ?>&idMenu=<?php echo $idMenu; ?>" data-role="button" data-theme="e" data-ajax="false" ><?php echo $textoBoton; ?></a>
                    <?php } ?>
                    <br />
                    <br />
                    <a href="javascript:window.history.back();" data-role="button" data-corners="false" data-theme="e" data-ajax="false">ATRAS</a>
                </div>
            </div>
        </div>
    </body>
</html>