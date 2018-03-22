<?php
require_once('../includes/funcionesAdmin.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";


$MM_restrictGoTo = "accesoUsuarioAdmin.php";
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
$MesasRows=ConsultaNoRowsBD("mesas", "", "");
$Mesas=ConsultaNoBD("mesas", "", "");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Mapa</title>
        <link href="../estilos/admin.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
</head>
    <body>
        <div class="container">
            <div class="subheader">
                <div class="header">  
                    <div class="headerInteriorLogo"><img src="../imagenes/adminImages/logotrans.png" width="130" height="110" alt="logo" /></div>  
                    <div class="headerInteriorTitulo"><img src="../imagenes/adminImages/tituloCabecera.png" width="704" height="107" alt="titulo" /></div>
                </div>
            </div>
            <div class="subcontenedor">
                <div class="sidebar1">
                    <div class="admin">Administración</div>
                    <?php include("../includes/BotoneraAdmin.php"); ?>
                </div>  
                <div class="content">   
                    <h1><p>Mapa</p></h1>
                    <div class="contenido">
                        <br /> 
                        <?php
                        $nombre_fichero = '../archivos/ImagenesAdd/mapa.jpg';
                        if (file_exists($nombre_fichero)) {?>
                        <img src="../archivos/ImagenesAdd/mapa.jpg" width="242" height="208" alt="mapa" />
                        <?php } else {
                        echo "No existe todavia ningún mapa creado pulsa \"subir mapa\"";
                        }
                        ?>
                    </div>
                </div>
                <div class="footer"></div>
            </div> 
        </div>
    </body>
</html>