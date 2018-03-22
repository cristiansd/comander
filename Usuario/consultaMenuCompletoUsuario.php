<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$idGrupo = filter_input(INPUT_POST, 'idGrupo');

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegMenus = "SELECT * FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp = $idGrupo";
$RegMenus= mysql_query($query_RegMenus, $comcon_usuario) or die(mysql_error());
$row_RegMenus = mysql_fetch_assoc($RegMenus);
$totalRows_RegMenus = mysql_num_rows($RegMenus);

if($totalRows_RegMenus){
if(count(compararSubmenuMenuYSubmenuGrupoMenu($row_RegMenus['idMenuComandaTemp'], "comandaTemp_".$_SESSION['id_usuario']."",    
    $idGrupo))){
    echo "OK";
    }    
}
