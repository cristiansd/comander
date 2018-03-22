<?php
header("Refresh: 5; URL='esperaConfirmacionUsuario.php'");
require_once('../Connections/conexionComanderUsuario.php'); 
$mesa=$_GET['mesa'];
$urlPrincipalUsuario = "conectarUsuario.php";
$urlRefrescar = "esperaConfirmacionUsuario.php?mesa=$mesa";
mysql_select_db($database_conexionComanderUsuario, $conexionComanderUsuario);
$query_Confirmacion = "SELECT * FROM mesas WHERE nombreMesa=".$mesa;
$RegConfirmacion = mysql_query($query_Confirmacion, $conexionComanderUsuario) or die(mysql_error());
$row_RegConfirmacion = mysql_fetch_assoc($RegConfirmacion);
$totalRows_RegConfirmacion = mysql_num_rows($RegConfirmacion);

if ($row_RegConfirmacion['estadoMesa']){?>

<script language="javascript">

function direction () {

window.location="<?php echo $urlPrincipalUsuario;?>";}

setTimeout("direction()");


</script>

    
  <?php } 
  else {?>
      
<script language="javascript">

function direction () {

window.location="<?php echo $urlRefrescar;?>";}

setTimeout("direction()",5000);


</script>
      
      <?php } ?>