<?php
require_once('../includes/funcionesAdmin.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "entrarAdmin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE Submenus SET nombreSubmenu=%s, estadoSubmenu=%s WHERE idSubmenu=%s",
    GetSQLValueString($_POST['nombreSubmenu'], "text"),
    GetSQLValueString($_POST['estadoSubmenu'], "int"),					   
    GetSQLValueString($_POST['idSubmenu'], "int"));

  mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
  $Result1 = mysqli_query($conexionComanderAdmin, $updateSQL) or die(mysqli_connect_error());

  $updateGoTo = "administracionSubmenusAdmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$varSubmenu_consultaSubmenu = "0";
if (isset($_GET["RecordID"])) {
  $varSubmenu_consultaSubmenu = $_GET["RecordID"];
}
mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
$query_consultaSubmenu = sprintf("SELECT * FROM submenus WHERE idSubmenu=%s", 
GetSQLValueString($varSubmenu_consultaSubmenu, "int"));
$consultaSubmenu = mysqli_query($conexionComanderAdmin, $query_consultaSubmenu) or die(mysqli_connect_error());
$row_consultaSubmenu = mysqli_fetch_assoc($consultaSubmenu);
$totalRows_consultaSubmenu = mysqli_num_rows($consultaSubmenu);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Modificación de submenús</title>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/admin.css" rel="stylesheet" type="text/css" />
        <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
</head>
    <body>
        <div class="container">
            <div class="subheader">
                <div class="header">  
                    <div class="headerInteriorLogo"><img src="../imagenes/adminImages/logotrans.png" width="130" height="110" alt="logo" /></div>  
                    <div class="headerInteriorTitulo"><img src="../imagenes/adminImages/tituloCabecera.png" width="704" height="107" alt="titulo" /></div>
                </div>
            </div>
            <div class="subcontenedor">
                <div class="sidebar1">
                    <div class="admin">Administración</div>
                    <?php include("../includes/BotoneraAdmin.php"); ?>
                </div>
                <div class="content">
                    <h1><p>Modificar submenú.</p></h1>
                    <div class="contenido">
                        <p>Aqui podras actualizar el submenú seleccionado. Modifica los parametros que necesites y pulsa "Actualizar".</p>
                        <br /> 
                        <div class="contenidoFormulario">  
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                <table align="center">
                                    <tr valign="baseline">
                                        <td width="47" align="right" nowrap="nowrap">Nombre:</td>
                                        <td width="269">
                                            <span id="sprytextfield1">
                                                <input name="nombreSubmenu" type="text" value="<?php echo htmlentities($row_consultaSubmenu['nombreSubmenu'], ENT_COMPAT, 'utf-8'); ?>" size="40" maxlength="40" />
                                                <span class="textfieldRequiredMsg">Necesario.</span>                                                    
                                            </span>
                                        </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td width="47" align="right" nowrap="nowrap">Menú:</td>
                                        <td width="269"><input name="idMenuSubmenu" disabled="disabled"  type="text" value="<?php echo ObtenerNombreMenu($row_consultaSubmenu['idMenuSubmenu'], ENT_COMPAT, 'utf-8'); ?>" size="40" maxlength="40" /></td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">Estado:</td>
                                        <td>
                                            <select name="estadoSubmenu">
                                                <option value="1" <?php if (!(strcmp(1, htmlentities($row_consultaSubmenu['estadoSubmenu'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>>Disponible</option>
                                                <option value="0" <?php if (!(strcmp(0, htmlentities($row_consultaSubmenu['estadoSubmenu'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>>No disponible</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">&nbsp;</td>
                                        <td><input type="submit" value="Actualizar menú" /></td>
                                    </tr>
                                </table>
                                <input type="hidden" name="MM_update" value="form1" />
                                <input type="hidden" name="idSubmenu" value="<?php echo $row_consultaSubmenu['idSubmenu']; ?>" />
                            </form>
                        </div>
                        <script type="text/javascript">
                            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
                        </script>
                    </div>
                </div>
                <div class="footer"></div>
            </div> 
        </div>
    </body>
</html>
<?php
mysqli_free_result($consultaSubmenu);
?>
