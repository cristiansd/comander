<?php

$hostname = "localhost";
$database = "eh1w1ia3_main";
$username = "eh1w1ia3_sangar";
$password = "290172crissan";
$connection = mysqli_connect($hostname, $username, $password) or trigger_error(mysqli_error(),E_USER_ERROR); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
    global $connection;
    if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connection, $theValue) : mysqli_escape_string($connection, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Validate request to login to this site.
ini_set("session.cookie_lifetime","28800");
if (!isset($_SESSION)){ 
  session_start();
}
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (isset($_POST['idEstablecimiento'])) {
  $loginUsername=$_POST['usuario'];
  $password_user=$_POST['password_user'];
  $idEstablecimiento=$_POST['idEstablecimiento'];  
  $MM_fldUserAuthorization = "nivelPermisoUsuario";
  $MM_redirecttoReferrer = false;  
}
  mysqli_select_db($connection, $database);  	
  $establecimiento__query=sprintf("SELECT nombre_establecimiento, hostname_database, name_database, username_database, password_database FROM establecimientos WHERE id_establecimiento=%s ",
  GetSQLValueString($idEstablecimiento, "int"));
  $establecimientoRS = mysqli_query($connection, $establecimiento__query) or die(mysqli_connect_error());
  $establecimiento_rows = mysqli_num_rows($establecimientoRS);
  $establecimiento_results = mysqli_fetch_array($establecimientoRS);
  
  if ($establecimiento_rows) {      
      $_SESSION['id_establecimiento'] = $idEstablecimiento;
      $_SESSION['nombre_establecimiento'] = $establecimiento_results['nombre_establecimiento'];
      $_SESSION['hostname_database'] = $establecimiento_results['hostname_database'];
      $_SESSION['name_database'] = $establecimiento_results['name_database'];
      $_SESSION['username_database'] = $establecimiento_results['username_database'];
      $_SESSION['password_database'] = $establecimiento_results['password_database'];
      
      include '../Connections/conexionComanderAdmin.php';
      
      mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);  	
      $usuario__query=sprintf("SELECT nivelPermisoUsuario FROM usuarios WHERE nickUsuario=%s AND passwordUsuario=%s",
      GetSQLValueString($loginUsername, "text"),
      GetSQLValueString($password_user, "text"));
      $usuarioRS = mysqli_query($conexionComanderAdmin, $usuario__query) or die(mysqli_connect_error());
      $usuario_rows = mysqli_num_rows($usuarioRS);
      $usuario_results = mysqli_fetch_array($usuarioRS);
      
      if ($usuario_rows) {
        if (PHP_VERSION >= 5.1) {
           session_regenerate_id(true);        
        } else {
           session_regenerate_id();        
               } 
          $loginStrGroup  = $usuario_results['nivelPermisoUsuario'];
          $_SESSION['MM_Username'] = $loginUsername;
          $_SESSION['MM_UserGroup'] = $loginStrGroup;
          $url = 'accesoCorrectoAdmin.php';       
      } else {
          $url = 'accesoUsuarioAdmin.php';
        } 
}else {
    $url = 'accesoUsuarioAdmin.php';
}
?>
<script language="javascript">
	window.location="<?php echo $url ?>";
</script>
