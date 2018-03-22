<?php
require_once('../includes/funcionesAdmin.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "accesoErrorAdmin.php";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
 $insertSQL = sprintf("INSERT INTO categorias (nombreCategoria, imagenCategoria, estadoCategoria) VALUES (%s, %s, %s)",
GetSQLValueString($_POST['nombreCategoria'], "text"),
GetSQLValueString($_SESSION['imagen'], "text"),
GetSQLValueString($_POST['estadoCategoria'], "int"));

$nombre = $_POST['nombreCategoria'];
$imagen = $_SESSION['imagen'];
$estado = $_POST['estadoCategoria'];

//$insertSQL = "INSERT INTO categorias (nombreCategoria, imagenCategoria, estadoCategoria) VALUES ('$nombre', '$imagen', '$estado')";

  mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
  $Result1 = mysqli_query($conexionComanderAdmin, $insertSQL) or die(mysqli_error($conexionComanderAdmin));

  $insertGoTo = "administracionCategoriaAdmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Añadir categoría</title>
        <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/admin.css" rel="stylesheet" type="text/css" />
        <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
                    <h1><p>Añadir categoría</p></h1>
                    <div class="contenido">    
                        <p>Aquí podrás añadir nuevas categorías. Rellena los campos y selecciona el estado.</p>
                        <br />     
                        <script>
                            function subirimagen(){
                                self.name = 'opener';
                                remote = open('gestionimagen.php','remote',
                                'width=400,height=150,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,	fullscreen=no,status=yes');
                                remote.focus();		
                            }  
                        </script> 
                        <div class=" contenidoFormulario">
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                <table align="center">
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">Nombre:</td>
                                            <td>
                                                <span id="sprytextfield1">
                                                    <input name="nombreCategoria" type="text" value="" size="39" maxlength="40" />
                                                    <span class="textfieldRequiredMsg">
                                                        Necesario.
                                                    </span>                                                        
                                                </span>
                                            </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">Imagen:</td>
                                        <td>
                                            <input name="imagenCategoria" type="text" value="" size="23" readonly="readonly"/>
                                            <input type="button" name="button" id="button" value="Ver imagen" onclick="javascript:subirimagen();"/>
                                        </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">
                                            Estado:
                                        </td>
                                        <td>
                                            <select name="estadoCategoria">
                                                <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Disponible</option>
                                                <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>No disponible</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">&nbsp;</td>
                                        <td>
                                            <input type="submit" value="Añadir categoría"/>
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" name="MM_insert" value="form1" />
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