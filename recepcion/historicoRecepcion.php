<?phprequire_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";$MM_restrictGoTo = "loginRecepcion.php";if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {    $MM_qsChar = "?";    $MM_referrer = $_SERVER['PHP_SELF'];    if (strpos($MM_restrictGoTo, "?")) {        $MM_qsChar = "&";    }    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) {        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];    }    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);    header("Location: " . $MM_restrictGoTo);    exit;}if (isset($_COOKIE['zona'])) {    $zona = $_COOKIE['zona'];    $hayzona = true;} else {    header("Location: insertaZona.php");}$error = 0;$ahora = date('d/m/Y', time());if (isset($_GET['fechaInicio']) && $_GET['fechaInicio'] != ""){    $fechaInicio = $_GET['fechaInicio'];    $fechaFinal = $_GET['fechaFinal'];    $fecha1 = str_replace("/","-",$_GET['fechaInicio']);    $fecha2 = str_replace("/","-",$_GET['fechaFinal']);    $fechaConv1 = date("Y-m-d",strtotime($fecha1));    $fechaConv2 = date("Y-m-d",strtotime($fecha2));    $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));    $fechadestino = strtotime($fecha1);    $query_recogeIdPedido = "SELECT * FROM comandas WHERE estadoPedirComanda=1 AND estadoPreparadoComanda=1 AND envioComanda=" . $zona . " AND fechaComanda BETWEEN '" . $fechaConv1 . " 00:00:00' AND '" . $fechaConv2 . " 23:59:59' ORDER BY fechaComanda ASC";    $existen = "1";}else{    $existen = "0";    $query_recogeIdPedido = "SELECT * FROM comandas WHERE estadoPedirComanda=1 AND estadoPreparadoComanda=1 AND envioComanda=" . $zona . " ORDER BY horaComandaEnviada ASC";}mysqli_select_db($comcon, $database_comcon) or die(mysqli_connect_error());$recogeIdPedido = mysqli_query($comcon, $query_recogeIdPedido) or die(mysqli_connect_error());$row_recogeIdPedido = mysqli_fetch_assoc($recogeIdPedido);$totalRows_recogeIdPedido = mysqli_num_rows($recogeIdPedido);if ($fechaFinal < $fechaInicio){   $totalRows_recogeIdPedido = 0;   $error = 1;}?><html>    <head>        <meta charset="utf-8">        <link rel="stylesheet" href="../estilos/w3.css">        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">        <link rel="stylesheet" href="..\font-awesome-4.7.0\css\font-awesome.min.css">        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">        <script type="text/javascript" src="../envCam/jquery-mobile/jquery.js"></script>        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>                <title>Mostrar tiempo real</title>        <style type="text/css">                        ::-webkit-input-placeholder { /* WebKit, Blink, Edge */                color:    #000;            }            :-moz-placeholder { /* Mozilla Firefox 4 to 18 */               color:    #000;               opacity:  1;            }            ::-moz-placeholder { /* Mozilla Firefox 19+ */               color:    #000;               opacity:  1;            }            :-ms-input-placeholder { /* Internet Explorer 10-11 */               color:    #000;            }                    </style>                <script>            $(window).load(function () {                var existen = <?php echo $existen; ?>;                var cantidad = <?php echo $totalRows_recogeIdPedido ?>;                var error = <?php echo $error; ?>;                if (error == 1){                    document.getElementById('id01').style.display='block';                }                if (existen != "0"){                    $('#datepicker').val('<?php echo $fechaInicio ?>');                    $('#datepicker2').val('<?php echo $fechaFinal ?>');                    if (cantidad == 0){                        $('#divauxiliar').html(' PARA ESA FECHA');                    }                }            });                        $(function($){                $.datepicker.regional['es'] = {                    closeText: 'Cerrar',                    prevText: '<Ant',                    nextText: 'Sig>',                    currentText: 'Hoy',                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],                    weekHeader: 'Sm',                    dateFormat: 'dd/mm/yy',                    firstDay: 1,                    isRTL: false,                    showMonthAfterYear: false,                    yearSuffix: ''                };                $.datepicker.setDefaults($.datepicker.regional['es']);            });                        $( function() {                $( "#datepicker" ).datepicker();                $( "#datepicker2" ).datepicker();            } );                        function recargaFecha(){                if ($('#datepicker').val() != ""){                    var fecha1 = $('#datepicker').val();                    var fecha2 = $('#datepicker2').val();                    location.href = 'historicoRecepcion.php?fechaInicio=' + fecha1 + '&fechaFinal=' + fecha2;                }            }                    </script>        </head>        <body class="w3-light-grey">        <header class="w3-card-4 w3-theme header w3-padding-large" style="height: 100px;">            <div class ="w3-margin" style="float: left;"><img src="../imagenes/mano.png" class="w3-round-small" alt="Norway" style="width:40px;height: 40px;"></div>            <div class="w3-xxxlarge" style="width: 50%;float: left;">COMANDER</div>            <div class="w3-xlarge w3-right" style="margin-right: 10px;">                Usuario: <?php echo strtoupper($_SESSION['MM_Username']) ?>                <br>                Nº Local: <?php echo strtoupper($_COOKIE['establecimiento']) ?>            </div>        </header>                <ul class="w3-navbar w3-light-grey w3-card-8">            <li style="width: 20%" class="w3-center w3-border-right"><a href="borrarest.php?borraest=1">CAMBIAR ESTABLECIMIENTO</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="insertaZona.php">CAMBIAR ZONA DE TRABAJO</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="mostrarTiempoReal.php">PEDIDOS</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="desconectarZona.php">DESCONECTAR</a></li>            <li style="width: 20%" class="w3-center w3-border-right"><a href="#">AYUDA</a></li>        </ul>        <div class="w3-container w3-center w3-margin-top">            <h2 align="center">HISTORICO DE PREPARADOS EN <?php echo strtoupper(recuperaNombreZona($zona)) ?></h2>        </div>        <div class="w3-center">            <input style="width: 10%;display: inline;" placeholder="FECHA INICIO" id="datepicker" class="w3-input w3-border w3-round-large w3-margin-right" type="text">            <input style="width: 10%;display: inline;" placeholder="FECHA FINAL" id="datepicker2" class="w3-input w3-border w3-round-large w3-margin-right" type="text">            <button class="w3-btn w3-theme" style="margin-bottom: 4px;" onclick="recargaFecha();">FILTRA</button>        </div>               <div id="pant">            <div class="w3-padding-medium" style="margin-top: 10px;">                <?php if ($totalRows_recogeIdPedido > 0){?>                <table class="w3-table w3-striped w3-bordered w3-border">                    <thead>                        <tr class="w3-theme-l2">                            <th width="2%" align="center">CANTIDAD</th>                            <th width="30%" align="center">&nbsp;PRODUCTO</th>                            <th width="2%" align="center">MESA</th>                            <th width="30%" align="center">&nbsp;COMENTARIO</th>                            <th width="6%" align="center">TIPO</th>                            <th width="15%" align="center">&nbsp;CAMARERO&nbsp;</th>                            <th width="15%" align="center">&nbsp;FECHA&nbsp;</th>                            <th width="10%" align="center">&nbsp;HORA&nbsp;</th>                        </tr>                    </thead>                <?php                 do {?>                     <tr class="w3-hover-theme" onclick="">                    <td align="center"><?php echo $row_recogeIdPedido['cantidadPedidaComanda'] ?>&nbsp;</td>                    <td align="center">&nbsp;<?php echo recuperaNombreProducto($row_recogeIdPedido['idProductoComanda']) ?></td>                    <td align="center"><?php echo recuperaNombreMesa($row_recogeIdPedido['idMesaComanda']) ?></td>                    <td align="center">&nbsp;<?php echo $row_recogeIdPedido['comentarioComanda'] ?></td>                    <td align="center"><?php if ($row_recogeIdPedido['idMenuProductosComanda'] != NULL){ echo "MENU"; }else{ echo "CARTA";} ?></td>                    <td align="center"><?php if ($row_recogeIdPedido['idUsuarioComanda'] != NULL){echo strtoupper(recuperaNickUsuario($row_recogeIdPedido['idUsuarioComanda']));} ?>&nbsp;</td>                    <td align="center"><?php echo date('d/m/Y', strtotime($row_recogeIdPedido['fechaComanda'])); ?>&nbsp;</td>                    <td align="center"><?php echo $row_recogeIdPedido['horaComandaEnviada']; ?>&nbsp;</td>                  </tr>                <?php } while ($row_recogeIdPedido = mysqli_fetch_assoc($recogeIdPedido));?>                </table>                <?php }else{?>                <h4 class="w3-dark-grey w3-card-8" align="center">NO EXISTE HISTORICO DE PEDIDOS<div id="divauxiliar"></div></h4>                <?php }?>            </div>        </div>        <footer class="w3-container w3-bottom w3-padding-0">            <div style="">                <button class="w3-indigo w3-small w3-center w3-margin-top w3-padding-small" style="width: 100%;">COMANDER RECEPCION</button>            </div>        </footer>                <div id="id01" class="w3-modal">            <div class="w3-modal-content">                <header class="w3-container w3-theme-l2">                   <span onclick="document.getElementById('id01').style.display = 'none';"                   class="w3-closebtn">&times;</span>                  <h3>ERROR</h3>                </header>                <div class="w3-container">                  <p>La fecha a filtrar no debe ser superior a la fecha actual</p>                </div>                <button class="w3-btn w3-large w3-theme" style="width: 100%;" onclick="document.getElementById('id01').style.display = 'none';">ACEPTAR</button>              </div>        </div>            </body></html>