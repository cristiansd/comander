
<?php require_once('../Connections/conexionComanderUsuario.php'); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "loginEnvCam.php";

if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?"))
        $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}
error_reporting(E_ALL ^ E_DEPRECATED);


$idioma = $_SESSION['idioma'];
if($idioma == "es" || $idioma == "en" || $idioma == "ca" || $idioma == "de" || $idioma == "fr" || $idioma == "it" || $idioma == "ru" || $idioma == "zh" || $idioma == "ja" || $idioma == "ar"){
    $idioma = $_SESSION['idioma'];
} else {
    $idioma = "en";
}
    include "../strings/".$idioma.".php";

if (!function_exists("GetSQLValueString")) {

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }

}

//if(!comprobarMesa())
//  header("Location: ". $MM_restrictGoTo); 
$stripeKey = 'pk_test_gO06k6oYsxwzxwdPBmpQZ4lE';
function probar() {
    global $database_usuario, $comcon_usuario;
    $database_usuario = $_SESSION['name_database'];
    echo $_SESSION['name_database'] . "<br>";
    echo "esto es la prueba que imprime la variable de conections" . $database_usuario;
}

function comprobarMesa() {

    global $database_usuario, $comcon_usuario;
    if (isset($_SESSION['mesa'])) {
        mysql_select_db($database_usuario, $comcon_usuario);
        $query_EstadoMesa = "SELECT * FROM mesas WHERE idMesa=" . $_SESSION['mesa'] . "";
        $RecuperaEstadoMesa = mysql_query($query_EstadoMesa, $comcon_usuario) or die(mysql_error());
        $row_EstadoMesa = mysql_fetch_assoc($RecuperaEstadoMesa);
        $estadoMesa = ($row_EstadoMesa['estadoMesa'] == 0 && $row_EstadoMesa['peticionMesa'] == 0) ? false : true;
        return $estadoMesa;
    }
}

function redondear_dos_decimal($valor) {
    $float_redondeado = round($valor * 100) / 100;
    return $float_redondeado;
}

function generar_clave($longitud) {
    $cadena = "[^A-Z0-9]";
    return substr(eregi_replace($cadena, "", md5(rand())) .
            eregi_replace($cadena, "", md5(rand())) .
            eregi_replace($cadena, "", md5(rand())), 0, $longitud);
}

function recuperaUsuario($nombreUser) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RecuperaId = "SELECT idUsuario FROM usuarios WHERE nickUsuario='" . $nombreUser . "'";
    $RecuperaId = mysql_query($query_RecuperaId, $comcon_usuario) or die(mysql_error());
    $row_RecuperaId = mysql_fetch_assoc($RecuperaId);
    $totalRows_RecuperaId = mysql_num_rows($RecuperaId);
    $idUser = $row_RecuperaId['idUsuario'];
    return $idUser;
    mysql_free_result($RecuperaId);
}

function recuperaPrecio($producto) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegPrecio = "SELECT productos.precioVentaProducto FROM productos WHERE productos.idProducto=$producto";
    $RegPrecio = mysql_query($query_RegPrecio, $comcon_usuario) or die(mysql_error());
    $row_RegPrecio = mysql_fetch_assoc($RegPrecio);
    $totalRows_RegPrecio = mysql_num_rows($RegPrecio);
    return $row_RegPrecio['precioVentaProducto'];
}

function recuperaNombreProducto($idProducto) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegProducto = "SELECT id_string FROM productos WHERE idProducto=$idProducto";
    $RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
    $row_RegProducto = mysql_fetch_assoc($RegProducto);
    return recuperarString($row_RegProducto['id_string']);
}

