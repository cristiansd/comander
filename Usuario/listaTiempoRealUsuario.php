<?php
require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';
include '../Gcm/sending_push.php';

$count = 0;
$mensaje = $listEmpty;
$totalRows_Registros = 0;

//COMPROBAMOS SI LA TABLA TEMPORAL DEL USUARIO ESTA CREADA
mysql_select_db($database_usuario, $comcon_usuario);
$result = "show tables like 'comandaTemp_" . $_SESSION['id_usuario'] . "'";
$resultados = mysql_query($result, $comcon_usuario) or die(mysql_error());
$existe = mysql_num_rows($resultados);

if ($existe) {

//SELECCIONAMOS TODOS REGISTROS 
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_Registros = "SELECT * FROM comandaTemp_" . $_SESSION['id_usuario'] . "";
    $RegRegistros = mysql_query($query_Registros, $comcon_usuario) or die(mysql_error());
    $row_Registros = mysql_fetch_assoc($RegRegistros);
    $totalRows_Registros = mysql_num_rows($RegRegistros);

//SELECCIONAMOS TODOS REGISTROS EXCEPTOS LOS DE MENU
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegComanda = "SELECT * FROM comandaTemp_" . $_SESSION['id_usuario'] . " WHERE idGrupoMenuComandaTemp IS NULL ";
    $RegComanda = mysql_query($query_RegComanda, $comcon_usuario) or die(mysql_error());
    $row_RegComanda = mysql_fetch_assoc($RegComanda);
    $totalRows_RegComanda = mysql_num_rows($RegComanda);

//SELECCIONAMOS LOS REGISTROS AGRUPADOS POR MENUS

    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegMenus = "SELECT * FROM comandaTemp_" . $_SESSION['id_usuario'] . " WHERE idGrupoMenuComandaTemp IS NOT NULL GROUP BY idGrupoMenuComandaTemp ";
    $RegMenus = mysql_query($query_RegMenus, $comcon_usuario) or die(mysql_error());
    $row_RegMenus = mysql_fetch_assoc($RegMenus);
    $totalRows_RegMenus = mysql_num_rows($RegMenus);
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta charset="utf-8">
        <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
        <script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
        <script type="text/javascript" src="../includes/sendPush.js"></script>
        <script type="text/javascript" src="../includes/sendPushCamarero.js"></script>
        <script type="text/javascript" src="../includes/sendPushSinPedido.js"></script>
        <script type="text/javascript" src="../includes/sendPushCamareroSinPedido.js"></script>
        <style>
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

            var manejaComanda = "";

            var idGrupoMenus = "";

            var comentario = "";

            var height = "";

            var micontenedor;

            var width;

            var atributo;

            var count = <?php echo $count; ?>;

            var registro;

            var totalRegistros = <?php echo $totalRows_Registros; ?>;

            var low;


            function changeColor(x) {
                x.style.background = "#C6D5FF";
            }

            function modificarMenu() {
                window.location = "verProductosMenuUsuario.php";
            }

            function ponerBoton(Grupo) {

                var botoneliminar = "<button class=\"w3-btn w3-margin-top w3-indigo\" style=\"width: 80%\" onclick=\"document.getElementById('id10').style.display = 'block';document.getElementById('id07').style.display = 'none';\"><?php echo $eliminateAll; ?></button>";
                var botonadd = "<button class=\"w3-btn w3-margin-top w3-indigo\" style=\"width: 80%\" onclick=\"seguirMenu(" + Grupo + ")\"><?php echo $completeMenu; ?></button>";

                $("#botonesid07").append(botonadd + botoneliminar);
            }

            function comprobarLista() {
                loadPage();
                comprobarMenusSinCompletar(1);
            }

            function quitarBoton() {

                var botoneliminar = "<button class=\"w3-btn w3-margin-top w3-indigo\" style=\"width: 80%\" onclick=\"document.getElementById('id10').style.display = 'block';document.getElementById('id07').style.display = 'none';\"><?php echo $eliminateAll; ?></button>";

                $("#botonesid07").append(botoneliminar);
            }


            function consultaCompletoMenu(idGrupo) {

                var Grupo = {'idGrupo': idGrupo};

                $.ajax({
                    type: "POST",
                    url: "consultaMenuCompletoUsuario.php",
                    data: Grupo,
                    success: function (data) {

                        if ($.trim(data) === "OK") {
                            ponerBoton(idGrupo);
                        } else {
                            quitarBoton();
                        }
                    }

                });

            }


            function lista_menu(idGrupo) {

                idGrupoMenus = idGrupo;

                $("#tablaMenu").empty();
                $("#botonesid07").empty();
                consultaCompletoMenu(idGrupo);

                $.getJSON("consultaMenuUsuario.php?idGrupo=" + idGrupo, function (respuesta) {

                    var idRegistro = new Array();
                    var nombreComanda = new Array();
                    var x = 0;

                    $.each(respuesta, function (id, comanda) {
                        $.each(comanda, function (idTabla, nombre) {
                            if (idTabla == 0) {
                                idRegistro[x] = nombre;
                            }
                            if (idTabla == 1) {
                                nombreComanda[x] = nombre;
                            }
                        });

                        var registro = "<tbody><tr onclick=\"setRegistro(" + idRegistro[x] + ");recuperarComentarioComandaMenu();document.getElementById('id08').style.display = 'block';document.getElementById('id07').style.display = 'none'\";><td>" + nombreComanda[x] + "</td></tr></tbody>";
                        $("#tablaMenu").append(registro);

                        x++;

                    });
                });
            }

            function setRegistro(registro) {

                this.registro = registro;

            }

            function w3_open() {
                document.getElementById("mySidenav").style.display = "block";
            }
            function w3_close() {
                document.getElementById("mySidenav").style.display = "none";
            }

            function recuperarComentario() {

                var comanda = {'idComanda': manejaComanda};

                $.ajax({
                    type: "POST",
                    url: "recuperarComentarioUsuario.php",
                    data: comanda,
                    success: function (data) {

                        $('#textocomentario').val(data);

                    }

                });

            }

            function recuperarComentarioComandaMenu() {

                var comanda = {'idComanda': registro};

                $.ajax({
                    type: "POST",
                    url: "recuperarComentarioUsuario.php",
                    data: comanda,
                    success: function (data) {

                        $('#textocomentarioComandaMenu').val(data);

                    }

                });

            }

            function irAcategorias() {
                window.location = "verCategoriasUsuario.php";
            }

            function seguirMenu(idGrupo) {
                if (idGrupo) {
                    window.location = "verSubMenusUsuario.php?esmenu=1&idGrupo=" + idGrupo;
                } else {
                    window.location = "verSubMenusUsuario.php?esmenu=1";
                }
            }
            
            function mostrarFromasPago(metalico, tarjeta, autopago){
                if(metalico == '0'){
                   $("#pagoMetalico").remove();
               }
               if(tarjeta == '0'){
                   $("#pagoTarjeta").remove();
               }
               if(autopago == '0'){
                   $("#autopago").remove();
               }
                
                document.getElementById('cargar').style.display = 'none';
                document.getElementById('id13').style.display = 'block';
            }
            
            function formasPagoAceptadas(){
                var metalico;
                var tarjeta;
                var autopago;
                var data = {'id': <?php echo $_SESSION['establecimiento']; ?>, 'cantidad': low};
                var ajax = $.ajax({
                    type: "POST",
                    data: data,
                    dataType: "jsonp",
                    url: 'http://comander.es/Comander/Usuario/formasPago.php',
                    crossDomain: true,
                    cache: false,
                    async: false,
                });
                ajax.done(function (data) {
                    $.each(data, function (id, establecimiento) {
                        $.each(establecimiento, function () {

                            metalico = establecimiento['metalico'];
                            tarjeta = establecimiento['tarjeta'];
                            autopago = establecimiento['autopago'];
                            
                        });
                        
                    });
                    mostrarFromasPago(metalico, tarjeta, autopago);
                });
                ajax.fail(function (jqXHR, textStatus, errorThrown) {
                });
            }

            function comprobarMenusSinCompletar(confirm) {

                $.ajax({
                    url: "comprobarMenus.php",
                    success: function (data) {

                        if ($.trim(data) === "OK") {
                            document.getElementById('id12').style.display = 'block';
                        } else {
                            if (confirm) {
                                //document.getElementById('id13').style.display = 'block';
                                formasPagoAceptadas();                                
                            } else {
                                window.location = "principalUsuario.php";
                            }
                        }
                    }
                });
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN PRINCIPAL EN LA BARRA DEL HEADER
            function atras() {
                loadPage();
                window.history.back();
            }

            //FUNCION PARA CARGAR EL DIV CARGAR
            function loadPage() {
                $("#pantalla").css("display", "none");
                $("#cargar").css("display", "block");
            }

            //FUNCION PARAR CERRAR EL PANEL PAGAR
            function cerrarPanelPagar() {
                document.getElementById('id13').style.display = 'none';
                $("#cargar").css("display", "none");
                $("#pantalla").css("display", "block");
            }

            //FUNCION PARA EL CLICK DEL AUTOPAGO
            function clickAutopago() {
                document.getElementById('id13').style.display = 'none';
                loadPage();
                conection('paymentForm.php?amount=' + low );

            }
            //FUNCION PARA MANEJAR EL CLICK EN COBRO METALICO CAMARERO   
            function clickCobroMetalicoNotificacion() {
                document.getElementById('id13').style.display = 'none';
                document.getElementById('id15').style.display = 'block';
            }
            
            //FUNCION PARA MANEJAR EL CLICK EN COBRO TARGETA DE CREDITO CAMARERO   
            function clickCobroTargetaNotificacion() {
                document.getElementById('id13').style.display = 'none';
                document.getElementById('id16').style.display = 'block';
            }

            //FUNCION PARA GESTIONAR EL ENVIO DE PETICION DE AYUDA
            function confirmacionNotificacion(tipo) {
                pedirPagar(tipo, '<?php echo $_SESSION['id_usuario']; ?>');
                if (tipo == 1){
                document.getElementById('id15').style.display = 'none';
                document.getElementById('pantalla').style.display = 'block';
            }else if (tipo == 2){
                document.getElementById('id16').style.display = 'none';
                document.getElementById('pantalla').style.display = 'block';
            }
                toast("<?php echo $sentToWaiterToast; ?>");
            }
            
            //FUNCION PARA MOSTRAR TOAST
            function toast(text) {
                $('.toast').text(text);
                $('.toast').fadeIn(400).delay(2000).fadeOut(400);
            }


            function cantidadMod(cant, idComanda) {

                $('#quantity').html(cant);

                manejaComanda = idComanda;

            }

            function cantidadMenu(cant, idGrupoMenu) {

                $('#quantity').html(cant);

                idGrupoMenus = idGrupoMenu;

            }

            function comprobacionLista() {
                $.ajax({
                    url: "comprobarLista.php",
                    success: function (data) {

                        if ($.trim(data) === "VACIA") {
                            $('#confirm').attr("onclick", "");
                            $('#btnEnviarPedido').attr("style", "opacity:0.2;");
                        }
                    }
                });
            }

            function actualizaPrecio() {

                $.ajax({
                    url: "actualizaPrecioComandaTempUsuario.php",
                    success: function (data) {     
                            low = '';
                        if (!isNaN(data)) {
                            low = parseFloat(data).toFixed(2);
                            if (isNaN(low)) {
                                low = '0.00';
                            }
                            $("#divprecio").html(low + ' &euro;');
                        }
                    },
                        error: function(){

                            $('.toast').text("<?php echo $errorToActual; ?>");

                            $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                        }                   

                });

            }

            $(document).ready(function () {

                comprobacionLista();

                actualizaPrecio();

                height = $(window).height();

                width = $(window).width();

                atributo = $("#textoheader").attr("style");

                micontenedor = "overflow: scroll;height:" + ((height / 100) * 60) + "px;";

                anchoPrecio = "width:" + ((width / 100) * 30) + "px;";

                var prueba = "padding-left:" + ((width - 24 - 16 - 120 - 16 - ((width / 100) * 30)) / 2) + "px;";

                centrarTextoHeader = "width:" + ((width / 100) * 50) + "px;";

                $("#pantalla").attr("style", micontenedor);

                $("#contprecio").attr("style", anchoPrecio);

                $("#textoheader").attr("style", atributo + prueba);

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



                $('#eliminar').click(function () {

                    document.getElementById('id04').style.display = 'none';
                    document.getElementById('id05').style.display = 'none';
                    document.getElementById('id06').style.display = 'none';
                    document.getElementById('id11').style.display = 'none';


                    var elim = {'idComanda': manejaComanda};

                    $.ajax({
                        type: "POST",
                        url: "borrarComandaTempUsuario.php",
                        data: elim,
                        success: function (data) {

                            if ($.trim(data) === "OK") {

                                $('.toast').text("<?php echo $comandDelette; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                                $("#pantalla").load(location.href + " #pantalla");

                                actualizaPrecio();

                                comprobacionLista();

                            } else {

                                $('.toast').text("<?php echo $errorToDelette; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                            }

                        }

                    });
                });

                $('#eliminarComandaMenu').click(function () {

                    document.getElementById('id11').style.display = 'none';


                    var elim = {'idComanda': manejaComanda};

                    $.ajax({
                        type: "POST",
                        url: "borrarComandaTempUsuario.php",
                        data: elim,
                        success: function (data) {

                            if ($.trim(data) === "OK") {

                                $('.toast').text("<?php echo $comandDelette; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                                $("#pantalla").load(location.href + " #pantalla");

                                actualizaPrecio();

                            } else {

                                $('.toast').text("<?php echo $errorToDelette; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                            }

                        }

                    });
                });

                $('#btnEliminarMenu').click(function () {

                    document.getElementById('id07').style.display = 'none';
                    document.getElementById('id10').style.display = 'none';

                    var elim = {'idGrupoMenu': idGrupoMenus};

                    $.ajax({
                        type: "POST",
                        url: "borrarComandaTempUsuario.php",
                        data: elim,
                        success: function (data) {

                            if ($.trim(data) === "OK") {

                                $('.toast').text("<?php echo $menuDeletted; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                                $("#pantalla").load(location.href + " #pantalla");

                                actualizaPrecio();

                                comprobacionLista();

                            } else {

                                $('.toast').text("<?php echo $errorToDelette; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                            }

                        }

                    });
                });

                $('#btnmodificar').click(function () {

                    var valentrega = parseInt($('#quantity').html());

                    var comentario = $('#textocomentario').val();

                    var dataString = {'idComanda': manejaComanda, 'cantidad': valentrega, 'comentario': comentario};

                    $.ajax({
                        type: "POST",
                        url: "modificarComandaTempUsuario.php",
                        data: dataString,
                        success: function (data) {

                            if ($.trim(data) === "OK") {

                                document.getElementById('id04').style.display = 'none';
                                document.getElementById('id05').style.display = 'none';
                                document.getElementById('id06').style.display = 'none';

                                actualizaPrecio();

                                $("#pantalla").load(location.href + " #pantalla");

                                manejaComanda = '';

                                comentario = '';

                                $('.toast').text("<?php echo $rowModify; ?>");

                                $('.toast').fadeIn(20).delay(2000).fadeOut(400);

                            } else {

                                $('.toast').text("<?php echo $modifyError; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                            }

                        }

                    });

                });

                $('#btnmodificarComentarioComandaMenu').click(function () {

                    var comentario = $('#textocomentarioComandaMenu').val();

                    var dataString = {'idComanda': registro, 'comentario': comentario};

                    $.ajax({
                        type: "POST",
                        url: "modificarComandaTempUsuario.php",
                        data: dataString,
                        success: function (data) {

                            if ($.trim(data) === "OK") {

                                document.getElementById('id09').style.display = 'none';
                                document.getElementById('id07').style.display = 'block';

                                actualizaPrecio();

                                $("#pantalla").load(location.href + " #pantalla");

                                $('.toast').text("<?php echo $rowModify; ?>");

                                $('.toast').fadeIn(20).delay(2000).fadeOut(400);

                            } else {

                                $('.toast').text("<?php echo $modifyError; ?>");

                                $('.toast').fadeIn(400).delay(2000).fadeOut(400);

                            }

                        }

                    });

                });

                $('#add').click(function () {
                    loadPage();
                    comprobarMenusSinCompletar(0);
                });
            });
        </script>
        <?php include '../includes/importacionesUsuario.php'; ?>   
    </head>
    <body class="w3-light-grey">
        <div class="no-seleccionable">
            <?php cabeceraNavegacionUsuario($myList, 1, 1); ?>               
            <a class="w3-container w3-theme-l2 w3-padding-16 w3-btn-block"style="margin-top: 75px;" id="add"><?php echo $addProductsMay; ?></a>                
            <!--AQUI COMIENZA LA PRESENTACION-->
            <div class="w3-row w3-theme-l4 w3-large w3-margin-top">
                <div style="width:15%;float: left;padding-left: 10px;"><?php echo $unitTag; ?></div>
                <div style="width:65%;float: left;padding-left: 25px;"><?php echo $productTagMin; ?></div>
                <div style="width:20%;float: left;padding-left: 5px;"><?php echo $priceTagMin; ?></div>       
            </div>
            <div style="overflow: scroll;" id="pantalla">
                <?php if ($totalRows_Registros > 0) { ?>
                    <table class="w3-table w3-border w3-margin-top w3-large  w3-bordered w3-striped w3-hoverable">                
                        <?php if ($totalRows_RegMenus > 0) { ?>
                            <?php
                            do {
                                if (count(compararSubmenuMenuYSubmenuGrupoMenu($row_RegMenus['idMenuComandaTemp'], "comandaTemp_" . $_SESSION['id_usuario'] . "", $row_RegMenus['idGrupoMenuComandaTemp']))) {
                                    ?>                                        
                                    <tbody style="background-color: #F6A6C1">
                                    <?php } else { ?>
                                    <tbody> 
                                    <?php } ?>
                                    <tr id="linea" onclick="document.getElementById('id07').style.display = 'block';
                                                        lista_menu(<?php echo $row_RegMenus['idGrupoMenuComandaTemp']; ?>);
                                                        cantidadMod(1, <?php echo $row_RegMenus['id']; ?>);">
                                        <td>1</td>
                                        <td><?php echo recuperaNombrePrecioMenu($row_RegMenus['idMenuComandaTemp'], 1); ?></td>
                                        <td style="text-align: right;padding-right: 12px;"><?php echo number_format(recuperaNombrePrecioMenu($row_RegMenus['idMenuComandaTemp'], 2), 2); ?>&euro;</td>                     
                                    </tr>                        
                                </tbody>
                            <?php } while ($row_RegMenus = mysql_fetch_assoc($RegMenus)); ?>
                        <?php } if ($totalRows_RegComanda > 0) { ?>
                            <?php do { ?>
                                <tbody>
                                    <tr onclick="document.getElementById('id04').style.display = 'block';
                                                        cantidadMod(<?php echo $row_RegComanda['cantidadComandaTemp'] ?>, <?php echo $row_RegComanda['id']; ?>);
                                                        recuperarComentario();">
                                        <td><?php echo $row_RegComanda['cantidadComandaTemp']; ?></td>
                                        <td><?php echo recuperaNombreProducto($row_RegComanda['idProductoComandaTemp']); ?></td>
                                        <td style="text-align: right;padding-right: 12px;"><?php echo number_format($row_RegComanda['totalComandaTemp'], 2); ?>&euro;</td>                     
                                    </tr>                        
                                </tbody>
                                <?php
                            } while ($row_RegComanda = mysql_fetch_assoc($RegComanda));
                        }
                        ?>
                    </table>
                <?php } else { ?>
                    <h4 align="center"><?php echo $mensaje ?></h4>
                    <?php
                }
                if ($totalRows_Registros > 0) {
                    mysql_free_result($RegRegistros);
                }
                if ($totalRows_RegMenus > 0) {
                    mysql_free_result($RegMenus);
                }
                if ($totalRows_RegComanda > 0) {
                    mysql_free_result($RegComanda);
                }
                ?>
            </div> 
            <img id="cargar" src="../imagenes/UsuarioImages/page-loader.gif" style="display: none; margin: 35% 35%">
            <footer class="w3-container w3-theme-l2 w3-bottom w3-padding-16 w3-btn-block w3-margin-top" id="btnEnviarPedido">            
                <div class="w3-large" id="confirm" onclick="comprobarLista();"><?php echo $sendOrder; ?></div>           
            </footer>
            <div id="id04" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span onclick="document.getElementById('id04').style.display = 'none';
                                manejaComanda = ''"class="w3-closebtn">&times;</span>
                        <h4 id="elemento"><?php echo $actionsTag; ?></h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <b><?php echo $doYouWantDo; ?></b>
                        <div class="w3-center w3-margin-bottom w3-margin-top w3-padding-0">
                            <button class="w3-btn w3-indigo" style="width: 80%" id="" onclick="document.getElementById('id05').style.display = 'block';"><?php echo $modifyTagMay; ?></button>
                            <button class="w3-btn w3-margin-top w3-indigo" style="width: 80%" id="" onclick="document.getElementById('id06').style.display = 'block';"><?php echo $deletteTagMay; ?></button>
                        </div>
                    </div>
                </div>    
            </div>
            <div id="id05" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span onclick="document.getElementById('id05').style.display = 'none';
                                manejaComanda = ''"class="w3-closebtn">&times;</span>
                        <h4 id="elemento"><?php echo $modifyTagMay; ?></h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">                                                        
                        <div style="width: 100%;">                                     
                            <input id="textocomentario" class="w3-input w3-light-grey" type="text" placeholder= "<?php echo $anyComents; ?>" style="width: 80%;margin-left: 10%;">                                  
                        </div>
                        <div class="w3-center w3-margin-bottom w3-margin-top w3-padding-0"> 
                            <button class="w3-btn w3-indigo" style="width:15%;margin-right: 10px;" id="min">-</button>
                            <div class="w3-tag w3-yellow" style="width: 20%;height: 25px;" id="quantity">1</div>
                            <button class="w3-btn w3-indigo" style="width:15%;margin-left: 10px;" id="plus">+</button>
                        </div>
                        <div class="w3-row w3-margin-top">
                            <div class="w3-margin-top w3-margin-bottom">   
                                <button class="w3-btn w3-indigo" style="width: 80%" id="btnmodificar"><?php echo $aceptedTag; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div id="id06" class="w3-modal">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id06').style.display = 'none';" class="w3-closebtn">&times;</span>
                    <h3><?php echo $atentionTag; ?></h3>
                    <div id="prueba"></div>
                    <b><?php echo $deletteComandInfo; ?></b><br>
                    <b><?php echo $areYouSure; ?></b>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="eliminar"><?php echo $siTag; ?></button>
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id05').style.display = 'none';
                                manejaComanda = ''"><?php echo $nonTag; ?></button>                       
                    </div>
                </div>
            </div>
            <div id="id07" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span id="cierre" onclick="document.getElementById('id07').style.display = 'none';
                                manejaComanda = '';" class="w3-closebtn">&times;</span>
                        <h5 id="elemento"><?php echo $menuProducts; ?></h5>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <div class="w3-center w3-margin-bottom w3-margin-top w3-padding-0">
                            <table id="tablaMenu" class="w3-table w3-border w3-margin-top w3-large  w3-bordered w3-striped w3-hoverable"></table>
                            <div id="botonesid07" class="w3-center w3-margin-bottom w3-margin-top w3-padding-0"></div>
                        </div>
                    </div>
                </div>    
            </div>
            <div id="id08" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span onclick="document.getElementById('id08').style.display = 'none';
                                document.getElementById('id07').style.display = 'block';
                                manejaComanda = ''"class="w3-closebtn">&times;</span>
                        <h4 id="elemento"><?php echo $actionsTag; ?></h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <b><?php echo $doYouWantDo; ?></b>
                        <div class="w3-center w3-margin-bottom w3-margin-top w3-padding-0">
                            <button class="w3-btn w3-indigo" style="width: 80%" id="" onclick="document.getElementById('id09').style.display = 'block';
                                    document.getElementById('id08').style.display = 'none';"><?php echo $modifyComent; ?></button>
                            <button class="w3-btn w3-margin-top w3-indigo" style="width: 80%" id="" onclick="window.location = 'verProductosMenuUsuario.php?idComanda=' + registro;"><?php echo $modifyTagMay; ?></button>
                        </div>
                    </div>
                </div>    
            </div>
            <div id="id09" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span onclick="document.getElementById('id09').style.display = 'none';
                                document.getElementById('id08').style.display = 'block';
                                manejaComanda = ''"class="w3-closebtn">&times;</span>
                        <h4 id="elemento"><?php $modifyTagMay; ?></h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">                                                        
                        <div style="width: 100%;">                                     
                            <input id="textocomentarioComandaMenu" class="w3-input w3-light-grey" type="text" placeholder= "<?php $anyComents; ?>" style="width: 80%;margin-left: 10%;">                                  
                        </div>
                        <div class="w3-row w3-margin-top">
                            <div class="w3-margin-top w3-margin-bottom">   
                                <button class="w3-btn w3-indigo" style="width: 80%" id="btnmodificarComentarioComandaMenu"><?php echo $aceptedTag; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div id="id10" class="w3-modal">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id10').style.display = 'none';" class="w3-closebtn">&times;</span>
                    <h3><?php $atentionTag; ?></h3>
                    <div id="prueba"></div>
                    <b><?php echo $deletteCompletMenu; ?></b><br>
                    <b><?php echo $areYouSure; ?></b>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="btnEliminarMenu"><?php echo $yesTag; ?></button>
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id10').style.display = 'none';
                                document.getElementById('id07').style.display = 'block';
                                manejaComanda = ''"><?php $nonTag; ?></button>                       
                    </div>
                </div>
            </div>
            <div id="id11" class="w3-modal">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id11').style.display = 'none';
                            document.getElementById('id08').style.display = 'block';" class="w3-closebtn">&times;</span>
                    <h3><?php $atentionTag; ?></h3>
                    <div id="prueba"></div>
                    <b><?php echo $deletteRowMenu; ?></b><br>
                    <b><?php $areYouSure; ?></b>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="eliminarComandaMenu"><?php $yesTag; ?></button>
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id11').style.display = 'none';
                                manejaComanda = ''"><?php echo $nonTag; ?></button>                       
                    </div>
                </div>
            </div>
            <div id="id12" class="w3-modal">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id12').style.display = 'none';" class="w3-closebtn">&times;</span>
                    <h3><?php $atentionTag; ?></h3>
                    <div id="prueba"></div>
                    <b><?php echo $menuNoComplet; ?></b><br>
                    <b><?php echo $doYouWantCompletNow; ?></b>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="seguirMenu(0);"><?php echo $yesTag; ?></button>
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="irAcategorias();"><?php echo $nonTag; ?></button>                       
                    </div>
                </div>    
            </div>
            <div id="id13" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span onclick="cerrarPanelPagar();" class="w3-closebtn">&times;</span>
                        <h4 id="elemento"><?php echo $wayToPay; ?></h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">
                        <b><?php echo $howDoYouWantPay; ?></b>
                        <ul class="w3-ul w3-card-2"style="margin-top: 10px;">
                            <li id="pagoMetalico" style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="clickCobroMetalicoNotificacion();">                                 
                                <img src="../imagenes/UsuarioImages/efectivo.jpg" class="w3-left" style="width:90px;height:88px;">
                                <div class=" w3-left w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 10px;"><?php echo $metalicPay; ?></div>
                            </li>
                            <li id="pagoTarjeta" style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="clickCobroTargetaNotificacion();">                                 
                                <img src="../imagenes/UsuarioImages/credit-cards-256x256[1].jpg" class="w3-left" style="width:90px;height:88px;">
                                <div class=" w3-left w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 10px;"><?php echo $creditCard; ?></div>
                            </li>
                            <li id="autopago" style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="clickAutopago();">                                 
                                <img src="../imagenes/UsuarioImages/woocommerce-stripe-pagos-150x150[1].png" class="w3-left" style="width:90px;height:88px;">
                                <div class=" w3-left w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 10px;"><?php echo $autoayment; ?></div>
                            </li>
                        </ul>
                    </div>
                </div>    
            </div>
            <div id="id15" class="w3-modal" style="display: none">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id15').style.display = 'none';" class="w3-closebtn">&times;</span>
                    <h3><?php $atentionTag; ?></h3>
                    <div id="prueba"></div>
                    <b><?php echo $sentNtifyToWaiterPayment; ?></b><br>
                    <b><?php echo $confirmNotification; ?></b><br><br>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="confirmacionNotificacion(1);"><?php echo $yesTag; ?></button>
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id15').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                    </div>
                </div>    
            </div>
            <div id="id16" class="w3-modal" style="display: none">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id16').style.display = 'none';" class="w3-closebtn">&times;</span>
                    <h3><?php $atentionTag; ?></h3>
                    <div id="prueba"></div>
                    <b><?php echo $sentToWaiterNotifyPaymentCard; ?></b><br>
                    <b><?php echo $confirmNotification; ?></b><br><br>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="confirmacionNotificacion(2);"><?php echo $yesTag; ?></button>
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id16').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                    </div>
                </div>    
            </div>
            <div class='toast' style='display:none'>TOAST</div>
        </div>
    </body>
</html>
<?php ?>
