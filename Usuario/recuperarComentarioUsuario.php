<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

if ((isset($_POST["idComanda"]))) {

    $idComanda = $_POST["idComanda"];

    mysql_select_db($database_usuario, $comcon_usuario);

    $query_recogeComentario = "SELECT comentarioComandaTemp FROM comandatemp_".$_SESSION['id_usuario']." WHERE id=$idComanda";

    $recogeComentario = mysql_query($query_recogeComentario, $comcon_usuario) or die(mysql_error());

    $row_recogeComentario = mysql_fetch_assoc($recogeComentario);

    $totalRows_recogeComentario = mysql_num_rows($recogeComentario);

    mysql_free_result($recogeComentario);

    echo utf8_encode($row_recogeComentario['comentarioComandaTemp']);
   
}

?>