<?php
require_once('../includes/funcionesAdmin.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "accesoUsuarioAdmin.php";
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
        <title>Subir Imagen</title>
    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
</head>
    <body>
        <?php 
        if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "form1")) {
	$nombre_archivo = $_FILES['userfile']['name']; 
	move_uploaded_file($_FILES['userfile']['tmp_name'], "../archivos/imagenesAdd/".$nombre_archivo);
	?>
        <script>
		opener.document.form1.imagenProducto.value="<?php echo $nombre_archivo; ?>";
		self.close();
	</script>
        <?php
        } else {
        ?>
        <form action="gestionimagenProductos.php" method="post" enctype="multipart/form-data" id="form1">
            <p>
                <input name="userfile" type="file" />
            </p>
            <p>
                <input type="submit" name="button" id="button" value="Subir Imagen" />
            </p>
            <input type="hidden" name="enviado" value="form1" />
        </form>
        <?php }?>
    </body>
</html>