function recuperaNombreEspanishProducto($idProducto) {
    global $database_usuario, $comcon_usuario;
    
    mysql_select_db($database_usuario, $comcon_usuario); 
    
    $query_RegProducto = "SELECT id_string FROM productos WHERE idProducto=$idProducto";
    $RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
    $row_RegProducto = mysql_fetch_assoc($RegProducto);
    $id_string = $row_RegProducto['id_string'];
    
    $query_consultaFuncion = sprintf("SELECT spanish FROM strings WHERE id = %s", 
    $id_string);
    $consultaFuncion = mysql_query($query_consultaFuncion, $comcon_usuario);
    $row_consultaFuncion = mysql_fetch_assoc($consultaFuncion);
    return $row_consultaFuncion['spanish'];
}

function recuperaNombreEspanishMenu($idProducto) {
    global $database_usuario, $comcon_usuario;
    
    mysql_select_db($database_usuario, $comcon_usuario); 
    
    $query_RegProducto = "SELECT id_string FROM menus WHERE idMenu=$idProducto";
    $RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
    $row_RegProducto = mysql_fetch_assoc($RegProducto);
    $id_string = $row_RegProducto['id_string'];
    
    $query_consultaFuncion = sprintf("SELECT spanish FROM strings WHERE id = %s", 
    $id_string);
    $consultaFuncion = mysql_query($query_consultaFuncion, $comcon_usuario);
    $row_consultaFuncion = mysql_fetch_assoc($consultaFuncion);
    return $row_consultaFuncion['spanish'];
}

function recuperaNombreUsuario($idUsuario) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegUsuario = "SELECT usuarios.nombreUsuario FROM usuarios WHERE usuarios.idUsuario=$idUsuario";
    $RegUsuario = mysql_query($query_RegUsuario, $comcon_usuario) or die(mysql_error());
    $row_RegUsuario = mysql_fetch_assoc($RegUsuario);
    $totalRows_RegUsuario = mysql_num_rows($RegUsuario);
    return $row_RegUsuario['nombreUsuario'];
}

function recuperaNickUsuario($idUsuario) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegUsuario = "SELECT usuarios.nickUsuario FROM usuarios WHERE usuarios.idUsuario=$idUsuario";
    $RegUsuario = mysql_query($query_RegUsuario, $comcon_usuario) or die(mysql_error());
    $row_RegUsuario = mysql_fetch_assoc($RegUsuario);
    $totalRows_RegUsuario = mysql_num_rows($RegUsuario);
    return $row_RegUsuario['nickUsuario'];
}

function recuperaNombreMesa($idMesa) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegProducto = "SELECT mesas.nombreMesa FROM mesas WHERE mesas.idMesa=$idMesa";
    $RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
    $row_RegProducto = mysql_fetch_assoc($RegProducto);
    $totalRows_RegProducto = mysql_num_rows($RegProducto);
    return $row_RegProducto['nombreMesa'];
}

function recuperaNombreZona($idZona) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegZona = "SELECT zonas.nombreZona FROM zonas WHERE zonas.idZona=$idZona";
    $RegZona = mysql_query($query_RegZona, $comcon_usuario) or die(mysql_error());
    $row_RegZona = mysql_fetch_assoc($RegZona);
    $totalRows_RegZona = mysql_num_rows($RegZona);
    mysql_free_result($RegZona);
    return $row_RegZona['nombreZona'];
}

function recuperaNombreSubmenu($idsubMenu) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegSubMenu = "SELECT submenus.nombreSubmenu FROM submenus WHERE submenus.idSubmenu=$idsubMenu";
    $RegSubMenu = mysql_query($query_RegSubMenu, $comcon_usuario) or die(mysql_error());
    $row_RegSubMenu = mysql_fetch_assoc($RegSubMenu);
    $totalRows_RegSubMenu = mysql_num_rows($RegSubMenu);
    mysql_free_result($RegSubMenu);
    return $row_RegSubMenu['nombreSubmenu'];
}

