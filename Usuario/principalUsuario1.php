<?php
require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegProducto = "SELECT * FROM productos WHERE estadoProducto=1";
$RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
$row_RegProducto = mysql_fetch_assoc($RegProducto);
$totalRows_RegProducto = mysql_num_rows($RegProducto);
?>

<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, user-scalable=no">
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
    <script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
   

    <style type="text/css">
        .no-seleccionable {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none; 
        }
    </style>
    
    <script type="text/javascript">
        function changeColor(x) {
            x.style.background = "#C6D5FF";
        }
        var imagen;
        var height;
        var lista;
        var width;
        var anchura;
        var anchuralistado;

        $(document).ready(function () {
            width = $(window).width();
            var botones = "<div id=\"filtrar\" class=\" w3-card-8 w3-left\"" +
                    "style=\"width:" + ((width / 2) - 1) + "px;height:25px;\"" +
                    "onclick=\"conection('verCategoriasUsuario.php');\">" +
                    "<i class=\"w3-left material-icons\">sort</i>" +
                    "<div class=\"w3-center\" style=\"margin-right:30px;\">Filtrar </div>" +
                    "</div>" +
                    "<div id=\"listado\" class=\" w3-card-8 w3-right\"" +
                    "style=\"width:" + ((width / 2) - 1) + "px;margin-right: 0px;height:25px;\"" +
                    "onclick=\"conection('listaTiempoRealUsuario.php');\"><div class=\"w3-center\">Mi lista" +
                    "</div></div>";
            height = $(window).height();
            imagen = "height:" + ((height / 100) * 30) + "px;width: 100%;margin-top:0px;";
            $("#imagen").attr("style", imagen);
            lista = "overflow: scroll;height:" + (((height / 100) * 70) - 110) + "px;margin-top: 50px;";
            $("#lista").attr("style", lista);
            $("#botones").append(botones);
        });
    </script>
    
    <?php include '../includes/importacionesUsuario.php'; ?>
    
    <body class="w3-light-grey">
        <div class="no-seleccionable">
            <?php include '../includes/cabeceraPrincipalUsuario.php'; ?>        
            <img id="imagen" src="../imagenes/imagenRestaurante.jpg" class="w3-round-small w3-animate-zoom" alt="Norway" style="width:100%;"> 
            <div id="botones" class="w3-medium  letraBotones " style="margin-top:10px;"></div>
            <ul id="lista" class="w3-ul w3-card-2"style="margin-top: 10px;">
                <?php do { ?>
                    <li style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="conection('mostrarDetalleUsuario.php?idProducto=<?php echo utf8_encode($row_RegProducto['idProducto']) . "&nombre=" . utf8_encode($row_RegProducto['nombreProducto']) . "&imagen=" . utf8_encode($row_RegProducto['imagenProducto']); ?>');
                            changeColor(this);">                                 
                        <img src="../archivos/ImagenesAdd/<?php echo utf8_encode($row_RegProducto['imagenProducto']); ?>" class="w3-left" style="width:90px;height:88px;">
                        <div class="w3-centered w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 100px;"><?php echo utf8_encode($row_RegProducto['nombreProducto']); ?><br><?php echo number_format($row_RegProducto['precioVentaProducto'], 2); ?>&euro;</div>
                    </li>
                <?php } while ($row_RegProducto = mysql_fetch_assoc($RegProducto)); ?>
            </ul>
        </div>
    </body>
</html>
