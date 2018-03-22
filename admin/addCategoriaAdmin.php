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

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Insertar categoria</title>
        <link href="../estilos/admin.css" rel="stylesheet" type="text/css" />
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
                    <h1>
                        <p>Insertar categoría</p>
                    </h1>
                    <div class="contenido">
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
                                        <td><input name="nombreCategoria" type="text" value="" size="35" maxlength="40" /></td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">Imagen:</td>
                                        <td>
                                            <input name="imagenCategoria" type="text" value="" size="23" readonly="readonly"/>
                                            <input type="button" name="button" id="button" value="Ver imagen" onclick="javascript:subirimagen();"/>
                                        </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">Estado:</td>
                                        <td>
                                            <select name="estadoCategoria">
                                                <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Activo</option>
                                                <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Inactivo</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr valign="baseline">
                                        <td nowrap="nowrap" align="right">&nbsp;</td>
                                        <td><input type="submit" value="Insertar categor�a" /></td>
                                    </tr>
                                </table>
                                <input type="hidden" name="MM_insert" value="form1" />
                            </form>
                            <p>&nbsp;</p>
                        </div>
                        <p>&nbsp;</p>  
                    </div>
                </div>
                <div class="footer"></div>
            </div> 
        </div>
    </body>
</html>