function recuperaNombreTipomenu($idTipomenu) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegSubMenu = "SELECT tipomenu.nombreTipomenu FROM tipomenu WHERE tipomenu.idTipomenu=$idTipomenu";
    $RegSubMenu = mysql_query($query_RegSubMenu, $comcon_usuario) or die(mysql_error());
    $row_RegSubMenu = mysql_fetch_assoc($RegSubMenu);
    $totalRows_RegSubMenu = mysql_num_rows($RegSubMenu);
    mysql_free_result($RegSubMenu);
    return $row_RegSubMenu['nombreTipomenu'];
}

function recuperaEnvioProducto($idEnvio) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegSubMenu = "SELECT productos.envioProducto FROM productos WHERE productos.idProducto=$idEnvio";
    $RegSubMenu = mysql_query($query_RegSubMenu, $comcon_usuario) or die(mysql_error());
    $row_RegSubMenu = mysql_fetch_assoc($RegSubMenu);
    $totalRows_RegSubMenu = mysql_num_rows($RegSubMenu);
    mysql_free_result($RegSubMenu);
    return $row_RegSubMenu['envioProducto'];
}

function recuperaimagenProducto($idEnvio) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegSubMenu = "SELECT id_imagen FROM productos WHERE productos.idProducto=$idEnvio";
    $RegSubMenu = mysql_query($query_RegSubMenu, $comcon_usuario) or die(mysql_error());
    $row_RegSubMenu = mysql_fetch_assoc($RegSubMenu);
    $totalRows_RegSubMenu = mysql_num_rows($RegSubMenu);
    mysql_free_result($RegSubMenu);
    return $row_RegSubMenu['id_imagen'];
}

function recuperaNombrePrecioMenu($idMenu, $cual) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegSubMenu = "SELECT nombreMenu, precioMenu, id_string FROM menus WHERE idMenu=$idMenu";
    $RegSubMenu = mysql_query($query_RegSubMenu, $comcon_usuario) or die(mysql_error());
    $row_RegSubMenu = mysql_fetch_assoc($RegSubMenu);
    $totalRows_RegSubMenu = mysql_num_rows($RegSubMenu);
    if ($cual == 1) {
        $devuelve = recuperarString($row_RegSubMenu['id_string']);
    }
    if ($cual == 2) {
        $devuelve = $row_RegSubMenu['precioMenu'];
    }
    mysql_free_result($RegSubMenu);
    return $devuelve;
}

function recuperaTipoMenu($idMenu) {
    $letra = "M";
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegTipoMenu = "SELECT menus.idTipoMenu FROM menus WHERE menus.idMenu=$idMenu";
    $RegTipoMenu = mysql_query($query_RegTipoMenu, $comcon_usuario) or die(mysql_error());
    $row_RegTipoMenu = mysql_fetch_assoc($RegTipoMenu);
    $totalRows_RegTipoMenu = mysql_num_rows($RegTipoMenu);
    mysql_free_result($RegTipoMenu);
    if ($row_RegTipoMenu['idTipoMenu'] == 2) {
        $letra = "O";
    }
    return $letra;
}

function recuperaClave($idUser) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $query_RegClave = "SELECT usuarios.claveUsuario FROM usuarios WHERE usuarios.idUsuario=$idUser";
    $RegClave = mysql_query($query_RegClave, $comcon_usuario) or die(mysql_error());
    $row_RegClave = mysql_fetch_assoc($RegClave);
    $totalRows_RegClave = mysql_num_rows($RegClave);
    mysql_free_result($RegClave);
    return $row_RegClave['claveUsuario'];
}

function redirect($direccion) {
    ?>
    <script language="javascript">

        window.location = "<?php echo $direccion; ?>";

    </script>
<?php
}

//COMPROBACION SI HAY MENU/OFERTAS EN PEDIDO

