<?php 
require_once('../Connections/conexionComanderEnvCam.php');
require_once('../includes/funcionesEnvCam.php'); 

$cgmId = "FALLO EN ELIMINACION";
if ((isset($_POST["cgmId"]))) {
  $cgmId = $_POST["cgmId"];
  mysql_select_db($database_comcon, $comcon);
  //COMPRUEBO QUE NO EXISTE
  $sql_comprueba = sprintf("SELECT registration_id FROM tblregistration WHERE registration_id=%s",GetSQLValueString($cgmId, "text"));
  $compruebaRS = mysql_query($sql_comprueba, $comcon) or die(mysql_error());
  $cgmUser = mysql_num_rows($compruebaRS);
  if ($cgmUser) {
    $insertSQL = sprintf("DELETE FROM tblregistration WHERE registration_id=%s", GetSQLValueString($cgmId, "text"));
    $Result = mysql_query($insertSQL, $comcon) or die(mysql_error());
  }
}
?>

