<?php
//require_once('../includes/funcionesPlataforma.php');

//DETECTAMOS EL IDIOMA Y EN FUNCION DE ELLO INCLUIMOS UN IDIOMA
$lengua = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2); 
if($lengua == "es" || $lengua == "en" || $lengua == "ca"){
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

//RECUPERAMOS LA DEFINICION DEL LOCAL EN FUNCION DEL IDIOMA
switch ($lengua){
    case 'es':
        $definicion = $row_comprobarUsuario['definicionEstablecimiento'];
        break;
    case 'ca':
        $definicion = $row_comprobarUsuario['definicionEstablecimientoCa'];
        break;
    case 'en':
        $definicion = $row_comprobarUsuario['definicionEstablecimientoEn'];
        break;
    default:
        $definicion = $row_comprobarUsuario['definicionEstablecimientoEn'];
}

//RECUPERAMOS LOS DIAS DE LA SEMANA Y SETEAMOS DEPENDIENDO SI ESTA CERRADO O NO
$apertura_monday = $row_comprobarUsuario['apertura_Monday'];
$cierre_monday = $row_comprobarUsuario['cierre_Monday'];
$apertura_Tuesday = $row_comprobarUsuario['apertura_Tuesday'];
$cierre_Tuesday = $row_comprobarUsuario['cierre_Tuesday'];
$apertura_Wednesday = $row_comprobarUsuario['apertura_Wednesday'];
$cierre_Wednesday = $row_comprobarUsuario['cierre_Wednesday'];
$apertura_Thursday = $row_comprobarUsuario['apertura_Thursday'];
$cierre_Thursday = $row_comprobarUsuario['cierre_Thursday'];
$apertura_Friday = $row_comprobarUsuario['apertura_Friday'];
$cierre_Friday = $row_comprobarUsuario['cierre_Friday'];
$apertura_Saturday = $row_comprobarUsuario['apertura_Saturday'];
$cierre_Saturday = $row_comprobarUsuario['cierre_Saturday'];
$apertura_Sunday= $row_comprobarUsuario['apertura_Sunday'];
$cierre_Sunday = $row_comprobarUsuario['cierre_Sunday'];

$horario_Monday = $de.$apertura_monday.$hasta.$cierre_monday;
$horario_Tuesday = $de.$apertura_Tuesday.$hasta.$cierre_Tuesday;
$horario_Wednesday = $de.$apertura_Wednesday.$hasta.$cierre_Wednesday;
$horario_Thursday = $de.$apertura_Thursday.$hasta.$cierre_Thursday;
$horario_Friday = $de.$apertura_Friday.$hasta.$cierre_Friday;
$horario_Saturday = $de.$apertura_Saturday.$hasta.$cierre_Saturday;
$horario_Sunday = $de.$apertura_Sunday.$hasta.$cierre_Sunday;

if ($row_comprobarUsuario['apertura_Monday'] == null){
    $horario_Monday = $cerrado;
}
if ($row_comprobarUsuario['apertura_Tuesday'] == null){
    $horario_Tuesday = $cerrado;
}
if ($row_comprobarUsuario['apertura_Wednesday'] == null){
    $horario_Wednesday = $cerrado;
}
if ($row_comprobarUsuario['apertura_Thursday'] == null){
    $horario_Thursday = $cerrado;
}
if ($row_comprobarUsuario['apertura_Friday'] == null){
    $horario_Friday = $cerrado;
}
if ($row_comprobarUsuario['apertura_Saturday'] == null){
    $horario_Saturday = $cerrado;
}
if ($row_comprobarUsuario['apertura_Sunday'] == null){
    $horario_Sunday = $cerrado;
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
            .ec-stars-wrapper {
	/* Espacio entre los inline-block (los hijos, los `a`) 
	   http://ksesocss.blogspot.com/2012/03/display-inline-block-y-sus-empeno-en.html */
	font-size: 0;
	/* Podríamos quitarlo, 
		pero de esta manera (siempre que no le demos padding), 
		sólo aplicará la regla .ec-stars-wrapper:hover a cuando
		también se esté haciendo hover a alguna estrella */
	display: inline-block;
        }
        .ec-stars-wrapper a {
                text-decoration: none;
                display: inline-block;
                /* Volver a dar tamaño al texto */
                font-size: 32px;
                font-size: 2rem;

                color: #888;
        }

        .ec-stars-wrapper:hover a {
                color: rgb(39, 130, 228);
        }
        /*
         * El selector de hijo, es necesario para aumentar la especifidad
         */
        .ec-stars-wrapper > a:hover ~ a {
                color: #888;
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
                lista = "overflow:auto;height:" + (((height / 100) * 100) - 170) + "px;padding-top:30px;width:" + ((width/100)*80) + "px;margin-left:" + ((width/100)*1) + "px;";
                $("#listado").attr("style", lista);
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                var marginTop = ((height - 129 - (((height - 45) / 100) * 37) * 2) / 3);
                var styleTitulo = "width:25px;height: 40px;margin-left:" + ((width - 280) / 2) + "px;";
                $("#titulo").attr("style", styleTitulo);
                puntuacion();
                remarcarDia();
            });
            
            //FUNCION PARA ESTABLECER LA PUNTUACION
            function puntuacion(){
                var puntuacion = <?php echo $row_comprobarUsuario['puntuacion']; ?>;
                var restante = 5 - puntuacion;
                var estrellasAmarillas = '<a style="color:#d2be0e">&#9733;</a>';
                var estrellasNegras = '<a style="color:#bdbdc0">&#9733;</a>';
                for (var i = 0; i < puntuacion; i++) {
                    $("#puntuacion").append(estrellasAmarillas);
                }
                for (var a = 0; a < restante; a++) {
                    $("#puntuacion").append(estrellasNegras);
                } 
            }

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
            
            //FUNCION PARA REMARCAR EL DIA CON EL HORARIO EN NEGRITA
            function remarcarDia() {
                var now = new Date();
                var dia = now.getDay();
                $("#registro_" + dia).attr("style", "font-weight:bold");
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
                    <div id="lista" style="width:33.3%;" class=" w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick=""><?php echo $informationTag; ?></div>                 
                </div>
                <div id="listado" class="" style="width:50%;margin-top: 10px;">
                    <div style='padding-bottom: 10px;'><b><?php echo $row_comprobarUsuario['nombre_establecimiento']; ?></b></div>
                    <div style="height: 40%;margin-top:10px;">
                        <img src="../includes/imagenEstablecimientos.php?id=<?php echo $id; ?>" height="100%" width="90%"/>                            
                    </div>
                    <br>
                    <div>
                        <a><?php echo $row_comprobarUsuario['direction']; ?></a>
                    </div>
                    <div id="puntuacion" class="ec-stars-wrapper" style=""></div>
                    <div><?php echo "(".$row_comprobarUsuario['cant_comentarios'].") ".$comentarios; ?></div>
                    <br>
                    <div><?php echo $definicion; ?></div>
                    <br>
                    <div id="registro_1"><?php echo $scheduleMonday.$horario_Monday;?></div>
                    <div id="registro_2"><?php echo $scheduleTuesday.$horario_Tuesday;?></div>
                    <div id="registro_3"><?php echo $scheduleWednesday.$horario_Wednesday;?></div>
                    <div id="registro_4"><?php echo $scheduleThursday.$horario_Thursday;?></div>
                    <div id="registro_5"><?php echo $scheduleFriday.$horario_Friday;?></div>
                    <div id="registro_6"><?php echo $scheduleSaturday.$horario_Saturday;?></div>
                    <div id="registro_7"><?php echo $scheduleSunday.$horario_Sunday;?></div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="toast" style="display: none"></div>             
    </body>
</html>
