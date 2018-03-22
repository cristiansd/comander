<?php
require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegSubCategorias = "SELECT * FROM subcategorias WHERE estadoSubcategoria=1 AND idCategoriaSubcategoria=" . $_GET['idCategoria'];
$RegSubCategorias = mysql_query($query_RegSubCategorias, $comcon_usuario) or die(mysql_error());
$row_RegSubCategorias = mysql_fetch_assoc($RegSubCategorias);
$totalRows_RegSubCategorias = mysql_num_rows($RegSubCategorias);
?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
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

        var imagen;
        var height;
        var lista;
        var width;
        $(document).ready(function () {
            height = $(window).height();
            width = $(window).width();
            imagen = "height:" + ((height / 100) * 30) + "px;width: 100%;margin-top:0px;";
            $("#imagen").attr("style", imagen);
            lista = "overflow: scroll;height:" + (((height / 100) * 70) - 70) + "px;margin-top: 40px;";
            $("#listado").attr("style", lista);
            $("#lista").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
            $("#carta").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
            $("#productos").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
            $("#carta").css("border-bottom", "5px solid #3f51b5");
        });

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
    <?php include '../includes/importacionesUsuario.php'; ?>    
    <body class="w3-light-grey">
        <div class="no-seleccionable">
            <?php
            cabeceraNavegacionUsuario($menuLetter, 0, 0);
            if ($totalRows_RegSubCategorias > 0) {
                imagenNavegacionCarta($_GET['imagen'], 1)
                ?> 
                <div id="elecciones">
                    <div id="productos" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickProductos();"><?php echo $productsMayTag; ?></div>
                    <div id="carta" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick=""><?php echo $menuLetter; ?></div>
                    <div id="lista" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickMiLista()"><?php echo $myList; ?></div>                 
                </div>
                <ul id ="listado" class="w3-ul w3-card-2"style="margin-top: 10px;">
                    <?php do { ?>
                        <li style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="conection('verProductosUsuario.php?idSubcategoria=<?php echo $row_RegSubCategorias['idSubcategoria'] . "&nombre=" . utf8_encode($row_RegSubCategorias['nombreSubcategoria']) . "&imagen=" . $row_RegSubCategorias['id_imagen']; ?>');
                                        changeColor(this);">                                 
                            <img src="../includes/imagen.php?id=<?php echo$row_RegSubCategorias['id_imagen']."&local=".$_SESSION['establecimiento']; ?>" class="w3-left" style="width:90px;height:88px;">
                            <div class="w3-centered w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 100px;"><?php echo recuperarString($row_RegSubCategorias['id_string']); ?></div>
                        </li>
                    <?php } while ($row_RegSubCategorias = mysql_fetch_assoc($RegSubCategorias)); ?>
                        <hr>
                <?php } else { ?>
                    <div class="centrar"><?php echo $noCategories; ?></div>
                <?php } ?>   
            </ul>
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
        </div>
    </body>
</html>
<?php
mysql_free_result($RegSubCategorias);
?>