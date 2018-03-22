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
$idproveedor = $_GET['param_id'];

mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
$query_categorias = "SELECT * FROM subcategorias WHERE idCategoriaSubcategoria = $idproveedor ";
$categorias = mysqli_query($conexionComanderAdmin, $query_categorias);

while($row=mysqli_fetch_array($categorias)){
	echo'<option value="'.$row['idSubcategoria'].'">'.$row['nombreSubcategoria'].'</option>';}

?>