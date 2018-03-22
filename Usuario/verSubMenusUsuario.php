<?php
require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$esmenu = 0;
$idGrupo = 0;

$idMenu = filter_input(INPUT_GET, 'idMenu');
$nombreMenu = "Completar Menú";

if (filter_input(INPUT_GET, 'esmenu')) {
    $esmenu = filter_input(INPUT_GET, 'esmenu');
}
if (filter_input(INPUT_GET, 'idGrupo')) {
    $idGrupo = filter_input(INPUT_GET, 'idGrupo');
}

include '../includes/errorIdentificacionUsuario.php';

if (!$esmenu) {

    $nombreMenu = filter_input(INPUT_GET, 'nombreMenu');

    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegMenus = "SELECT * FROM submenus WHERE idMenuSubmenu=$idMenu AND estadoSubmenu=1";
    $RegMenus = mysql_query($query_RegMenus, $comcon_usuario) or die(mysql_error());
    $row_RegMenus = mysql_fetch_assoc($RegMenus);
    $totalRows_RegMenus = mysql_num_rows($RegMenus);
}
$registro = 1;
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
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

    </style>

    <script type="text/javascript">

        var esmenu = <?php echo $esmenu; ?>;        
        var width;
        var imagen;
        var height;
        var lista;
        var registro;
        var idGrupo = <?php echo $idGrupo; ?>;
        var idSubmenu;
        var nombreSubmenu;
        var idMenu;
        var idGrupoComanda;

        var idProductosMenu;
        var idProducto;
        var nombreProducto;
        var seleccion;

        var iteract = 0;

        var pedidoMenu = new Array();

        var arrayDatos = new Array();

        var idProductoPedir;

        var listaProductos = new Array();

        var registros = 0;

        var y;

        var comentario;
        
                //FUNCION PARA ELEGIR PRODUCTO
        function changeColor(x) {
            x.style.background = "#C6D5FF";
            //window.setTimeout("loadPage()", 500);
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

        function listado_menu(idSubmenu, registros) {

            var nombreProducto = new Array();
            var idProductoMenu = new Array();
            var idProducto = new Array();
            var idMenu = new Array();
            var imagen = new Array();
            var infoProducto = new Array();
            var alergenos = new Array();
            var nutricional = Array();


            var x = 0;

            $("#listaProductosMenu").empty();


            $.getJSON("consultarMenuUsuario.php?idSubmenu=" + idSubmenu, function (respuesta) {
                $.each(respuesta, function (id, comanda) {
                    $.each(comanda, function (idTabla, nombre) {

                        if (idTabla == 0) {
                            idProductoMenu[x] = nombre;
                        }
                        if (idTabla == 1) {
                            idProducto[x] = nombre;
                        }
                        if (idTabla == 2) {
                            idMenu[x] = nombre;
                        }
                        if (idTabla == 3) {
                            nombreProducto[x] = nombre;
                        }
                        if (idTabla == 4) {
                            imagen[x] = nombre;
                        }
                        if (idTabla == 5) {
                            infoProducto[x] = nombre;
                            if (!infoProducto[x])
                                infoProducto[x] = "<?php echo $notDisponible; ?>";
                        }
                        if (idTabla == 6) {
                            alergenos[x] = nombre;
                            if (!alergenos[x])
                                alergenos[x] = "<?php echo $notDisponible; ?>";
                        }
                        if (idTabla == 7) {
                            nutricional[x] = nombre;
                            if (!nutricional[x])
                                nutricional[x] = "<?php echo $notDisponible; ?>";
                        }
                    });

                    registro = "<li style=\"height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;\">" +
                            "<div onclick=\"changeColor(this);addSelection(" + registros + ",'" + nombreProducto[x] + "');" +
                            "newProducto (" + registros + "," + idProducto[x] + "," + idMenu[x] + "," + idSubmenu + ")" +
                            ";\" style=\"width:" + (310) + "px;\"><img src=\"../includes/imagen.php?id=" + imagen[x] + "&local=" + "<?php echo $_SESSION['establecimiento']; ?>" + 
                            "\" class=\"w3-left\" style=\"width:90px;height:88px;\">" +
                            " <div id=\"textoLista\" class=\"w3-medium letraBotones\" style=\"width:180px;padding-top: 30px;" +
                            "padding-left: 10px;margin-left: 100px;\"><div style=\"width:180px;\">" + nombreProducto[x] +
                            "</div></div></div><img src=\"../imagenes/UsuarioImages/Informacion.png\" class=\"w3-right\" " +
                            "style=\"width:45px;height:45px;margin-top:-30px;\" " +
                            "onclick=\"getInfoProducto('" + nombreProducto[x] + "','" + infoProducto[x] + "','" + alergenos[x] + "','" + nutricional[x] + "');" +
                            "document.getElementById('id03').style.display = 'block';\"></li>";

                    $("#listaProductosMenu").append(registro);

                    x++;



                });
            });
        }

        function getInfoProducto(nombreProducto, infoProducto, alergenos, nutricional) {

            $("#tituloInfo").empty();
            $("#infoProducto").empty();
            $("#nutricional").empty();
            $("#alergenos").empty();

            $("#tituloInfo").append(nombreProducto);
            $("#infoProducto").append(infoProducto);
            $("#nutricional").append(nutricional);
            $("#alergenos").append(alergenos);
        }

        function addComent() {
            listaProductos[this.y - 1].comentario = $('#textocomentarioComandaMenu').val();
            var comentario = "<button type=\"button\" style=\"height:25px;margin-left:35px;border:0px;\"id=\"boton" + this.y +
                    "\" onclick=\"document.getElementById('id09').style.display = 'block';setRegistros" +
                    "(" + this.y + ");recuperarComentario(" + this.y + ");\";><font color=\"#5A585A\">Modificar comentario</font></button>";
            $("#boton" + this.y).remove();
            $("#registroListado" + this.y).append(comentario);
        }

        function newProducto(x, idProducto, idMenu, idSubmenu) {

            var prod = new Producto(idProducto, idMenu, idSubmenu);
            listaProductos[x - 1] = prod;


        }

        function Producto(idProducto, idMenu, idSubmenu)
        {
            this.idProductoPedir = idProducto;
            this.idMenu = idMenu;
            this.idSubmenu = idSubmenu;
        }

        function getRegistros(registros) {
            this.registros = registros;
        }

        function sendArray() {
            var myArrClean = listaProductos.filter(Boolean);
            if (myArrClean.length < this.registros) {
                var faltantes = this.registros - myArrClean.length;

                var texto = "<?php echo $productoMayTag; ?>";
                if (faltantes > 1) {
                    texto = "<?php echo $productsMay; ?>";
                }
                $("#faltantes").empty();
                $("#faltantes").append("<?php echo $youMiss; ?>"  + faltantes + ' ' + texto + "<?php echo $toTheMenu; ?>");
                document.getElementById('id04').style.display = 'block';
            } else {
                var jsonString = JSON.stringify(listaProductos);
                $.ajax({
                    type: "POST",
                    url: "crearComandaTemporalUsuario.php",
                    data: {listaMenu: jsonString},
                    cache: false,
                    success: function (data) {
                        if ($.trim(data) === "OK") {
                            loadPage();
                            window.location = "listaTiempoRealUsuario.php";
                        }
                        if ($.trim(data) === "ERROR") {
                            $('.toast').text("<?php echo $errorToActual; ?>");
                            $('.toast').fadeIn(400).delay(2000).fadeOut(400);
                        }
                    }
                });
            }
        }

        function addNameSubmenu(nameSubmenu) {

            var nombreSubmenu = "<h4><?php echo $selectTag; ?>" + nameSubmenu + "</h4>";
            $("#listaProductosMenu").append(nombreSubmenu);

        }

        function setRegistros(y) {
            this.y = y;
        }

        function recuperarComentario(y) {
            $('#textocomentarioComandaMenu').val(listaProductos[y - 1].comentario);
        }
        function addSelection(registro, nombre) {

            seleccion = "<div id=\"seleccion" + registro +
                    "\" class=\"w3-centered w3-tiny letraBotones" +
                    "\"style=\"padding-top: 5px;padding-left: " +
                    "10px;margin-left: 25px;\">" + nombre + "</div></div>";

            var comentario = "<button type=\"button\" style=\"height:25px;margin-left:35px;border:0px;\"id=\"boton" + registro +
                    "\" onclick=\"document.getElementById('id09').style.display = 'block';setRegistros(" + registro + ");recuperarComentario(" + registro + ");\";><font color=\"#5A585A\"><?php echo $addComent; ?></font></button>";

            $("#seleccion" + registro).remove();
            $("#listado" + registro).append(seleccion);

            $("#textoRegistro" + registro).attr("style", "padding-top: 1px;padding-left: 10px;margin-left: 25px;");
            $("#boton" + registro).remove();
            $("#registroListado" + registro).append(comentario);

            var x = document.getElementById('Demo1');
            x.className = x.className.replace(" w3-show", "");
        }

        function myFunction(id) {
            var x = document.getElementById(id);
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }

        function listado_menu_Grupo() {

            $("#lista").empty();

            $.getJSON("consultaMenuFaltantesGrupoUsuario.php?idGrupo=" + idGrupo, function (respuesta) {
                $.each(respuesta, function (id, comanda) {
                    $.each(comanda, function (idTabla, nombre) {
                        if (idTabla == 0) {
                            idSubmenu = nombre;
                        }
                        if (idTabla == 1) {
                            nombreSubmenu = nombre;
                        }
                        if (idTabla == 2) {
                            idMenu = nombre;
                        }
                        if (idTabla == 3) {
                            idGrupoComanda = nombre;
                        }
                    });
                    registro = "<li style=\"height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;\" onclick=\"conection('verProductosMenuUsuario.php?idSubmenu=" + idSubmenu + "&nombreSubmenu=" + nombreSubmenu + "&idMenu=" + idMenu + "&idGrupoComanda=" + idGrupoComanda + "');changeColor(this);\"><div class=\"w3-centered w3-medium letraBotones\"style=\"padding-top: 30px;padding-left: 10px;margin-left: 25px;\">" + nombreSubmenu + "</div></li>";
                    $("#lista").append(registro);
                });
            });
        }

        var cabecera;

        if (esmenu) {
            if (idGrupo) {
                listado_menu_Grupo();
            } else {
                listado_menu();
            }
        }

        $(document).ready(function () {

            height = $(window).height();
            width = $(window).width();
            imagen = "height:" + ((height / 100) * 30) + "px;width: 100%;margin-top:0px;";
            $("#imagen").attr("style", imagen);
            lista = "overflow: scroll;height:" + (((height / 100) * 70) - 70 - 85) + "px;margin-top: 40px;";
            formulario = "overflow: scroll;max-height:" + (((height / 100) * 70) - 100 - 60) + "px;background-color: #F0F0F0;margin-bottom: 70px;opacity:1.0;";
            $("#listado").attr("style", lista);
            $("#lista").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
            $("#carta").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
            $("#productos").attr("style", "width:" + (width / 3) + "px;border:1px solid #cdcdcd;");
            $("#carta").css("border-bottom", "5px solid #3f51b5");
            $("#formulario").attr("style", formulario);
            $("#Demo1").css("margin-top", ((height / 100) * 30) + 55 + "px");
            $("#confirm").click(function () {
                sendArray();
            });
        });
    </script>
    <?php include '../includes/importacionesUsuario.php'; ?>    
    <body class="w3-light-grey">
        <div class="no-seleccionable">
            <div id="cabecera">
                <?php cabeceraNavegacionUsuario($menuLetter, 0, 0); ?>
            </div>
            <?php imagenNavegacionCarta("menu", 0) ?>
            <div id="elecciones">
                    <div id="productos" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickProductos();"><?php echo $productsMayTag; ?></div>
                    <div id="carta" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick=""><?php echo $menuLetter; ?></div>
                    <div id="lista" class="w3-card-4 w3-left w3-center w3-padding-top w3-padding-bottom w3-small letraBotones" onclick="clickMiLista()"><?php echo $myList; ?></div>                 
                </div>
            <ul id="listado" class="w3-ul w3-card-2"style="margin-top: 10px;">
                <?php
                if (!$esmenu) {
                    if ($totalRows_RegMenus) {
                        do {
                            ?>
                            <script>this.registros++;</script>
                            <div class="w3-accordion">
                                <div id="lista"> 
                                    <li id="registroListado<?php echo $registro; ?>" style="height: 90px">
                                        <div id="listado<?php echo $registro; ?>" style="height: 50px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="addNameSubmenu('<?php echo recuperarString($row_RegMenus['id_string']); ?>');
                                        listado_menu(<?php echo $row_RegMenus['idSubmenu']; ?>,<?php echo $registro; ?>);
                                        myFunction('Demo1');">
                                            <div id="textoRegistro<?php echo $registro; ?>" class="w3-centered w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 25px;"><?php echo recuperarString($row_RegMenus['id_string']); ?></div>                        
                                        </div>
                                    </li>
                                    <div id="Demo1" class="w3-accordion-content w3-container w3-bottom w3-modal">
                                        <header class="w3-container w3-light-grey">
                                            <span onclick="myFunction('Demo1');" class="w3-closebtn">&times;</span>
                                        </header>
                                        <form id ="formulario" class="w3-container w3-card-4" style="overflow: scroll;">
                                            <div id="listaProductosMenu"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>            
                            <?php
                            $registro++;
                        } while ($row_RegMenus = mysql_fetch_assoc($RegMenus));
                        ?>
                            <hr>
                    <?php }
                }
                if (!$esmenu && !$totalRows_RegMenus) {
                    ?>
                    <div class="centrar"><?php echo $noCategories; ?></div>
<?php } ?>   
            </ul>
            <footer class="w3-container w3-theme-l2 w3-bottom w3-padding-16 w3-btn-block w3-margin-top">            
                <div class="w3-large" id="confirm"><?php echo $order; ?></div>           
            </footer>
            <div id="id03" class="w3-modal w3-animate-opacity">
                <div class="w3-modal-content w3-card-8 w3-round-medium">
                    <header class="w3-container w3-yellow"> 
                        <span onclick="document.getElementById('id03').style.display = 'none'" 
                              class="w3-closebtn">&times;</span>
                        <h4 id ="tituloInfo"></h4>
                    </header>
                    <div class="w3-container w3-large w3-margin">
                        - <?php echo $descriptionTag; ?><br>
                        <div id="infoProducto"></div>
                        <hr style="margin-bottom: 5px;">
                        - <?php echo $nutritionalInformation; ?><br>
                        <div id="nutricional"></div>
                        <hr style="margin-bottom: 5px;">
                        - <?php echo $allergensInfomation; ?><br>
                        <div id="alergenos"></div>
                        <hr style="margin-bottom: 5px;">
                    </div>
                </div>
            </div>
            <div id="id04" class="w3-modal">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id04').style.display = 'none';" class="w3-closebtn">&times;</span>                
                    <h3><?php echo $atentionTag; ?></h3>
                    <b id="faltantes"></b><br><br>
                    <b><?php echo $completInformation; ?></b><br><br>
                </div>    
            </div>
            <div class='toast' style='display:none'>TOAST</div>
            <div id="id09" class="w3-modal">
                <div class="w3-modal-content w3-card-8 w3-round-medium w3-light-grey">
                    <header class="w3-container w3-theme-l2"> 
                        <span onclick="document.getElementById('id09').style.display = 'none';document.getElementById('id08').style.display = 'block';
                            manejaComanda = ''"class="w3-closebtn">&times;</span>
                        <h4 id="elemento"><?php echo $modifyTagMay; ?></h4>
                    </header>
                    <div class="w3-container w3-margin-top w3-padding-0 w3-center">                                                        
                        <div style="width: 100%;">                                     
                            <input id="textocomentarioComandaMenu" class="w3-input w3-light-grey" type="text" placeholder= "<?php echo $anyComents; ?>" style="width: 80%;margin-left: 10%;">                                  
                        </div>
                        <div class="w3-row w3-margin-top">
                            <div class="w3-margin-top w3-margin-bottom">   
                                <button class="w3-btn w3-indigo" style="width: 80%"onclick="addComent();document.getElementById('id09').style.display = 'none';"><?php echo $aceptedTag; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img id="cargar" src="../imagenes/UsuarioImages/page-loader.gif" style="display: none; margin: 35% 35%">
            <div class="toast" style="display: none"></div>
            <div id="id1" class="w3-modal" style="display: none">
                <div class="w3-container w3-section w3-yellow w3-center">
                    <span onclick="document.getElementById('id1').style.display = 'none';" class="w3-closebtn">&times;</span>
                    <h3>Atencion!</h3>
                    <div id="prueba"></div>
                    <b><?php echo $sentNotfificationToWaiter; ?></b><br>
                    <b><?php echo $confirmNotification; ?></b><br><br>
                    <div class="w3-margin-top w3-margin-bottom w3-center">
                        <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="confirmacionNotificacion();"><?php echo $yesTag; ?></button>
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
if ($esmenu == 0) {
    mysql_free_result($RegMenus);
}
?>