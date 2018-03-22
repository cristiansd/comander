<?php
require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

$esmenu = 0;
$idMenu = 0;
$idSubmenu = 0;
$idGrupoComanda = 0;
$botonAtras = 0;

if (filter_input(INPUT_GET, 'renobe')) {
    $botonAtras = 2;
}

if (filter_input(INPUT_GET, 'idGrupoComanda')) {
    $idGrupoComanda = filter_input(INPUT_GET, 'idGrupoComanda');
}

if (filter_input(INPUT_GET, 'idProducto')) {
    $idProducto = filter_input(INPUT_GET, 'idProducto');
}

if (filter_input(INPUT_GET, 'idMenu')) {
    $idMenu = filter_input(INPUT_GET, 'idMenu');
}

if (filter_input(INPUT_GET, 'idSubmenu')) {
    $idSubmenu = filter_input(INPUT_GET, 'idSubmenu');
}

if (filter_input(INPUT_GET, 'esmenu')) {
    $esmenu = 1;
}

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegProducto = "SELECT * FROM productos WHERE idProducto=" . $idProducto;
$RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
$row_RegProducto = mysql_fetch_assoc($RegProducto);
$totalRows_RegProducto = mysql_num_rows($RegProducto);

header("Cache-Control: no-cache, must-revalidate"); // Evitar guardado en cache del cliente HTTP/1.1
header("Pragma: no-cache"); // Evitar guardado en cache del cliente HTTP/1.0
?>
<!DOCTYPE html>
<html>
    <style>
        .toast {
            width:200px;
            height:20px;
            height:auto;
            position:absolute;
            left:50%;
            margin-left:-100px;
            bottom:110px;
            background-color: #383838;
            color: #F0F0F0;
            font-family: Calibri;
            font-size: 20px;
            padding:10px;
            text-align:center;
            border-radius: 5px;
            -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
            -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
            box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
        }
        .no-seleccionable {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none; 
        }

    </style>

    <head>
        <meta charset="utf-8">
        <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
        <script type="text/javascript">

            var esmenu = <?php echo $esmenu; ?>;
            var height;
            var width;

            function AñadirAlistaTemporal() {

                var quantity;

                if (esmenu) {
                    quantity = 1;
                } else {
                    quantity = $('#quantity').html();
                }

                var comentario = $('#comentario').val();
                var dataString = {'idProducto':<?php echo $idProducto ?>,
                    'cantidad': quantity,
                    'comentario': comentario,
                    'idMenu':<?php echo $idMenu; ?>,
                    'idSubmenu':<?php echo $idSubmenu; ?>,
                    'esmenu':<?php echo $esmenu; ?>,
                    'idGrupoComanda':<?php echo $idGrupoComanda; ?>
                };
                $.ajax({
                    type: "POST",
                    url: "crearComandaTemporalUsuario.php",
                    data: dataString,
                    success: function (data) {
                        if ($.trim(data) === "OK") {
                            window.location = "listaTiempoRealUsuario.php";
                        } else {
                            $('.toast').text("<?php echo $addError; ?>");
                        }


                    }
                });
            }

//FUNCION PARA CERRAR EL PANEL DE INFORMACION
            function cerrarInfo() {
                document.getElementById('id03').style.display = 'none';
                $("#informacionProducto").css("border-bottom", "1px solid #cdcdcd");
                $("#productoDetalle").css("border-bottom", "5px solid #3f51b5");
            }