function comprobarOfertasEnPedido($bd, $idGrupoMenu) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $queryOfertas = "SELECT * FROM $bd WHERE $idGrupoMenu > 0";
    $ofertas = mysql_query($queryOfertas, $comcon_usuario) or die(mysql_error());
    $row_ofertas = mysql_fetch_assoc($ofertas);
    $totalRows_ofertas = mysql_num_rows($ofertas);
    mysql_free_result($ofertas);
    return $totalRows_ofertas;
}

//RECOGER EL ID DE GRUPO DE OFERTAS

function idGrupoOfertas($bd, $idGrupoMenu) {
    global $database_usuario, $comcon_usuario;
    mysql_select_db($database_usuario, $comcon_usuario);
    $queryGrupoOfertas = "SELECT $idGrupoMenu FROM $bd GROUP BY $idGrupoMenu ORDER BY id DESC";
    $GrupoOfertas = mysql_query($queryGrupoOfertas, $comcon_usuario) or die(mysql_error());
    $row_grupoOfertas = mysql_fetch_assoc($GrupoOfertas);
    $totalRows_ofertas = mysql_num_rows($GrupoOfertas);
    mysql_free_result($GrupoOfertas);
    return $row_grupoOfertas ['' . $idGrupoMenu . ''];
}

//RECOGER VALORES DE SUBMENU QUE PERTENEZCAN A UN MENU

function submenusDeMenu($idMenu) {
    global $database_usuario, $comcon_usuario;
    $registros = array();
    mysql_select_db($database_usuario, $comcon_usuario);
    $querySubmenus = "SELECT idSubmenu FROM submenus WHERE idMenuSubmenu = $idMenu";
    $submenus = mysql_query($querySubmenus, $comcon_usuario) or die(mysql_error());
    $row_submenus = mysql_fetch_assoc($submenus);
    $totalRows_submenus = mysql_num_rows($submenus);
    do {
        $registros[] = $row_submenus ['idSubmenu'];
    } while ($row_submenus = mysql_fetch_assoc($submenus));
    mysql_free_result($submenus);
    return $registros;
}

//RECOGEMOS VALORES DE SUBMENU QUE PERTENEZCAN AL GRUPO DE MENU

function idSubmenuGrupoOfertas($bd, $idGrupoMenu) {
    global $database_usuario, $comcon_usuario;
    $registros = array();
    mysql_select_db($database_usuario, $comcon_usuario);
    $querySubmenuGrupoOfertas = "SELECT idSubmenuComandaTemp FROM $bd WHERE idGrupoMenuComandaTemp = $idGrupoMenu";
    $SubmenuGrupoOfertas = mysql_query($querySubmenuGrupoOfertas, $comcon_usuario) or die(mysql_error());
    $row_submenuGrupoOfertas = mysql_fetch_assoc($SubmenuGrupoOfertas);
    $totalRows_submenuGrupoOfertas = mysql_num_rows($SubmenuGrupoOfertas);
    do {
        $registros[] = $row_submenuGrupoOfertas ['idSubmenuComandaTemp'];
    } while ($row_submenuGrupoOfertas = mysql_fetch_assoc($SubmenuGrupoOfertas));
    mysql_free_result($SubmenuGrupoOfertas);
    return $registros;
}

//COMPARAMOS ARRAYS DE SUBMENUS DE MENU Y DE SUBMENUS DE GRUPO DE MENU Y DEVOLVEMOS LA DIFERENCIA ENTRE LOS DOS.

function compararSubmenuMenuYSubmenuGrupoMenu($idMenu, $bd, $idGrupoMenu) {
    $result = array_diff(submenusDeMenu($idMenu), idSubmenuGrupoOfertas($bd, $idGrupoMenu));
    return $result;
}

function recuperarNombreSubmenu($idSubmenu) {
    global $database_usuario, $comcon_usuario;
    $querySubmenu = "SELECT nombreSubmenu FROM submenus WHERE idSubmenu=$idSubmenu";
    $subMenu = mysql_query($querySubmenu, $comcon_usuario) or die(mysql_error());
    $row_submenu = mysql_fetch_assoc($subMenu);
    return $row_submenu;
}

