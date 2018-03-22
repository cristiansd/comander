 <?php  
  require_once('../includes/funcionesUsuario.php');
    if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['user'])){
    $user = $_GET['user'];
}
        mysql_select_db($database_usuario,$comcon_usuario);
        $query_MesaRevalidar = "UPDATE visitantes SET confirmacion_mesa=1 WHERE id=".$user;
        $RegMesaRevalidar = mysql_query( $query_MesaRevalidar,$comcon_usuario ) or die(mysql_error());
        

?>

<script type="text/javascript">
    window.open("principalUsuario.php");
    </script>