//FUNCION PARA EL CLICK EN INFORMACION 
            function clickEnInformacionProducto() {
                $("#informacionProducto").css("border-bottom", "5px solid #3f51b5");
                $("#productoDetalle").css("border-bottom", "1px solid #cdcdcd");
                document.getElementById('id03').style.display = 'block';
            }

            function mostrarControles() {

                if (esmenu) {

                    $("#addcantidad").remove();
                    $("#espacio").append("<br><br>");

                }

            }

            $(document).ready(function () {
                mostrarControles();
                height = $(window).height();
                width = $(window).width();
                $("#informacionProducto").attr("style", "width:" + (width / 2) + "px;border:1px solid #cdcdcd;");
                $("#productoDetalle").attr("style", "width:" + (width / 2) + "px;border:1px solid #cdcdcd;");
                $("#productoDetalle").css("border-bottom", "5px solid #3f51b5");

                $('#min').click(function () {
                    //Solo si el valor del campo es mayor que 1
                    if (parseInt($('#quantity').html()) > 1) {
                        var val1 = parseInt($('#quantity').html()) - 1;
                        var val2 = parseInt(val1);
                        //Decrementamos su valor
                        $('#quantity').html(val2);
                    }

                });

                $('#plus').click(function () {
                    var val1 = parseInt($('#quantity').html()) + 1;
                    var val2 = val1.toString();
                    //Aumentamos el valor del campo
                    $('#quantity').html(val2);
                });
                $('#add').click(function () {
                    loadPage();
                    AñadirAlistaTemporal();
                });

            });