function recuperarInformacionProducto($idProducto) {
    global $database_usuario, $comcon_usuario;
    $querySubmenu = "SELECT * FROM productos WHERE idProducto=$idProducto";
    $subMenu = mysql_query($querySubmenu, $comcon_usuario) or die(mysql_error());
    $row_submenu = mysql_fetch_assoc($subMenu);
    $informacion = Array();
    $informacion[0] = recuperarString($row_submenu['id_string_descripcion']);
    $informacion[1] = recuperarString($row_submenu['id_string_alergenos']);
    $informacion[2] = recuperarString($row_submenu['id_string_nutricional']);
    return $informacion;
}

function iGrupoOfertas() {
    global $database_usuario, $comcon_usuario;
    $registros = array();
    mysql_select_db($database_usuario, $comcon_usuario);
    $querySubmenuGrupoOfertas = "SELECT * FROM comandaTemp_" . $_SESSION['id_usuario'] . " WHERE idGrupoMenuComandaTemp > 0 GROUP BY idGrupoMenuComandaTemp ORDER BY id DESC";
    $SubmenuGrupoOfertas = mysql_query($querySubmenuGrupoOfertas, $comcon_usuario) or die(mysql_error());
    $row_submenuGrupoOfertas = mysql_fetch_assoc($SubmenuGrupoOfertas);
    $totalRows_submenuGrupoOfertas = mysql_num_rows($SubmenuGrupoOfertas);
    $count = 0;
    if ($totalRows_submenuGrupoOfertas > 0) {
        do {
            $registros[$count][0] = $row_submenuGrupoOfertas ['idMenuComandaTemp'];
            $registros[$count][1] = $row_submenuGrupoOfertas ['idGrupoMenuComandaTemp'];
            $count++;
        } while ($row_submenuGrupoOfertas = mysql_fetch_assoc($SubmenuGrupoOfertas));

        mysql_free_result($SubmenuGrupoOfertas);
    }
    return $registros;
}

