<?phprequire_once('../Connections/conexionComanderEnvCam.php');require_once('../includes/funcionesEnvCam.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "3,2,1";$MM_donotCheckaccess = "false";include '../includes/restriccionCam.php';mysqli_select_db($comcon, $database_comcon);$query_RegSubMenus = "SELECT * FROM submenus WHERE idMenuSubmenu=" . $_GET['idMenu'];$RegSubMenus = mysqli_query($comcon, $query_RegSubMenus) or die(mysqli_connect_error());$row_RegSubMenus = mysqli_fetch_assoc($RegSubMenus);$totalRows_RegSubMenus = mysqli_num_rows($RegSubMenus);header("Cache-Control: no-cache, must-revalidate"); // Evitar guardado en cache del cliente HTTP/1.1header("Pragma: no-cache"); // Evitar guardado en cache del cliente HTTP/1.0?><!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <title>Ver categorias</title>        <script type="text/javascript" src="jquery-mobile/jquery.js"></script>        <style type="text/css">            .loader {                position: fixed;                left: 0px;                top: 0px;                width: 100%;                height: 100%;                z-index: 9999;                background: url('page-loader.gif') 50% 50% no-repeat rgb(249,249,249);            }            .userselect {                -webkit-user-select: none;  /* Chrome all / Safari all */                -moz-user-select: none;     /* Firefox all */                -ms-user-select: none;      /* IE 10+ */                user-select: none;          /* Likely future */                  }            .toast {                width:200px;                height:20px;                height:auto;                position:absolute;                left:50%;                margin-left:-100px;                bottom:110px;                background-color: #383838;                color: #F0F0F0;                font-family: Calibri;                font-size: 20px;                padding:10px;                text-align:center;                border-radius: 5px;                -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);                -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);                box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);            }        </style>        <meta name="viewport" content="width=device-width, initial-scale=1">        <!--<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">-->        <link rel="stylesheet" href="../estilos/w3.css">        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">        <!--<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">-->        <link rel="stylesheet" href="..\font-awesome-4.7.0\css\font-awesome.min.css">        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">        <script src="http://www.w3schools.com/lib/w3data.js"></script>                <script type="text/javascript" src="js/location.js"></script>        <script type="text/javascript">            var mesa_global = "";            var idMenu = getParameterByName('idMenu');            var idPedido = getParameterByName('idPedido');            var objeto = "";            var objetoMenu = "";            var manejaPlato = "";            var completo = false;                        $(window).load(function () {                $("#progress").css("display","none");                $("#textonav").html("MENU");                                compruebaNotificaciones();                recuperaPlatosMenu(idMenu);            });                        function changeColor(x) {                x.style.background = "#C6D5FF";            }            function recuperaPlatosMenu(valor) {                var platosMenu = {'idMenu': valor};                $.ajax({                    type: "POST",                    url: "consultaMenus.php",                    data: platosMenu,                    success: function (data) {                        objetoMenu = JSON.parse(data);                    }                });            }            function crearPedido() {                var crea = {'idMesa': mesa_global};                $.ajax({                    type: "GET",                    url: "crearPedido.php",                    data: crea,                    success: function (idPedido2) {                        document.getElementById('id02').style.display = 'none';                        $('.toast').text('Pedido creado');                        $('.toast').fadeIn(400).delay(2000).fadeOut(400);                        idPedido = idPedido2;                        pedirMenu();                    }                });            }            function rellenaMenu(producto) {                document.getElementById('id01').style.display = 'none';                objetoMenu.platosMenu[manejaPlato].idProducto = producto;                objetoMenu.platosMenu[manejaPlato].coment = $('#textocomentario').val();                if (checkObject(objetoMenu)) {                    //ESTAN TODOS                    nombreProducto(objetoMenu.platosMenu[manejaPlato].idProducto);                    document.getElementById('btnpedir').style.opacity = "1";                    document.getElementById('btnpedir').style.cursor = "default";                    $('#btnpedir').css("background-color", "#3f51b5");                    $('#foot').css("background-color", "#3f51b5");                    completo = true;                } else {                    //AUN FALTAN                    nombreProducto(objetoMenu.platosMenu[manejaPlato].idProducto);                }            }                        function nombreProducto(idPro) {                var parametros = {'idProducto': idPro};                var nombre = "";                $.ajax({                    type: "POST",                    url: "consultaNombreProducto.php",                    data: parametros,                    success: function (data) {                        $('#prod_' + manejaPlato).html(data);                    }                });            }            function abrirSubMenus(idMenu, idSubMenu) {                var submenus = {'idMenu': idMenu, 'idSubmenu': idSubMenu};                $.ajax({                    type: "POST",                    url: "consultaSubMenus.php",                    data: submenus,                    success: function (data) {                        objeto = JSON.parse(data);                        document.getElementById('id01').style.display = 'block';                        $('#textocomentario').val('');                        w3DisplayData("idItem", objeto);                    }                });            }            function pedirMenu() {                if (completo) {                    if (idPedido !== "") {                        $("#progress").css("display","block");                        var idGrupoMenu = Math.floor(Math.random() * 10000);                        for (var a in objetoMenu.platosMenu) {                            var submenu = objetoMenu.platosMenu[a].idSubmenu;                            var product = objetoMenu.platosMenu[a].idProducto;                            var comentario = objetoMenu.platosMenu[a].coment;                            var linea = {'idPedido': idPedido, 'idMenu': idMenu, 'idSubmenu': submenu, 'idProducto': product, 'idGrupoMenu': idGrupoMenu, 'comentario': comentario};                            //alert (JSON.stringify(objetoMenu.platosMenu[a]));                            $.ajax({                                type: "POST",                                url: "crearLineaMenu.php",                                data: linea,                                success: function (data) {                                    $("#progress").css("display","none");                                    location.href = 'listaTiempoRealEnvCam.php?idPedido=' + idPedido;                                }                            });                        }                    } else {                        document.getElementById('id02').style.display = 'block';                    }                }            }            function cambio(idItem) {                var item = $(idItem).val();                var env = {'idMesa': item};                mesa_global = item;                $.ajax({                    type: "POST",                    url: "compruebaMesa.php",                    data: env,                    success: function (data) {                        if (data === "OK") {                            document.getElementById('id02').style.display = 'none';                            crearPedido();                            mesa_global = "";                        }                        if (data === "OC") {                            document.getElementById('id02').style.display = 'none';                            document.getElementById('id03').style.display = 'block';                        }                    }                });            }                        function abrirPedidos() {                var mes = {'idMesa':mesa_global};                $.ajax({                    type: "POST",                    url: "consultaPedidos.php",                    data: mes,                    success: function (data) {                        obj = JSON.parse(data);                        document.getElementById('id010').style.display = 'block';                        w3DisplayData("idl", obj);                    }                });            }                        function añadir(pedido){                idPedido = pedido;                pedirMenu();            }                        function getParameterByName(name) {                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),                        results = regex.exec(location.search);                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));            }            function checkObject(my_obj) {                var ret = true;                for (var a in my_obj.platosMenu) {                    if (my_obj.platosMenu[a].idProducto === "") {                        ret = false;                    }                }                return ret;            }            w3Http("prueba_mesas.php", function () {                if (this.readyState == 4 && this.status == 200) {                    var myObject = JSON.parse(this.responseText);                    w3DisplayData("idlist", myObject);                }            });            $(document).ready(function () {                $("#progress").css("display","block");                $('#nuevo').click(function () {                    crearPedido();                });                                $('#crear').click(function () {                    var idmesa = mesa_global;                    var mesa = {'idMesa': idmesa};                    $.ajax({                    type: "GET",                        url: "recuperaPedido.php",                        data: mesa,                        success: function(idPedido3) {                            document.getElementById('id03').style.display = 'none';                            if (idPedido3 === "MULT"){                                abrirPedidos();                            }else{                                idPedido = idPedido3;                                var pedido = {'idPedido':idPedido};                                $.ajax({                                    type: "POST",                                    url: "compruebaAutopedido.php",                                    data: pedido,                                    success: function (data) {                                        if (data === "OK"){                                            pedirMenu();                                        }else{                                            idPedido = "";                                            document.getElementById('id011').style.display = 'block';                                        }                                    }                                });                            }                                              }                    });                });            });        </script>    </head>    <body class="w3-light-grey">        <div class="w3-padding w3-display-middle" id="progress"><img src="page-loader.gif" width="100px" height="100px"></div>        <div class="userselect">            <?php include '../includes/menuNavegacionsinbuscar.html'; ?>            <br><br><br>            <div style="margin-top: 20px;">                <?php if ($totalRows_RegSubMenus > 0) { ?>                    <ul class="w3-ul">                        <?php $cont = 0;                        do { ?>                            <li class="w3-padding-medium" onclick="abrirSubMenus(<?php echo $row_RegSubMenus['idMenuSubmenu'] ?>, <?php echo $row_RegSubMenus['idSubmenu']; ?>);                                                    manejaPlato = <?php echo $cont; ?>" style="height:90px;padding-left:2px;">                                <div class="w3-xlarge w3-margin-top w3-padding-top"><?php echo utf8_encode($row_RegSubMenus['nombreSubmenu']); ?></div><div id="prod_<?php echo $cont; ?>"></div>                            </li>                            <hr style="margin: 0px">         <?php $cont ++;    } while ($row_RegSubMenus = mysqli_fetch_assoc($RegSubMenus)); ?>                    </ul>                <?php } else { ?>                    <div class="centrar">NO EXISTEN ELEMENTOS DE ESTA CATEGORIA</div><?php } ?>            </div>            <footer class="w3-container w3-bottom w3-padding-4" style="background-color: #8995d6;" id="foot">                <button class="w3-btn w3-disabled w3-xlarge" style="width: 100%;background-color: #8995d6;" id="btnpedir" onclick="pedirMenu();">PEDIR MENU</button>            </footer>            <div id="id01" class="w3-modal" style="top: 0px;">                <div class="w3-modal-content w3-card-8 w3-round-medium"  style="top: 120px;">                    <header style="padding-right: 10px;">                         <span onclick="document.getElementById('id01').style.display = 'none'" class="w3-closebtn">&times;</span>                    </header>                    <div class="w3-large">                        <ul id="idItem" class="w3-ul">                            <li class="w3-theme-l2">SELECCIONA PRODUCTO</li>                            <li class="w3-hover-light-blue" w3-repeat="clientes" id="{{idProducto}}" value="{{idProducto}}" onclick="javascript:var pr={{idProducto}};rellenaMenu(pr)" style="height:60px;"S>                                <img src="../includes/imagen.php?id={{imagenProducto}}&local=<?php echo $_SESSION['idEstablecimiento']; ?>" class="w3-left w3-margin-right" style="width:50px;height:50px;">                                {{nombreProducto}}                            </li>                        </ul>                        <div class="w3-margin w3-padding-left w3-padding-right">                            <input class="w3-input w3-light-grey" type="text" placeholder="¿Algun comentario?" id="textocomentario">                        </div>                    </div>                    <footer class="w3-container w3-theme-l2" style="height: 3px;"></footer>                </div>            </div>            <div id="id02" class="w3-modal w3-animate-opacity">                <div class="w3-modal-content w3-card-8 w3-round-medium">                    <header class="w3-container w3-theme-l2">                        <span onclick="document.getElementById('id02').style.display = 'none'"                              class="w3-closebtn">&times;</span>                        <h4>SELECCIONAR MESA</h4>                    </header>                    <div class="w3-container w3-large w3-margin" style="height: 240px;overflow: scroll;">                        <ul id="idlist" class="w3-ul w3-card-4">                            <li class="w3-hover-light-blue" w3-repeat="clientes" id="{{idMesa}}" value="{{idMesa}}" onclick="cambio(this);mesa_global={{idMesa}};">MESA {{nombreMesa}}</li>                        </ul>                    </div>                    <footer class="w3-container w3-theme-l2" style="height: 3px;"></footer>                </div>            </div>            <div id="id03" class="w3-modal">                <div class="w3-container w3-section w3-yellow">                    <span onclick="document.getElementById('id03').style.display = 'none'" class="w3-closebtn">&times;</span>                    <h3>Atencion!</h3>                    Upss, parece ser que esta mesa está ocupada<br>¿Que quieres hacer?                    <div class="w3-margin-top w3-margin-bottom w3-center">                        <button class="w3-btn w3-indigo w3-small" style="width:45%;margin-right: 5px;" id="crear">AÑADIR A PEDIDO</button>                        <button class="w3-btn w3-indigo w3-small" style="width:45%;" id="nuevo">NUEVO PEDIDO</button>                    </div>                </div>            </div>                        <div id="id010" class="w3-modal">                <div class="w3-modal-content w3-card-8 w3-round-medium" style="width:70%;">                    <header class="w3-container w3-theme-l2">                        <span onclick="document.getElementById('id010').style.display = 'none'"                              class="w3-closebtn">&times;</span>                        <h4>SELECCIONAR PEDIDO</h4>                    </header>                    <div class="w3-container w3-large w3-margin" style="height: 240px;overflow: scroll;">                        <ul id="idl" class="w3-ul w3-card-4">                            <li class="w3-hover-light-blue" w3-repeat="clientes" id="{{idPedido}}" value="{{idPedido}}" onclick="añadir({{idPedido}});">PEDIDO Nº {{idPedido}}</li>                        </ul>                    </div>                    <footer class="w3-container w3-theme-l2" style="height: 3px;"></footer>                </div>            </div>                        <div id="id011" class="w3-modal">                <div class="w3-container w3-section w3-yellow">                <span onclick="document.getElementById('id011').style.display = 'none'"                               class="w3-closebtn">&times;</span>                    <h3>¡ATENCION!</h3>                    NO SE PUEDE AÑADIR A UN PEDIDO YA COBRADO                    <div class="w3-margin-top w3-margin-bottom w3-center">                        <button class="w3-btn w3-indigo w3-small" style="width:45%;" onclick="document.getElementById('id011').style.display = 'none'">CERRAR</button>                    </div>                </div>            </div>            <div class='toast' style='display:none'>TOAST</div>        </div>    </body></html><?phpmysqli_free_result($RegSubMenus);?>