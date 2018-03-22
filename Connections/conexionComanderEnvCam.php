<?php 
if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

//$errorIdentificacionEnvCam.php
/*$MM_restrictGoTo = "page-loader.gif";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}*/


# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_comcon = $_SESSION['hostname_database'];
$database_comcon = $_SESSION['name_database'];
$username_comcon = $_SESSION['username_database'];
$password_comcon = $_SESSION['password_database'];
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon) or trigger_error(mysqli_error(),E_USER_ERROR); 
?>