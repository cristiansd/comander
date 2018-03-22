<?phprequire_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";include '../includes/restriccionCam.php';$idUsuario = recuperaUsuario($_SESSION['MM_Username']);mysqli_select_db($comcon, $database_comcon);$query_preparados = "SELECT * FROM comandas WHERE estadoCerradoComanda=0 AND estadoPreparadoComanda=1 AND cantidadEntregaComanda=0 ORDER BY horaComandaPedida ASC";$preparados = mysqli_query($comcon, $query_preparados) or die(mysqli_connect_error());$row_preparados = mysqli_fetch_assoc($preparados);$totalRows_preparados = mysqli_num_rows($preparados);?><!DOCTYPE html><html>    <head>        <script type="text/javascript">            $("#keyboard").css("display","none");            $("#progress").css("display", "none");         </script>    </head>    <body class="w3-light-grey">        <div class="w3-padding w3-display-middle" id="progress"><img src="page-loader.gif" width="100px" height="100px"></div>        <div style="height: 550px;">            <div class="w3-container w3-theme-l2 w3-center">                <h4>COMANDAS PREPARADAS</h4>            </div>            <div id="preparados" style="overflow-y: scroll;height: 445px;">                <?php if ($totalRows_preparados > 0) { ?>                    <ul class="w3-ul w3">                        <?php do { ?>                        <li class=" w3-hover-light-blue w3-margin-left w3-margin-right" style="border-bottom: #706e6e solid 1px;" onclick="irA('listaTpv.php?idMesa=<?php echo $row_preparados['idMesaComanda']; ?>&idPedido=<?php echo $row_preparados['idPedidoComanda']; ?>');">                            <div class="w3-large" style="width: 50%;float: left;">MESA <?php echo recuperaNombreMesa($row_preparados['idMesaComanda']) ?></div>                            <div style="width: 50%;float: right;text-align: right;">Preparado a las: <?php echo $row_preparados['horaComandaPreparada']; ?></div>                            <div><?php echo utf8_encode(recuperaNombreProducto($row_preparados['idProductoComanda'])) ?></div>                            </li>                            <hr style="margin: 0px">                        <?php } while ($row_preparados = mysqli_fetch_assoc($preparados)); ?>                    </ul>                <?php } else { ?>                <br><br><br>                <div class="w3-container w3-section w3-margin-top w3-theme-l2 w3-center">                    <h3>NO EXISTEN PREPARADOS</h3>                </div>                <?php } ?>            </div>            <div style="height: 50px;">                <button class="w3-btn w3-indigo w3-large w3-center w3-padding-large" style="width: 100%;" onclick="irA('seleccionTpv.php')" id="">ATRAS</button>            </div>        </div>    </body></html><?phpmysqli_free_result($Mesas);?>