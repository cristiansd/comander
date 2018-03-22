<?php 
  $emailUser=$_GET['email'];
  $keyAccess=$_GET['key'];
  $establecimiento = $_GET['establecimiento'];
  $mesa=$_GET['mesa'];
// *** Validate request to login to this site.

if (!isset($_SESSION)){ 
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}


  
  $MM_fldUserAuthorization = "nivel_permiso";
  $MM_redirecttoReferrer = true;
  
  $hostname_comcon = "localhost";
  $database_comcon = "eh1w1ia3_main";
  $username_comcon = "eh1w1ia3_sangar";
  $password_comcon = "290172crissan";
  $comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon) or trigger_error(mysql_error(),E_USER_ERROR); 
  
  mysqli_select_db($comcon, $database_comcon);  	
  $LoginRS__query= "SELECT id_usuario, nick_usuario, password_usuario, nivel_permiso FROM usuarios_comander WHERE email_usuario='$emailUser' AND key_access='$keyAccess'";    
  $LoginRS = mysqli_query($comcon, $LoginRS__query) or die(mysql_error());
  $LoginRS_rows = mysqli_fetch_array($LoginRS);  
  $loginFoundUser = mysqli_num_rows($LoginRS);
  
  
  
  
  
if ($loginFoundUser) {
    $loginStrGroup  = $LoginRS_rows['nivel_permiso'];
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
        
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $LoginRS_rows['nick_usuario'];
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
    $_SESSION['establecimiento'] = $establecimiento;
    $_SESSION['mesa'] = $mesa;
    $_SESSION['id_usuario']=$LoginRS_rows['id_usuario'];
    $_SESSION['permiso']=$LoginRS_rows['nivel_permiso'];
    
   
    
    //prueba de conexion a variables de sesion para conectar a otra db    
    mysqli_select_db($comcon, $database_comcon );
    $establecimiento__query="SELECT hostname_database, name_database, username_database,password_database FROM establecimientos WHERE id_establecimiento='$establecimiento'";
    $establecimientoRS = mysqli_query($comcon, $establecimiento__query) or die(mysql_error());  
    $establecimientoRS_rows = mysqli_fetch_array($establecimientoRS);  
    $_SESSION['hostname_database']=$establecimientoRS_rows['hostname_database'];
    $_SESSION['name_database']=$establecimientoRS_rows['name_database'];
    $_SESSION['username_database']=$establecimientoRS_rows['username_database'];
    $_SESSION['password_database']=$establecimientoRS_rows['password_database'];
   // echo $_SESSION['hostname_database']. $_SESSION['name_database'].$_SESSION['username_database'].  $_SESSION['password_database'];
        
        $url = 'principalUsuario.php';
        } else {
              $url = 'prueba.php';
        } 

//header("Cache-Control: no-cache, must-revalidate"); // Evitar guardado en cache del cliente HTTP/1.1
//header("Pragma: no-cache"); // Evitar guardado en cache del cliente HTTP/1.0*/
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, user-scalable=no">
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
<style type="text/css">
    .loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../estilos/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
        }
</style>    
<body>
    <div class="loading"></div>
 <script language="javascript">
	window.open('<?php echo $url ?>','_self');
</script>
</body>
</html>