function cabeceraNavegacionUsuario($texto, $precio, $desplegable) {
    $sizeTexto = strlen($texto);
    if ($desplegable == 1) {
        ?>
        <nav class="w3-sidenav w3-animate-left w3-card-2 w3-white" style="display:none;margin-top: 55px;" id="mySidenav">
            <a href="javascript:void(0)" onclick="w3_close()"accesskey=""class="w3-closenav w3-large">Close &times;</a>
            <a href="principalUsuario.php">Inicio</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
            <a href="#">Link 4</a>
            <a href="#">Link 5</a>
        </nav> 
            <?php } ?>
    <header id="header" class="w3-container w3-card-4 w3-theme header w3-top" style="height:65px;">
        <h3 style="margin-top: 14px;">
            <?php if ($desplegable == 1) { ?>
            <i class="w3-xlarge w3-margin-right" onclick="window.history.back();">
                <img  src="../imagenes/UsuarioImages/back.png" alt="Norway">
            </i>
            <?php } else if ($desplegable == 2){ ?>
            <i class="w3-xlarge w3-margin-right" onclick="conection('productosBuscarUsuario.php');">
                <img  src="../imagenes/UsuarioImages/back.png" alt="Norway">
            </i>
            <?php } else { ?>
            <i class="w3-xlarge w3-margin-right" onclick="window.history.back();">
                <img  src="../imagenes/UsuarioImages/back.png" alt="Norway">
            </i>
            <?php } ?>
            <?php if ($sizeTexto > 9) { ?>
                <span id="textoheader" class="w3-margin-left w3-xlarge w3-top" style="width: 120px;margin-top: 16px;"><?php echo substr($texto,0,8)."..."; ?></span>
            <?php } else { ?>
                <span id="textoheader" class="w3-margin-left w3-xlarge w3-top" style="width: 120px;margin-top: 16px;"><?php echo $texto; ?></span>
           <?php }
                if ($precio) { ?>
                <div id="contprecio" class="w3-right" >
                    <div id="divprecio" class="w3-xlarge w3-right" style="margin-top: 0px;"></div>
                </div>
            <?php } else { ?>
                <i class="w3-right w3-margin-left " onclick="clickBuscar();">
                    <img src="../imagenes/UsuarioImages/buscar.png" alt="Norway">
                </i>                
                <i class="w3-right w3-margin-left w3-margin-right" onclick="clickAyudaNotificacion();">
                    <img src="../imagenes/UsuarioImages/notificacion.png" alt="Norway">
                </i>
                <i class="w3-right w3-margin-right " onclick="window.location.href = 'principalUsuario.php';">
                    <img src="../imagenes/UsuarioImages/home.png" alt="Norway">
                </i>
    <?php } ?>
        </h3>
    </header>
   
    <?php
    }

    function imagenNavegacionCarta($imagen, $animated_zoom) {
        if ($animated_zoom == 1) {
            ?>
        <div class="w3-content w3-animate-zoom" style="padding-top: 55px;padding-bottom:0px; ">
        <?php } else { ?>
            <div class="w3-content" style="padding-top: 55px;padding-bottom:0px; ">
        <?php } if ($imagen == "carta") {?> 
                <img id="imagen" style="height: 250px;width: 100%;margin-top:0px;" src="../archivos/ImagenesAdd/carta_ejempo.jpg"> 
                <?php } else if ($imagen == "menu") {?> 
                <img id="imagen" style="height: 250px;width: 100%;margin-top:0px;" src="../archivos/ImagenesAdd/menu.jpg"> 
                <?php } else { ?>
            <img id="imagen" style="height: 250px;width: 100%;margin-top:0px;" src="../includes/imagen.php?id=<?php echo $imagen."&local=".$_SESSION['establecimiento']; ?>">    
                <?php } ?>
            </div>   
            <?php
            }

            function imagenProducto($imagen, $animated_zoom) {
                if ($animated_zoom == 1) {
                    ?>
            <div class="w3-content w3-animate-zoom" style="padding-top: 55px;padding-bottom:0px; ">
                <?php } else { ?>
                <div class="w3-content" style="padding-top: 55px;padding-bottom:0px; ">
                <?php } ?>   
                <img style="height: 250px;width: 100%;margin-top:0px;" src="../includes/imagen.php?id=<?php echo $imagen."&local=".$_SESSION['establecimiento']; ?>"></div>   
            <?php
            }

            function recuperarComentarioComandaTemp($id) {
                global $database_usuario, $comcon_usuario;
                $valor = "";
                mysql_select_db($database_usuario, $comcon_usuario);
                $querySubmenuGrupoOfertas = "SELECT comentarioComandaTemp FROM comandaTemp_" . $_SESSION['id_usuario'] . " WHERE id = $id";
                $SubmenuGrupoOfertas = mysql_query($querySubmenuGrupoOfertas, $comcon_usuario) or die(mysql_error());
                $row_submenuGrupoOfertas = mysql_fetch_assoc($SubmenuGrupoOfertas);
                if (is_null($row_submenuGrupoOfertas)) {
                    $valor = "¿algún comentario?";
                    echo $valor;
                } else {
                    $valor = $row_submenuGrupoOfertas;
                    echo $valor;
                }
            }
            
            function recuperarString($idString){
                global $database_usuario, $comcon_usuario;
                mysql_select_db($database_usuario, $comcon_usuario);
                $query_consultaFuncion = sprintf("SELECT * FROM strings WHERE id = %s",
                $idString);
                $consultaFuncion = mysql_query($query_consultaFuncion, $comcon_usuario);
                $row_consultaFuncion = mysql_fetch_assoc($consultaFuncion);
                switch ($_SESSION['idioma']){
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



