<?php require_once('../includes/funcionesUsuario.php'); 

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "errorIdentificacionEnvCam.php";
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

//$idMesa = $_GET['idMesa'];
//$idPedido = $_GET['idPedido'];
$idGrupoMenuComanda = 0;
$esmenu = 0;
$idMenu = 0;
$idGrupoMenuComandaTemp = 0;
$idComandaTemp = $_GET['idComandaTemp'];
$totalRows_Comprobar=1;
if (isset($_GET['esmenu'])){
    $esmenu = 1;
    $idGrupoMenuComandaTemp = $_GET['idGrupoMenuComandaTemp'];
    $idMenu = $_GET['idMenu'];  
    
mysql_select_db($database_usuario, $comcon_usuario);
$deleteSQL = sprintf("DELETE FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp=%s", 
GetSQLValueString($idGrupoMenuComandaTemp, "int"));
$Result1 = mysql_query($deleteSQL, $comcon_usuario) or die(mysql_error());
} else {
mysql_select_db($database_usuario, $comcon_usuario);
$deleteSQL = sprintf("DELETE FROM comandaTemp_".$_SESSION['id_usuario']." WHERE id=%s", 
GetSQLValueString($idComandaTemp, "int"));
$Result1 = mysql_query($deleteSQL, $comcon_usuario) or die(mysql_connect_error());
}
$query_Comprobar = "SELECT * FROM comandaTemp_".$_SESSION['id_usuario']."";
$Comprobar = mysql_query($query_Comprobar, $comcon_usuario) or die(mysql_connect_error());
$row_Comprobar = mysql_fetch_assoc($Comprobar);
$totalRows_Comprobar = mysql_num_rows($Comprobar);
if ($totalRows_Comprobar > 0) {    
    $insertGoTo = "listaTiempoRealUsuario.php";    
}else{
    $insertGoTo = "principalUsuario.php";
}
header("Cache-Control: no-cache, must-revalidate"); // Evitar guardado en cache del cliente HTTP/1.1
header("Pragma: no-cache"); // Evitar guardado en cache del cliente HTTP/1.0
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Eliminar Comanda</title>
        <script>
            if (history.forward(1)) {
                location.replace(history.forward(1))
            }
        </script>
    </head>
    <body>
<script language="javascript">
	window.location="<?php echo $insertGoTo ?>";
</script>
</body>
</html>