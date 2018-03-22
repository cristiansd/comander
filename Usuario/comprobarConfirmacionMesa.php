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
mysql_select_db($database_usuario, $comcon_usuario);
if (isset($_GET['revalidar'])){
    $query_MesaConfirmada = "SELECT confirmacion_mesa FROM visitantes WHERE id=".$_SESSION['id_usuario'];
    $RegMesaConfirmada = mysql_query($query_MesaConfirmada, $comcon_usuario) or die(mysql_error());
    $row_MesaConfirmada = mysql_fetch_assoc($RegMesaConfirmada );
    echo $row_MesaConfirmada['confirmacion_mesa'];
}else{
$query_MesaConfirmada = "SELECT estadoMesa FROM mesas WHERE idMesa=".$_SESSION['mesa'];
$RegMesaConfirmada = mysql_query($query_MesaConfirmada, $comcon_usuario) or die(mysql_error());
$row_MesaConfirmada = mysql_fetch_assoc($RegMesaConfirmada );
echo $row_MesaConfirmada['estadoMesa'];
}
mysql_free_result($RegMesaConfirmada);

?>

