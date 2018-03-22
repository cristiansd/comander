<?php require_once('../includes/funcionesUsuario.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
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
?>
<!DOCTYPE html>
<html>
<head>
<link href="jquery-mobile/jquery.mobile.theme-1.4.5.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile.structure-1.4.5.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="jquery-mobile/jquery.js"></script>
<script type="text/javascript" src="jquery-mobile/jquery.mobile-1.4.5.min.js"></script>


<style type="text/css">
* #container {
	min-height: 600px;
	height: 600px;
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
	text-align: center;
}

.ui-page {
	background: transparent;
}
.ui-content {
	background: transparent;
	padding-right: 1px;
	padding-left: 1px;
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
}


#divexample1 {
	overflow: auto;
	height: 400px;
	padding-top: 10px;
	padding-right: 15px;
	padding-left: 15px;
}
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
<body>
    <div class="loader"></div>
    <div data-role="page" id="page">
        <div id="container">
            <div data-role="header" data-position="inline">
                <h5>VALIDAR USUARIO</h5>
            </div>
            <div data-role="content">
                <div class="centrar"><img src="../imagenes/adminImages/tituloCabecera.png" width="301" height="53" alt="Titulo"></div>
                <div class="textoalerta">
                    <br>
                    <img src="../imagenes/EnvCamImages/alerta.jpg" width="128" height="128">
                    <br>
                    <br>
                        <h3 align="center">SE HA PRODUCIDO UN ERROR EN ELPROCESO DE LOGIN.
                            <br>
                            POR FAVOR, INTENTELO DE NUEVO 
                        </h3>
                        <br>
                        <input name="Botón" type="button" data-theme="e" value="REINTENTAR" onClick="location.href='loginEnvCam.php'">
                </div>
            </div>
            <div data-role="footer"></div>
        </div>
    </div>
</body>
</html>