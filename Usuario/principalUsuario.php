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

//PARSEAMOS LAS VARIABLES DE SESION
?>

<!DOCTYPE html>
<html>
    <head>    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
        <script type="text/javascript" charset="UTF-8" src="jquery-mobile/jquery.js"></script>


        <style type="text/css">
            .no-seleccionable {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none; 
            }
            .toast {

                width:200px;

                height:20px;

                height:auto;

                position:absolute;

                left:50%;

                margin-left:-100px;

                bottom:140px;

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
        </style>

        <script type="text/javascript">
            
            //FUNCION PARA ELEGIR PRODUCTO
            function changeColor(x) {
                x.style.background = "#C6D5FF";
                window.setTimeout("loadPage()", 500);
            }
            
           //FUNCION PARA CARGAR EL DIV CARGAR
            function loadPage() {
                $("#listado").css("display", "none");
                $("#cargar").css("display", "block");
            }

            var imagen;
            var height;
            var lista;
            var width;
            var anchura;
            var anchuralistado;
            var elementClicked = 'vacio';
            var myVar;
            var nPedido;

            $(document).ready(function () {                
                document.addEventListener("click", onClick, false);                
                width = $(window).width();
                height = $(window).height();
                imagen = "height:" + ((height / 100) * 30) + "px;width: 100%;margin-top:0px;";
                $("#imagen").attr("style", imagen);
                lista = "overflow: scroll;height:" + (((height / 100) * 70) - 110) + "px;margin-top:40px;";
                $("#listado").attr("style", lista);
                $("#lista").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
                $("#carta").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
                $("#productos").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
                $("#productos").css("border-bottom", "5px solid #3f51b5");
                var marginTop = ((height - 129 - (((height - 45) / 100) * 37) * 2) / 3);
                var styleTitulo = "width:25px;height: 40px;margin-left:" + ((width - 280) / 2) + "px;";
                $("#titulo").attr("style", styleTitulo);
                //$("#leftMenu").css("height", height / 100 * 50 + "px");
                cargarUsuario();
            });

            //FUNCION PARA MOSTRAR TOAST
            function toast(text) {
                $('.toast').text(text);
                $('.toast').fadeIn(400).delay(2000).fadeOut(400);
            }
            //FUNCION PARA EL MANEJO DEL CLICK EN CARTA EN LA BARRA DE OPCIONES
            function clickCarta() {
                $("#productos").css("border", "1px solid #cdcdcd");
                $("#carta").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('verCategoriasUsuario.php');
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN MI LISTA EN LA BARRA DE OPCIONES
            function clickMiLista() {
                $("#productos").css("border", "1px solid #cdcdcd");
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('listaTiempoRealUsuario.php');
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN BUSCAR EN LA BARRA DEL HEADER
            function clickBuscar() {
                $("#productos").css("border", "1px solid #cdcdcd");
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('productosBuscarUsuario.php');
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

            //FUNCIONES PARA APERTURA Y CIERRE DE PANEL LATERAL
            function openLeftMenu() {
                if ($("#leftMenu").is(":visible")) {
                    closeLeftMenu();
                } else {
                    document.getElementById("leftMenu").style.display = "block";
                }
            }
            function closeLeftMenu() {
                document.getElementById("leftMenu").style.display = "none";
            }

            //FUNCION PARAR CARGAR EL USUARIO AL INICIO
            function cargarUsuario() {
                descargarPedidos("", false,false);
            }

            //FUNCION PARA CLICKAR EN PEDIDO PENDIENTE
            function clickPedidos() {
                $("#miPedidoPendienteLeft").removeClass("w3-show");
                $("#misPedidosLeft").empty();
                descargarPedidos("historico", true,true);
            }

            //FUNCION PARA CLICKAR EN PEDIDO PENDIENTE
            function clickPedidosPendientes() {
                $("#misPedidosLeft").removeClass("w3-show");
                $("#miPedidoPendienteLeft").empty();
                descargarPedidos("", true,true);
            }

            //FUNCION PARA DESPLEGABLE DE PEDIDOS
            function desplegar() {
                var x = document.getElementById("misPedidosLeft");
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }

//FUNCION PARA DESPLEGABLE DE PEDIDO PENDIENTE
            function desplegarPendiente() {
                var x = document.getElementById("miPedidoPendienteLeft");
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }

            //FUNCION PARA DESCARGAR LOS PEDIDO DEL USUARIO
            function descargarPedidos(lista, click,variable) {
                var pedido;
                var estado;
                var fecha;
                var tiquets = 0;
                var registro;
                var idUser = <?php echo $_SESSION['id_usuario']; ?>;

                var data = {'idUser': idUser};
                var ajax = $.ajax({
                    type: "POST",
                    data: data,
                    dataType: "jsonp",
                    url: 'http://comander.es/Comander/Usuario/descargarPedidos.php',
                    crossDomain: true,
                    cache: false,
                    async: false,
                });
                ajax.done(function (data) {
                    $.each(data, function (id, establecimiento) {
                        $.each(establecimiento, function () {

                            pedido = establecimiento['tiquet'];
                            estado = establecimiento['estado']; 
                            fecha = establecimiento['fecha']; 
                            if (estado == '0') {
                                tiquets++;
                            }
                        });
                        if (variable == true) {
                            addPedido(pedido, estado, fecha);
                        }
                    });
                    if (tiquets) {
                        $("#divMiPedidoPendienteLeft").css("display", "block");
                        $("#imagenIconoIzq").attr("src", "../imagenes/UsuarioImages/menu2.png")
                    }
                    if (click) {
                        if (lista == "historico") {
                            desplegar();
                        } else if (lista == ""){
                            desplegarPendiente();
                        }
                    }
                });
                ajax.fail(function (jqXHR, textStatus, errorThrown) {
                    loading('ocultar');
                    if (textStatus === "timeout") {
                        document.getElementById('sinConexion').style.display = 'block';     
                    } else {
                        toast("<?php echo $errorToast; ?>");
                    }
                });
            }
            
    //FUNCION PARA AÑADIR LOS PEDIDOS AL SIDENAV
            function addPedido(pedido, estado, fecha) {
                if (estado == '0') {
                    /*var registro = "<a style=\"background-color:#dddddd\" onclick=\"window.open('https://docs.google.com/viewer?url=http://www.comander.es/Comander/Usuario//tiquets/" + pedido + ".pdf&embedded=true')\">" + fecha + "<font color = red>&nbsp;Pendiente</font></a>";
                    $("#miPedidoPendienteLeft").append(registro);*/
                    var registro = "<a id=\"pedido\" style=\"background-color:#dddddd\" onclick=\"pedidoPendiente('" + pedido + "')\">" + fecha + "<font color = red>&nbsp;<?php echo $missingOrder; ?></font></a>";
                    $("#miPedidoPendienteLeft").append(registro);
                } else {
                    var registro = "<a onclick=\"window.open('https://docs.google.com/viewer?url=http://www.comander.es/Comander/Usuario//tiquets/" + pedido + ".pdf&embedded=true')\">" + fecha + "</a>";
                    //var registro = "<a onclick=\"window.open('https://docs.google.com/viewer?url=http://www.comander.es/Comander/includes/imagenPDF.php&embedded=true')\">" + fecha + "</a>";
                    //var registro = "<a onclick=\"window.location.href = 'http://www.comander.es/Comander/includes/imagenPDF.php'\">" + fecha + "</a>";
                    $("#misPedidosLeft").append(registro);
                }                
            }
            
    //FUNCION PARA VISUALIZAR EL PEDIDO PENDIENTE
            function pedidoPendiente(pedido){
                $("#tituloPedidoPendiente").empty();
                $("#tituloPedidoPendiente").append("<?php echo $comandPending; ?> " + pedido);                
                $("#loading").css("display", "block");
                $("#id07").css("display", "block");
                nPedido = pedido;
                descargarPedidoPendiente();                
            }
            
    //FUNCION PARA DESCARGAR LOS PEDIDOS PENDIENTES
            function descargarPedidoPendiente() {
                var cant;
                var nombre;
                var cantidad = 0;
                
                $("#tablaMenu").empty();
                        
                var data = {'pedido': nPedido, 'local':<?php echo $_SESSION['establecimiento']; ?>};
                var ajax = $.ajax({
                    type: "POST",
                    data: data,
                    dataType: "jsonp",
                    url: 'http://comander.es/Comander/Usuario/descargarPedidoPendiente.php',
                    crossDomain: true,
                    cache: false,
                    timeout: 5000
                });
                ajax.done(function (data) {
                    $.each(data, function (id, establecimiento) {
                        $.each(establecimiento, function () {
                            if(establecimiento['cantidad'] == null){
                                conection('principalUsuario.php');
                            }
                            cant = establecimiento['cantidad'];
                            nombre = establecimiento['nombre'];
                        });
                        cantidad++;
                        addComanda(cant, nombre);
                    });
                    $("#loading").css("display", "none");
                    $("#tablaMenu").css("display", "block");
                    setInterval();
                });
                ajax.fail(function (jqXHR, textStatus, errorThrown) {
                    if (textStatus === "timeout") {
                        document.getElementById('sinConexion').style.display = 'block';
                    } else {
                        toast("<?php echo $errorToast; ?>");
                    }
                });
            }
            
    //FUNCION PARA AÑADIR LAS COMANDAS A LA LISTA
            function addComanda(cant, nombre){
                var registro = "<tr><td style=\"width:" + ((width/100)*10) + "px;\">" + cant + "</td><td style=\"width:" + ((width/100)*90) + "px;text-align: left;padding-left:50px;\">" + nombre + "</td></tr>";
                $("#tablaMenu").append(registro);
            }
            
    //FUNCION PARA REFRESCAR EN INTERVALOS EL PANEL DE PEDIDOS PENDIENTES
            function setInterval(){                
                myVar = setTimeout("descargarPedidoPendiente()",5000)
            }
            
    //FUNCION PARA MANEJAR EL EVENTO ONCLICK
            function onClick() {
                cerrarDiv();
            }

    //FUNCION PARA CERRAR DIV AL CLICKAR EN EL BODY
            function cerrarDiv() {
                if ($("#leftMenu").is(":visible")) {
                    switch (elementClicked) {
                        case 'vacio':
                        break;
                        case 'iconoIzqHeader':
                        break;
                        case 'pedidoLeft':
                        break;
                        case 'pedidoPendienteLeft':
                        break;
                        case 'pedidoPendienteLeftText':
                        break;
                        case 'lenguaje':
                        break;
                        case 'peidosHistorial':
                        break;
                        default:
                            closeLeftMenu();
                    }
                }
            }
            
    //FUNCION PARA CONTROLAR QUE ELEMENTO FUE PULSADO
            function elementClick() {
                var li = document.getElementById("body");
                li.addEventListener("click", function (event) {
                    elementClicked = event.target.id;
                    if (elementClicked == '') {
                        elementClicked = event.target.parentElement.id;
                    }
                });
            }

        </script>

        <?php include '../includes/importacionesUsuario.php'; ?>

    <body id="body" class="w3-light-grey" onclick="elementClick()">
        <div class="no-seleccionable">
            <?php include '../includes/cabeceraPrincipalUsuario.php'; ?> 
            <div id="contenido" style="margin-top: 65px!important;">
                <img id="imagen" src="../includes/imagenEstablecimientos.php?id=<?php echo $_SESSION['establecimiento']; ?>" class="w3-round-small w3-animate-zoom" alt="Norway" style="width:100%;"> 
                <div id="elecciones">
                    <div id="productos" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick=""><?php echo $productsMayTag; ?></div>
                    <div id="carta" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickCarta();"><?php echo $menuLetter; ?></div>
                    <div id="lista" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickMiLista();"><?php echo $myList; ?></div>                 
                </div>
                <ul id="listado" class="w3-ul w3-card-2"style="margin-top: 10px;">
                    <?php do { ?>
                        <li style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="conection('mostrarDetalleUsuario.php?idProducto=<?php echo utf8_encode($row_RegProducto['idProducto']) . "&nombre=" . utf8_encode($row_RegProducto['nombreProducto']) . "&imagen=" . $row_RegProducto['id_imagen']; ?>');
                                    changeColor(this);">                                 
                                    <img src="../includes/imagen.php?id=<?php echo $row_RegProducto['id_imagen']."&local=".$_SESSION['establecimiento']; ?>" class="w3-left" style="width:90px;height:88px;">
                            <div class="w3-centered w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 100px;"><?php echo recuperarString($row_RegProducto['id_string']); ?><br><?php echo number_format($row_RegProducto['precioVentaProducto'], 2); ?>&euro;</div>
                        </li>
                    <?php } while ($row_RegProducto = mysql_fetch_assoc($RegProducto)); ?>
                        <hr>
                </ul>
                <img id="cargar" src="../imagenes/UsuarioImages/page-loader.gif" style="display: none; margin: 35% 35%">
            </div>
        </div>
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
        <div id="id2" class="w3-modal" style="display: none">
            <div class="w3-container w3-section w3-yellow w3-center">
                <span onclick="document.getElementById('id2').style.display = 'none';" class="w3-closebtn">&times;</span>
                <h3><?php echo $atentionTag; ?></h3>
                <div id="prueba"></div>
                <b><?php echo $exitLocalDescription; ?></b><br>
                <b><?php echo $exitLocalDescription2; ?></b><br>
                <b><?php echo $confirmNotification; ?></b><br><br>
                <div class="w3-margin-top w3-margin-bottom w3-center">
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="conection('closesesion.html');"><?php echo $siTag; ?></button>
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id2').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                </div>
            </div>    
        </div>
        <div id="id3" class="w3-modal" style="display: none">
            <div class="w3-container w3-section w3-yellow w3-center">
                <span onclick="document.getElementById('id3').style.display = 'none';" class="w3-closebtn">&times;</span>
                <h3><?php echo $atentionTag; ?></h3>
                <div id="prueba"></div>
                <b><?php echo $leavingYourSesion; ?></b><br>
                <b><?php echo $confirmNotification; ?></b><br><br>
                <div class="w3-margin-top w3-margin-bottom w3-center">
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="conection('prueba3.php');"><?php echo $siTag; ?></button>
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id3').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                </div>
            </div>    
        </div>
        <div id="id4" class="w3-modal" style="display: none">
            <div class="w3-container w3-section w3-yellow w3-center">
                <span onclick="document.getElementById('id4').style.display = 'none';" class="w3-closebtn">&times;</span>
                <h3><?php echo $atentionTag; ?></h3>
                <div id="prueba"></div>
                <b><?php echo $closeAplicationTag; ?></b><br>
                <b><?php echo $confirmNotification; ?></b><br><br>
                <div class="w3-margin-top w3-margin-bottom w3-center">
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="conection('cerrarApp.php');"><?php echo $siTag; ?></button>
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id4').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                </div>
            </div>    
        </div>
        <div id="id07" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span id="cierre" onclick="document.getElementById('id07').style.display = 'none';clearTimeout(myVar)" class="w3-closebtn">&times;</span>
                        <h5 id="tituloPedidoPendiente"></h5>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <div class="w3-center w3-margin-bottom w3-margin-top w3-padding-0">
                            <div class="w3-row w3-theme-l4 w3-large w3-margin-top">
                                <div style="width:20%;float: left;"><?php echo $unitTag; ?></div>
                                <div style="width:80%;padding-left: 25%;text-align: left;"><?php echo $productTagMin; ?></div>  
                            </div>
                                <table id="tablaMenu" class="w3-table w3-border w3-margin-top w3-large  w3-bordered w3-striped w3-hoverable" style="display:none"></table>
                           
                            <img id="loading" src="../imagenes/UsuarioImages/page-loader.gif" style="display: none; margin: 35% 35%">
                        </div>
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
    </body>
</html>
