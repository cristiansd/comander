<?phprequire_once('../includes/funcionesAdmin.php');require_once ('../includes/GoogleTranslate.php');if (!isset($_SESSION)) {    session_start();}$MM_authorizedUsers = "1,2,3";$MM_donotCheckaccess = "false";$MM_restrictGoTo = "accesoUsuarioAdmin.php";if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {    $MM_qsChar = "?";    $MM_referrer = $_SERVER['PHP_SELF'];    if (strpos($MM_restrictGoTo, "?"))        $MM_qsChar = "&";    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);    header("Location: " . $MM_restrictGoTo);    exit;}$editFormAction = $_SERVER['PHP_SELF'];if (isset($_SERVER['QUERY_STRING'])) {    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}//DECLARAMOS LA CONEXION A LA BASE DE DATOSmysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {    //SETEAMOS VARIABLES RECIBIDAS    $idString = $_POST['idString'];    $idCategoria = $_POST['idMenu'];    $nombre = $_POST['nombreMenu'];    //TRADUCIMOS A LOS DIFERENTES IDIOMAS         $traslator = new GoogleTranslate();        for ($i=0;$i<10;$i++){        switch ($i){            case 0:                $source = $_COOKIE['idioma'];                $target = 'en';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $inglesCategoria = $resultado;                break;            case 1:                $source = $_COOKIE['idioma'];                $target = 'ca';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $catalanCategoria = $resultado;                break;            case 2:                $source = $_COOKIE['idioma'];                $target = 'fr';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $francesCategoria = $resultado;                break;                  case 3:                $source = $_COOKIE['idioma'];                $target = 'de';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $alemanCategoria = $resultado;                break;            case 4:                $source = $_COOKIE['idioma'];                $target = 'it';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                    $resultado = str_replace('"', '', $resultado);                $italianoCategoria = $resultado;                break;               case 5:                $source = $_COOKIE['idioma'];                $target = 'ru';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $rusoCategoria = $resultado;                break;            case 6:                $source = $_COOKIE['idioma'];                $target = 'zh-CN';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                    $resultado = str_replace('"', '', $resultado);                $chinoCategoria = $resultado;                break;               case 7:                $source = $_COOKIE['idioma'];                $target = 'ja';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                $resultado = str_replace('"', '', $resultado);                $japonesCategoria = $resultado;                break;               case 8:                $source = $_COOKIE['idioma'];                $target = 'ar';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $arabeCategoria = $resultado;                break;              case 9:                $source = $_COOKIE['idioma'];                $target = 'es';                $text = $_POST['nombreMenu'];                $result = $traslator->translate($source, $target, $text);                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                   $resultado = str_replace('"', '', $resultado);                $spanishCategoria = $resultado;                break;          }    }         //INSERTAMOS EN LA TABLA STRINGS EL NOMBRE DE LA CATEGORIA EN DIFERENTE INDIOMAS    $insertIdiomas = sprintf("UPDATE strings SET spanish=%s, ingles=%s, catalan=%s, frances=%s, aleman=%s, italiano=%s, ruso=%s, chino=%s, japones=%s, arabe=%s WHERE id= $idString",             GetSQLValueString($spanishCategoria, "text"),             GetSQLValueString($inglesCategoria, "text"),             GetSQLValueString($catalanCategoria, "text"),             GetSQLValueString($francesCategoria, "text"),            GetSQLValueString($alemanCategoria, "text"),             GetSQLValueString($italianoCategoria, "text"),            GetSQLValueString($rusoCategoria, "text"),             GetSQLValueString($chinoCategoria, "text"),            GetSQLValueString($japonesCategoria, "text"),            GetSQLValueString($arabeCategoria, "text"));        $ResultdoIdioma = mysqli_query($conexionComanderAdmin, $insertIdiomas) or die(mysqli_error($conexionComanderAdmin));            $updateSQL = sprintf("UPDATE submenus SET nombreSubmenu=%s, estadoSubmenu=%s WHERE idSubmenu=%s",             GetSQLValueString(utf8_decode($_POST['nombreMenu']), "text"),            GetSQLValueString($_POST['estadoMenu'], "int"),             GetSQLValueString($_POST['idSubmenu'], "int"));    mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);    $Result1 = mysqli_query($conexionComanderAdmin, $updateSQL) or die(mysqli_error($conexionComanderAdmin));            $updateGoTo = "administracionSubofertasAdmin.php";    if (isset($_SERVER['QUERY_STRING'])) {        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";        $updateGoTo .= $_SERVER['QUERY_STRING'];    }    header(sprintf("Location: %s", $updateGoTo));}if (isset($_GET["RecordID"])) {    $varCategoria_consultaCategoria = $_GET["RecordID"];}mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);$query_consultaCategoria = "SELECT * FROM submenus WHERE idSubmenu='$varCategoria_consultaCategoria'";$consultaCategoria = mysqli_query($conexionComanderAdmin, $query_consultaCategoria) or die(mysqli_connect_error());$row_consultaCategoria = mysqli_fetch_assoc($consultaCategoria);//ASIGNAMOS LOS VALORES A VARIABLES$idString = $row_consultaCategoria['id_string'];$idCategoria = $row_consultaCategoria['idCategoria'];?><!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <link rel="stylesheet" href="../estilos/w3.css">        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">        <script type="text/javascript" src="../envCam/jquery-mobile/jquery.js"></script>        <link href="../estilos/admin.css" rel="stylesheet" type="text/css" />        <link href="../estilos/w3-theme-indigo.css" rel="stylesheet" type="text/css" />        <title><?php echo $titleSheet; ?></title>        <style type="text/css"></style>        <script type="text/javascript">            var height;            var width;            var nombreCategoria;            $(document).ready(function () {                height = $(window).height();                width = $(window).width();                var styleSidevar1 = "height:" + (height - 100) + "px;";                var styleFormulario = "margin-left:" + ((width - 500 - 240) / 2) + "px";                //$(".content").attr("style", styleSidevar1);                //$(".subcontenedor").attr("style", styleSidevar1);                if(height > $(".sidebar1").height()){                $(".sidebar1").attr("style", styleSidevar1);                                }                if($(".subcontenedor").height()>$(".sidebar1").height()){                    $(".sidebar1").attr("style", "height:" + $(".subcontenedor").height() + "px;");                                                }                $(".contenidoFormulario").attr("style", styleFormulario);                            });//FUNCION PARA ELIMINAR EQITUETA CATEGORIA            function eliminarEtiqueta() {                $("#categoriaElemento").remove();            }                  </script>    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico"></head>    <body>        <header class="w3-card-4 w3-theme header w3-padding-large" style="height: 100px;">            <div class ="w3-margin" style="float: left;"><img src="../imagenes/mano.png" class="w3-round-small" alt="Norway" style="width:40px;height: 40px;"></div>            <div class="w3-xxxlarge" style="width: 50%;float: left;">COMANDER</div>            <div class="w3-xlarge w3-right" style="margin-top: 20px;margin-right: 10px;"><?php echo $headerTitle; ?></div>        </header>        <div class="subcontenedor">            <div class="sidebar1 w3-card-4 w3-theme-l1 w3-large">                <div class="w3-xlarge w3-margin-top w3-margin-bottom w3-padding-left"><?php echo $sidevarTitle; ?></div><?php include("../includes/BotoneraAdmin.php"); ?>            </div>               <div class="content">                   <h1 class=" w3-center"><p><?php echo $modifySubOfferTittle; ?></p></h1>                <div class="contenido">                    <p class=" w3-center w3-medium"><?php echo $modifySubOfferDescription; ?></p>                    <br>                                         <div class="contenidoFormulario w3-card-8 w3-large w3-text-white w3-grey">                          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">                            <table align="center">                                <tr valign="baseline">                                    <td width="47" align="right" nowrap="nowrap"><?php echo $nameTag; ?></td>                                    <td width="269">                                        <input id="nombreCategoria" name="nombreMenu" style= "height:40px;width:375px" type="text" value="<?php echo htmlentities(recuperarString($row_consultaCategoria['id_string'])); ?>" size="40" maxlength="40" />                                                                                                                                                               </td>                                </tr>                                 <tr valign="baseline">                                    <td width="47" align="right" nowrap="nowrap"><?php echo $bidTag; ?></td>                                    <td width="269">                                        <input name="Menu" style= "height:40px;width:150px" disabled="disabled" type="text" value="<?php echo htmlentities(recuperarString(ObtenerNombreMenu($row_consultaCategoria['idMenuSubmenu']))); ?>" size="40" maxlength="40" />                                                                                                                                                               </td>                                </tr>                                 <tr valign="baseline">                                    <td nowrap="nowrap" align="right"><?php echo $stateTag; ?></td>                                    <td>                                        <select name="estadoMenu" style= "height:40px;width:150px">                                            <option value="1" <?php if (!(strcmp(1, htmlentities($row_consultaCategoria['estadoMenu'], ENT_COMPAT, 'utf-8')))) {    echo "selected=\"selected\"";} ?>><?php echo $availableTag;?></option>                                            <option value="0" <?php if (!(strcmp(0, htmlentities($row_consultaCategoria['estadoMenu'], ENT_COMPAT, 'utf-8')))) {    echo "selected=\"selected\"";} ?>><?php echo $notAvailableTag; ?></option>                                        </select>                                    </td>                                </tr>                                <br>                                <tr valign="baseline">                                    <td nowrap="nowrap" align="right">&nbsp;</td>                                    <td style="padding-top: 10px;">                                        <input class="w3-btn w3-light-grey w3-border w3-card-8 w3-text-grey w3-large" type="submit" form="form1" value="<?php echo $updateSubOfferButton; ?>" />                                    </td>                                </tr>                            </table>                            <input type="hidden" name="MM_update" value="form1" />                            <input type="hidden" name="idMenuSubmenu" value="<?php echo $row_consultaCategoria['idMenuSubmenu']; ?>" />                            <input type="hidden" name="idSubmenu" value="<?php echo $row_consultaCategoria['idSubmenu']; ?>" />                            <input type="hidden" name="idString" value="<?php echo $row_consultaCategoria['id_string']; ?>" />                        </form>                        <br>                    </div>                </div>                            </div>        </div>     </body></html><?phpmysqli_free_result($consultaCategoria);?>