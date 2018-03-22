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
$idSubcategoria = filter_input(INPUT_GET, 'idSubcategoria');

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
$query_RegProducto = "SELECT * FROM productos WHERE idSubcategoriaProducto='$idSubcategoria'";  
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
                lista = "overflow-y: scroll;height:" + (((height / 100) * 100) - 170) + "px;padding-top:30px;width:" + ((width/100)*80) + "px;margin-left:" + ((width/100)*5) + "px;";
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
                    <div id="carta" style="width:33.3%;" class="w3-hover-grey w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="window.location.href = 'verCategoriasLocalPlataforma.php?id=' + <?php echo filter_input(INPUT_GET, 'id'); ?>"><?php echo $menuLetter; ?></div>
                    <div id="lista" style="width:33.3%;" class="w3-hover-grey w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="window.location.href = 'verInfoLocalPlataforma.php?id=' + <?php echo filter_input(INPUT_GET, 'id'); ?>"><?php echo $informationTag; ?></div>                 
                </div>
                <div id="listado" class="" style="width:50%;margin-top: 10px;">
                    <?php do { ?>
                    <div class="w3-card-16 w3-hover-grey" style="height: 150px;width: 30%;padding: 0px;margin:12px;float: left" onclick="document.getElementById('<?php echo $row_RegProducto['idProducto']; ?>').style.display = 'block';">                                 
                            <img src="../includes/imagen.php?id=<?php echo $row_RegProducto['id_imagen']."&local=".$id ?>" class="w3-left" style="width:50%;height:148px;">
                            <div class="w3-medium"style="padding-top: 30px;padding-left: 10px;height: 150px;">
                                <p><strong><?php echo recuperarString($row_RegProducto['id_string']); ?></strong></p>
                                <p><?php echo number_format($row_RegProducto['precioVentaProducto'], 2); ?>&euro;</p>                                
                            </div>
                        </div>
                        <div id="<?php echo $row_RegProducto['idProducto']; ?>" class="w3-modal">
                            <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                                <header class="w3-container w3-theme-l2"> 
                                    <span id="cierre" onclick="document.getElementById('<?php echo $row_RegProducto['idProducto']; ?>').style.display = 'none';" class="w3-closebtn">&times;</span>
                                    <h5><?php echo recuperarString($row_RegProducto['id_string']); ?></h5>
                                </header>
                                <div class="w3-container w3-margin-top w3-padding-0 w3-center">
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
                        </div>   
                    <?php } while ($row_RegProducto = mysql_fetch_assoc($RegProducto)); ?>
                        <hr>
                </div>
            </div>
        </div>
        <div class="toast" style="display: none"></div>             
    </body>
</html>