//FUNCION PARA MOSTRAR TOAST
            function toast(text) {
                $('.toast').text(text);
                $('.toast').fadeIn(400).delay(2000).fadeOut(400);
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN CARTA EN LA BARRA DE OPCIONES
            function clickProductos() {
                $("#carta").css("border", "1px solid #cdcdcd");
                $("#productos").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('principalUsuario.php');
            }  

            //FUNCION PARA EL MANEJO DEL CLICK EN MI LISTA EN LA BARRA DE OPCIONES
            function clickMiLista() {
                $("#carta").css("border", "1px solid #cdcdcd");
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('listaTiempoRealUsuario.php');
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN PRINCIPAL EN LA BARRA DEL HEADER
            function clickEnPrincipal() {
                loadPage();
                conection('principalUsuario.php');
            }       
            
            //FUNCION PARA EL BOTON DE ATRAS
            function atras() {
                loadPage();
                window.history.back();
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN BUSCAR EN LA BARRA DEL HEADER
            function clickBuscar() {
                $("#carta").css("border", "1px solid #cdcdcd");
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('productosBuscarUsuario.php');
            }

            //FUNCION PARA CARGAR EL DIV CARGAR
            function loadPage() {
                $("#listado").css("display", "none");
                $("#cargar").css("display", "block");
            }

            //FUNCION PARA MANEJAR EL CLICK EN AYUDA CAMARERO   
            function clickAyudaNotificacion() {
                document.getElementById('id1').style.display = 'block';
            }

            //FUNCION PARA GESTIONAR EL ENVIO DE PETICION DE AYUDA
            function confirmacionNotificacion() {
                pedirPagar(3, '<?php echo $_SESSION['id_usuario']; ?>');
                document.getElementById('id1').style.display = 'none';
                toast("<?php echo $sentToWaiterToast; ?>");
            }

        </script>
    </head>

    <?php include '../includes/importacionesUsuario.php'; ?>    
    <body class="w3-light-grey">
        <div class="no-seleccionable">
            <?php
            cabeceraNavegacionUsuario($productoMayTag, 0, $botonAtras);
            if ($totalRows_RegProducto > 0) {
                imagenProducto(filter_input(INPUT_GET, 'imagen'), 1)
                ?>       
                <div id="eleccionesProducto" style="margin-bottom: 60px;">
                    <div id="productoDetalle" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick=""><?php echo $selection; ?></div>
                    <div id="informacionProducto" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickEnInformacionProducto()"><?php echo $informationTag; ?></div>                     
                </div>    
                <div id="listado">
                    <div class="w3-margin w3-padding-left w3-padding-right">
                        <div id="espacio"></div>
                        <input  class="w3-input w3-light-grey w3-margin-top" type="text" placeholder="<?php echo $anyComents; ?>" id="comentario">
                    </div>
                    <h2 id="addcantidad" class="w3-center" style="margin-top: 50px;">             
                        <a class="w3-btn-floating-large w3-theme-l2" style="overflow: visible;margin-right: 35px;" id="min">-</a>          
                        <div class="w3-tag w3-padding-medium w3-round w3-indigo" style="padding: 6px 16px!important;bottom: 0px;" id="quantity">1</div>               
                        <a class="w3-btn-floating-large w3-theme-l2" style="overflow: visible;margin-left: 35px;" id="plus">+</a>
                    </h2>

                    <footer class="w3-container w3-theme-l2 w3-bottom w3-padding-16 w3-btn-block">            
                        <div class="w3-large" id="add"><?php echo $addMay; ?></div>           
                    </footer>
                </div>

                <div id="id03" class="w3-modal w3-animate-opacity">
                    <div class="w3-modal-content w3-card-8 w3-round-medium">
                        <header class="w3-container w3-indigo"> 
                            <span onclick="cerrarInfo()" 
                                  class="w3-closebtn">&times;</span>
                            <h4><?php echo recuperarString($row_RegProducto['id_string']); ?></h4>
                        </header>
                        <div class="w3-container w3-large w3-margin">
                            <strong>-<?php echo $priceTagMin; ?>:</strong><br>
                            &nbsp;&nbsp;<?php echo number_format($row_RegProducto['precioVentaProducto'], 2) . "€"; ?>
                            <hr style="margin-bottom: 5px;">
                            <strong>- <?php echo $descriptionTagMin; ?>:</strong><br>
                            &nbsp;&nbsp;<?php 
                            if ($row_RegProducto['descripcionProducto'] == null) {
                                echo $notDisponible;
                            } else {
                            echo recuperarString($row_RegProducto['id_string_descripcion']); 
                            }
                            ?>
                            <hr style="margin-bottom: 5px;">
                            <strong>- <?php echo $nutricionalInformationTag; ?>:</strong><br>
                            &nbsp;&nbsp;<?php
                            if ($row_RegProducto['nutricionalProducto'] == null) {
                                echo $notDisponible;
                            } else {
                                echo recuperarString($row_RegProducto['is_sring_nutricional']);
                            }
                            ?>
                            <hr style="margin-bottom: 5px;">
                            <strong>- <?php echo $informationAllergensTag; ?>:</strong><br>
                            &nbsp;&nbsp;<?php
                            if ($row_RegProducto['alergenosProducto'] == null) {
                                echo $notDisponible;
                            } else {
                                echo recuperarString($row_RegProducto['id_string_alergenos']);
                            }
                            ?>
                            <hr style="margin-bottom: 5px;">
                        </div>
                    </div>
                </div>
                <img id="cargar" src="../imagenes/UsuarioImages/page-loader.gif" style="display: none; margin: 35% 35%">
                <div class="toast" style="display: none"></div>
                <div id="id1" class="w3-modal" style="display: none">
                    <div class="w3-container w3-section w3-yellow w3-center">
                        <span onclick="document.getElementById('id1').style.display = 'none';" class="w3-closebtn">&times;</span>
                        <h3><?php echo $atentionTag; ?></h3>
                        <div id="prueba"></div>
                        <b><?php echo $sentNotfificationToWaiter; ?></b><br>
                        <b><?php echo $confirmNotification; ?></b><br><br>
                        <div class="w3-margin-top w3-margin-bottom w3-center">
                            <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="confirmacionNotificacion();"><?php echo $siTag; ?></button>
                            <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id1').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                        </div>
                    </div>    
                </div>
                <div id="sinConexion" class="w3-modal w3-top">
                    <div class= "w3-container  w3-center w3-light-grey">
                        <br><br><br><br>  
                        <img src="../imagenes/UsuarioImages/alerta.jpg" width="128" height="128"><br>
                        <br>
                        <div class="w3-large w3-margin-top">
                            <?php echo $errorServer; ?>
                            <br>
                            <?php echo $checkInternet; ?>
                        </div>
                        <br><br><br> 
                        <a class="w3-btn w3-white w3-border w3-round w3-card-4" style="width: 100%;" onclick="reload()"><?php echo $retrieveTag; ?></a>
                    </div>
                </div>

                <?php
            }
            mysql_free_result($RegProducto);
            ?>
        </div>
    </body>
</html>