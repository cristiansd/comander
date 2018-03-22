<?php

require_once('../includes/funcionesUsuario.php');

mysql_select_db($database_usuario, $comcon_usuario);

$mesas = "SELECT idUsuarioMesa FROM mesas WHERE idMesa= ".$_SESSION['mesa']."";
$queryMesas = mysql_query($mesas, $comcon_usuario) or die(mysql_error());
$row_mesas = mysql_fetch_assoc($queryMesas);
if ($row_mesas['idUsuarioMesa'] == null){
    echo "null";
}else{
    
echo $row_mesas['idUsuarioMesa'];
}
