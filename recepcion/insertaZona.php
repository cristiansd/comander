<?php require_once('../Connections/conexionComanderEnvCam.php'); ?><?php require_once('../includes/funcionesEnvCam.php'); ?><?php// *** Validate request to login to this site.if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";$MM_restrictGoTo = "loginRecepcion.php";if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {    $MM_qsChar = "?";    $MM_referrer = $_SERVER['PHP_SELF'];    if (strpos($MM_restrictGoTo, "?")) {        $MM_qsChar = "&";    }    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) {        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];    }    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);    header("Location: " . $MM_restrictGoTo);    exit;}mysqli_select_db($comcon, $database_comcon) or die(mysqli_connect_error());$query_regZonas = "SELECT * FROM zonas";$regZonas = mysqli_query($comcon, $query_regZonas) or die(mysqli_connect_error());$row_regZonas = mysqli_fetch_assoc($regZonas);$totalRows_regZonas = mysqli_num_rows($regZonas);if (isset($_GET['listZonas'])) {    $zona = $_GET['listZonas'];    setcookie("zona", $zona, time() + 3600 * 24 * 365);    header("Location: mostrarTiempoReal.php");}?><html>    <head>        <meta charset="utf-8">        <link rel="stylesheet" href="../estilos/w3.css">        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">        <link rel="stylesheet" href="..\font-awesome-4.7.0\css\font-awesome.min.css">        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">        <script type="text/javascript" src="../envCam/jquery-mobile/jquery.js"></script>        <title>Login Recepcion</title>        <style type="text/css">            .centrar {                width: 60%;                text-align: center;                margin-top: 0px;                margin-right: auto;                margin-bottom: 40px;                margin-left: auto;            }        </style>    </head>    <body class="w3-light-grey">        <header class="w3-card-4 w3-theme header w3-padding-large" style="height: 100px;">            <div class ="w3-margin" style="float: left;"><img src="../imagenes/mano.png" class="w3-round-small" alt="Norway" style="width:40px;height: 40px;"></div>            <div class="w3-xxxlarge" style="width: 50%;float: left;">COMANDER</div>            <div class="w3-xlarge w3-right" style="margin-right: 10px;">                Usuario: <?php echo strtoupper($_SESSION['MM_Username']) ?>                <br>                Nº Local: <?php echo strtoupper($_COOKIE['establecimiento']) ?>            </div>        </header>                        <ul class="w3-navbar w3-light-grey w3-card-8">            <li style="width: 20%" class="w3-center w3-border-right"><a href="borrarest.php?borraest=1">CAMBIAR ESTABLECIMIENTO</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="mostrarTiempoReal.php">PEDIDOS</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="historicoRecepcion.php">HISTORICO</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="desconectarZona.php">DESCONECTAR</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="#">AYUDA</a></li>        </ul>            <div class="w3-container w3-theme-l2 w3-center"><h2>SELECCIONA LA ZONA DE TRABAJO</h2></div>            <div class="w3-center" style="margin-top: 40px;margin-left: 45%;text-align: center;">                <ul class="w3-navbar">                    <li class="w3-dropdown-hover">                        <a href="#">SELECCIONA ZONA <i class="fa fa-caret-down"></i></a>                        <div class="w3-dropdown-content w3-light-grey w3-card-4">                            <?php                            do {                                ?>                                <a href="insertaZona.php?listZonas=<?php echo $row_regZonas['idZona'] ?>"><?php echo strtoupper($row_regZonas['nombreZona']) ?></a>                                <?php                            } while ($row_regZonas = mysqli_fetch_assoc($regZonas));                            $rows = mysqli_num_rows($regZonas);                            if ($rows > 0) {                                mysqli_data_seek($regZonas, 0);                                $row_regZonas = mysqli_fetch_assoc($regZonas);                            }                            ?>                         </div>                    </li>                </ul>            </div>            <footer class="w3-container w3-bottom w3-padding-0">                <div style="">                    <button class="w3-indigo w3-small w3-center w3-margin-top w3-padding-small" style="width: 100%;">COMANDER RECEPCION</button>                </div>            </footer>    </body></html>