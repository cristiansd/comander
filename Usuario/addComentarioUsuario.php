<?php require_once('../includes/funcionesUsuario.php'); 

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "loginEnvCam.php";
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
$idProducto = $_POST['idProducto'];
$cantidad=$_POST['textocant'];
$operacion = $_POST['operacion'];
$comentario = $_POST['comentario'];
$textoboton = "CONTINUAR";
$idComandaTemp = $_POST['idComandaTemp'];
$idMenu ="";
$idSubmenu ="";
$esmenu = 0;
$continuarMenu = 0;
if (isset($_POST['idMenu'])){
    $idMenu = $_POST['idMenu'];
    $idSubmenu = $_POST['idSubmenu'];
    $esmenu = 1;
    if(isset($_POST['idGrupoMenuComandaTemp'])){
        $idGrupoMenuComandaTemp = $_POST['idGrupoMenuComandaTemp'];
        $continuarMenu = 1;
    }  
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Añadir comentario</title>
    <link href="jquery-mobile/jquery.mobile.theme-1.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="jquery-mobile/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="jquery-mobile/jquery.mobile.structure-1.4.5.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
    <script type="text/javascript" src="jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
        <style type="text/css">
        * #container {
                min-height: 500px;
                height: 500px;
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
                margin-top: 5px;
                margin-bottom: 30px;
                margin-right: 10px;
        }
        .izquierda {
                text-align: left;
                width: 50%;
                float: left;
                margin-top: 20px;
                margin-bottom: 40px;
        }
        .centro {;
                margin-top: 25px;
                margin-right: auto;
                margin-bottom: 0px;
                margin-left: auto;
                text-align: center;
        }

        .ui-page {
                background: transparent;
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
                text-align: center;
                margin-bottom: 15px;
        }
        #texto {
                margin-top: 5px;
                margin-bottom: 10px;
        }
        #coment {
                margin-top: 5px;
                .loader {
                        position: fixed;
                        left: 0px;
                        top: 0px;
                        width: 100%;
                        height: 100%;
                        z-index: 9999;
                        background: url('page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
                    }
        </style>
    </head>
    <meta name="viewport" content="width=device-width"/>
    <script type="text/javascript">
        $(window).load(function() {
                $(".loader").fadeOut("slow");
        })
    </script>
    <body>
    <div class="loader"></div>
        <div data-role="page" id="page">
        <div id="container">
            <?php include ("../includes/cabeceraUsuario.php"); ?>
            <div data-role="content">
                <?php include ("../includes/menuCabeceraUsuario.php"); ?>
                <div id="titulopedido"> <strong>MESA: <?php echo recuperaNombreMesa($_SESSION['mesa'])?></strong><br><br> 
                    <a href="javascript:window.history.back();" data-role="button" data-icon="back" data-iconpos="right" data-inline="true"  data-theme="b" data-ajax="false">ATRAS</a>
                    <br>
                    <br>
                </div>
                <div class="centrar">
                    <form action="crearComandaTemporalUsuario.php" method="POST" name="formEntrega">
                        <strong>COMENTARIO PARA:</strong><br>
                        <?php echo recuperaNombreProducto($idProducto); ?><br><br>
                        <textarea name="textoComent" rows="3" id="texto" data-inline="true"><?php echo $comentario; ?></textarea>
                        <div class="centro"><input name="btnenviar" type="submit" value="<?php echo $textoboton ?>" data-inline="true"></div>  
                        <input name="idProducto" id="idProducto" type="hidden" value="<?php echo $idProducto ?>">                        
                        <input name="operacion" id="textocant" type="hidden" value="<?php echo $operacion ?>">
                        <input name="idComandaTemp" id="textocant" type="hidden" value="<?php echo $idComandaTemp ?>">
                        <?php if($esmenu == 1){ ?>
                        <input name="idMenu" type="hidden" value="<?php echo $idMenu ?>">
                        <input name="idSubmenu" type="hidden" value="<?php echo $idSubmenu ?>">
                        <input name="textocant" type="hidden" value="1">
                        <?php if($continuarMenu == 1){ ?>
                        <input name="idGrupoMenuComandaTemp" type="hidden" value="<?php echo $idGrupoMenuComandaTemp ?>">
                        <?php }}else{ ?>
                        <input name="textocant" type="hidden" value="<?php echo $cantidad ?>">   
                        <?php } ?>
                    </form>
                </div>
            </div>
          </div> 
        </div>
    </body>
</html>