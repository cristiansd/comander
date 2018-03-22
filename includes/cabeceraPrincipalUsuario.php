<script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
<script type="text/javascript" src="../includes/sendPush.js"></script>
<script type="text/javascript" src="../includes/sendPushCamarero.js"></script>
<script type="text/javascript" src="../includes/sendPushSinPedido.js"></script>
<script type="text/javascript" src="../includes/sendPushCamareroSinPedido.js"></script>
<script type="text/javascript" src="../includes/pedirPagar.js"></script>
<script type="text/javascript">
    
//FUNCION PARA DESPLEGAR EL DROP DE IDIOMAS
            function selectLanguage() {
                var x = document.getElementById("lenguajes");
                if (x.className.indexOf("w3-show") == -1) 
                    x.className += " w3-show";
                else 
                    x.className = x.className.replace(" w3-show", "");
                }
                
//FUNCION PARA SELECCIONAR IDIOMA
            function seleccionarIdioma(idioma){ 
                var direction = idioma + ".html";
                    window.location.href = direction;
            }
</script>
<nav class="w3-sidenav w3-animate-left w3-card-2 w3-white" style="display:none" id="mySidenav">
    <a href="javascript:void(0)" onclick="w3_close()"accesskey=""class="w3-closenav w3-large">Close &times;</a>
    <a href="prueba3.php"><?php echo $closeSessionMin; ?></a>
</nav>
<header id="header" class="w3-container w3-card-4 w3-theme header w3-top" style="height:65px;">   
    <h3 style="margin-top: 10px;">
        <i id="iconoIzqHeader" style="margin-top: 4px;" class=" w3-left" onclick="openLeftMenu();">
            <img id="imagenIconoIzq" src="../imagenes/UsuarioImages/menu.png" alt="Norway">
        </i>
        <img id="titulo" src="../imagenes/UsuarioImages/mano.png" class="w3-round-small w3-centered" alt="Norway">
        <a style="width: 120px;">Comander</a>
        <i class=" w3-right w3-margin-left" style="margin-top: 4px;" onclick="clickBuscar();">
            <img src="../imagenes/UsuarioImages/buscar.png" alt="Norway">
        </i>
        <i class=" w3-right w3-margin-right" style="margin-top: 4px;" onclick="clickAyudaNotificacion();">
            <img src="../imagenes/UsuarioImages/notificacion.png" alt="Norway">
        </i>
    </h3>
</header>
<nav class="w3-sidenav w3-animate-left w3-card-2 w3-white" style="display:none" id="leftMenu">
    <div  onclick="closeLeftMenu()" class="w3-closenav w3-indigo w3-large">
        <a style="width:200px;"><?php echo $userPanelTag; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</a>
    </div>
    <a id="usuarioLeft" class="w3-padding-top" style="background-color: grey">
        <img id="userImgLeft" src="../imagenes/UsuarioImages/usuario.png"/>
        <?php echo $_SESSION['MM_Username']; ?>
    </a>
    <div id="lenguas" class="w3-dropdown-click">
                    <div onclick="selectLanguage()" style="margin-top:10px;margin-left:5px;">
                        <img id="languageIcon" style="float:left;margin-left:15px;margin-top:6px;" src="<?php echo "../imagenes/UsuarioImages/".$_SESSION['idioma'].".png"; ?>"/>                         
                        <a style="float: left;margin-left:5px;" id="lenguaje"><?php echo $idioma; ?></a>
                    </div>
                    <div id="lenguajes" class="w3-dropdown-content w3-border" style="margin-top: 30px;">
                        <div onclick="seleccionarIdioma('es')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/es.png"/>                         
                            <a style="float: left;margin-left:5px;">Idioma</a>
                        </div>
                        <br>
                        <div onclick="seleccionarIdioma('ca')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/ca.png"/>                         
                            <a style="float: left;margin-left:5px;">Idioma</a>
                        </div>
                        <br>
                        <div onclick="seleccionarIdioma('en')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/en.png"/>                         
                            <a style="float: left;margin-left:5px;">Language</a>
                        </div>
                        <div onclick="seleccionarIdioma('de')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/de.png"/>                         
                            <a style="float: left;margin-left:5px;">Sprache</a>
                        </div>
                        <div onclick="seleccionarIdioma('fr')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/fr.png"/>                         
                            <a style="float: left;margin-left:5px;">Langue</a>
                        </div>
                        <div onclick="seleccionarIdioma('it')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/it.png"/>                         
                            <a style="float: left;margin-left:5px;">Lingua</a>
                        </div>
                        <div onclick="seleccionarIdioma('ru')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/ru.png"/>                         
                            <a style="float: left;margin-left:5px;">язык</a>
                        </div>
                        <div onclick="seleccionarIdioma('zh')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/zh.png"/>                         
                            <a style="float: left;margin-left:5px;">語言</a>
                        </div>
                        <div onclick="seleccionarIdioma('ja')" style="margin-top:10px;margin-left:5px;float:left;">
                            <img style="float:left;margin-left:15px;margin-top:6px;" src="../imagenes/UsuarioImages/ja.png"/>                         
                            <a style="float: left;margin-left:5px;">言語</a>
                        </div>
                    </div>
                 </div>
    <div class="w3-padding-left w3-margin-top" onclick="clickPedidos()">
        <div id="pedidoLeft">
            <img src="../imagenes/UsuarioImages/pedidos.png"/>
            <?php echo $orderHistory; ?>
            <i class="fa fa-caret-down"></i>
        </div>
        <div id="misPedidosLeft" class="w3-dropdown-content w3-white w3-card-4"></div>
    </div>    
    <div id="divMiPedidoPendienteLeft" class="w3-padding-left w3-margin-top" onclick="clickPedidosPendientes()" style="display: none">
        <div id="pedidoPendienteLeft">
            <img src="../imagenes/UsuarioImages/enCurso.png"/>
            <?php echo $backOrdered; ?>
            <i class="fa fa-caret-down"></i>
        </div>
        <div id="miPedidoPendienteLeft" class="w3-dropdown-content w3-white w3-card-4"></div>
    </div>    
    <div class="w3-padding-left w3-margin-top" onclick="document.getElementById('id2').style.display = 'block';">
        <img src="../imagenes/UsuarioImages/volver.png"/>
        <?php echo $exitStablishment; ?>
    </div> 
    <div class="w3-padding-left w3-margin-top" onclick="document.getElementById('id3').style.display = 'block';">
            <img src="../imagenes/UsuarioImages/desconectar.png"/>
            <?php echo $disconectingSession; ?>
    </div>
    <div class="w3-padding-left w3-margin-top" onclick="document.getElementById('id4').style.display = 'block';">
        <img src="../imagenes/UsuarioImages/cerrar.png"/>
        <?php echo $closeApp; ?>
    </div>
    <hr color="blue" size=3>
    <div class="w3-padding-left w3-margin-top">
        <strong>
            <?php echo $_SESSION['nombre_local']; ?>
        </strong>
    </div>
    <div class="w3-padding-left w3-margin-top">
        <?php echo $_SESSION['direccion_local']; ?>
    </div>
</nav>

