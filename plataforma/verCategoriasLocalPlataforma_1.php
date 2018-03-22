<?php
//require_once('../includes/funcionesPlataforma.php');

//DETECTAMOS EL IDIOMA Y EN FUNCION DE ELLO INCLUIMOS UN IDIOMA
$lengua = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2); 
if($lengua == "es" || $lengua == "en" || $lengua == "ca" || $lengua == "de" || $lengua == "fr" || $lengua == "it" || $lengua == "ru" || $lengua == "zh" || $lengua == "ja" || $lengua == "ar"){
    $lengua = $lengua;
} else {
    $lengua = "en";
}
    include "../strings/".$lengua.".php";

//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$id = filter_input(INPUT_GET, 'id');

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;
$idCat;
$imagen;
$nombre;
$precio;

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "cristian";
$password_comcon = "comander";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = '$id'";
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);

//SETEAMOS VARIABLES PARA CONECTAR CON LA BD DEL ESTABLECIMIENTO
    do{
    $database_establecimiento = $row_comprobarUsuario['name_database'];
    $username_establecimiento = $row_comprobarUsuario['username_database'];
    $password_establecimiento = $row_comprobarUsuario['password_database'];
    }while($row_comprobarUsuario = mysql_fetch_assoc($comprobarUsuario_query));
    
//CREAMOS LA VARIABLE DE CONEXION
$comcon_establecimiento = mysql_connect($hostname_comcon, $username_establecimiento, $password_establecimiento);

//SELECCIONAMOS LA BD
mysql_select_db($database_establecimiento, $comcon_establecimiento);

//HACEMOS LA CONSULTA DE PRODUCTOS
$query_RegProducto = "SELECT * FROM subcategorias WHERE estadoSubcategoria=1";
$RegProducto = mysql_query($query_RegProducto, $comcon_establecimiento) or die(mysql_error());
$row_RegProducto = mysql_fetch_assoc($RegProducto);
$totalRows_RegProducto = mysql_num_rows($RegProducto);

function recuperarString($idString){
                global $database_establecimiento, $comcon_establecimiento, $lengua;
                mysql_select_db($database_establecimiento, $comcon_establecimiento);
                $query_consultaFuncion = sprintf("SELECT * FROM strings WHERE id = %s",
                $idString);
                $consultaFuncion = mysql_query($query_consultaFuncion, $comcon_establecimiento);
                $row_consultaFuncion = mysql_fetch_assoc($consultaFuncion);
                switch ($lengua){
                    case "es":
                        $string = $row_consultaFuncion['spanish'];
                        break;
                    case "en":
                        $string = $row_consultaFuncion['ingles'];
                        break;
                    case "ca":
                        $string = $row_consultaFuncion['catalan'];
                        break;
                    case "de":
                        $string = $row_consultaFuncion['aleman'];
                        break;
                    case "fr":
                        $string = $row_consultaFuncion['frances'];
                        break;
                    case "it":
                        $string = $row_consultaFuncion['italiano'];
                        break;
                    case "ru":
                        $string = $row_consultaFuncion['ruso'];
                        break;
                    case "zh":
                        $string = $row_consultaFuncion['chino'];
                        break;
                    case "ja":
                        $string = $row_consultaFuncion['japones'];
                        break;
                    case "ar":
                        $string = $row_consultaFuncion['arabe'];
                        break;
                    default :
                        $string = $row_consultaFuncion['ingles'];
                }
                return $string;
	
	}

?>

<!DOCTYPE html>
<html>
    <head>  
        <title>Ver Local</title>
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
                width = $(window).width();
                height = $(window).height();
                imagen = "height:" + ((height / 100) * 25) + "px;width: 100%;margin-top:0px;";
                $("#imagen").attr("style", imagen);
                lista = "height:" + (((height / 100) * 100) - 120) + "px;padding-top:80px;width:90%;margin-left:5%;max-height:" + (((height / 100) * 100) - 160) + "px;overflow:auto;";
                $("#listado").attr("style", lista);
                $("#carta").css("border-bottom", "5px solid #3f51b5");
                var marginTop = ((height - 129 - (((height - 45) / 100) * 37) * 2) / 3);
                var styleTitulo = "width:25px;height: 40px;margin-left:" + ((width - 280) / 2) + "px;";
                $("#titulo").attr("style", styleTitulo);
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
            
        </script>
        <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
        <?php include '../includes/importacionesUsuario.php'; ?>

    <body class="w3-theme-l1">
        <header class="w3-card-4 w3-theme header w3-padding-large" style="height: 100px;">
            <div class ="w3-margin" style="float: left;"><img src="../imagenes/mano.png" class="w3-round-small" alt="Norway" style="width:40px;height: 40px;"></div>
            <div class="w3-xxxlarge" style="width: 50%;float: left;">COMANDER</div>            
        </header>
        <div id="contenido" class="w3-light-grey" style="width:90%; margin-left:5%" align="center">                
                <div id="elecciones" style="width:100%; margin-top:15px;" align="center">
                    <div id="productos" style="width:33.3%;" class="w3-hover-grey w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="window.location.href = 'verLocalPlataforma.php?id=' + <?php echo filter_input(INPUT_GET, 'id'); ?>"><?php echo $productsMayTag; ?></div>
                    <div id="carta" style="width:33.3%;" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick=""><?php echo $menuLetter; ?></div>
                    <div id="lista" style="width:33.3%;" class="w3-hover-grey w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="window.location.href = 'verInfoLocalPlataforma.php?id=' + <?php echo filter_input(INPUT_GET, 'id'); ?>"><?php echo $informationTag; ?></div>                 
                </div>
                <div id="listado" class="" style="width:50%;margin-top: 10px;">
                    <div style="width: 30%;padding: 0px;margin:14px;float: left"></div>
                    <div class="w3-card-16 w3-hover-grey" style=" width: 30%; height: 150px;float: left;margin-left:14px;margin-right:35%;"onclick="window.location.href='verMenusLocalPlataforma.php?id=<?php echo $id; ?>'">                                  
                        <img src="../archivos/ImagenesAdd/menu.jpg" class="w3-left" style="width:50%;height:148px;">
                        <div class="w3-medium"style="padding-top: 0px;padding-left: 10px;height: 150px;">
                            <p style="padding-top: 50px;"><strong><?php echo $menusBidTag ?></strong></p>                                
                        </div>
                    </div>
                    <br>                    
                    <?php do { ?>
                    <div class="w3-card-16 w3-hover-grey" style="height: 150px;width: 30%;padding: 0px;margin:14px;float: left" onclick="window.location.href='verProductosCartaPlataforma.php?idSubcategoria=<?php echo $row_RegProducto['idSubcategoria']; ?>&id=<?php echo $id; ?>'">                                 
                        <img src="../includes/imagen.php?id=<?php echo $row_RegProducto['id_imagen']."&local=".$id ?>" class="w3-left" style="width:50%;height:148px;">
                        <div class="w3-medium"style="padding-top: 0px;padding-left: 10px;height: 150px;">
                            <p style="padding-top: 50px;"><strong><?php echo recuperarString($row_RegProducto['id_string']); ?></strong></p>                               
                        </div>
                    </div>
                    <?php } while ($row_RegProducto = mysql_fetch_assoc($RegProducto)); ?>
                    <hr>
                </div>
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
