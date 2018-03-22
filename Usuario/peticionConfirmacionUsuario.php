<?php require_once('../includes/funcionesUsuario.php'); 
include '../Gcm/sending_push.php';


if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";


$MM_restrictGoTo = "prueba3.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
    
    print_r($_SESSION);

}
//Aqui pondriamos el codigo de envio de noificacion a los camareros
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<link href="jquery-mobile/jquery.mobile.theme-1.4.5.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile.structure-1.4.5.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="jquery-mobile/jquery.js"></script>
<script type="text/javascript" src="jquery-mobile/jquery.mobile-1.4.5.min.js"></script>
<style type="text/css">
* #container {
	min-height: 500px;
	height: 500px;
	margin-bottom: 50px;
}
.centrar {
	text-align: center;
	margin-right: 10px;
	margin-left: 10px;
	padding-top: 40px;
}
.derecha {
	text-align: right;
	float: right;
}

body {
	
        background-color: rgb(0, 255, 0);
	background-repeat: repeat-x;
}
.ui-page {
	background: transparent;
}
.ui-content {
	background: transparent;
}
.bienvenido {
	margin-bottom: 10px;
	color: #CF3;
}
#page #container div .centrar .bienvenido em strong {
	color: #FFFFFF;
}
.botonsalir {
	width: 50%;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.margensup {
	margin-top: 50px;
}
</style>
<script src="jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
<meta name="viewport" content="width=device-width"/>
</head>
<body>
<?php
$direction;
//COMPROBAMOS SI ESTA REGISTRADO EL USUARIO Y SI NO ES ASI LO REGISTRAMOS.
//SI YA ESTA REGISTRADO SE RECOGE  SU NIVEL DE PERMISO Y SE LE REFERENCIA A SU SESION.
mysql_select_db($database_usuario, $comcon_usuario);
$query_visitante = "SELECT * FROM visitantes WHERE id=".$_SESSION['id_usuario'];
$Regvisitante= mysql_query($query_visitante, $comcon_usuario) or die(mysql_error());
$row_visitante = mysql_fetch_assoc($Regvisitante );
$totalRows_Regvisitante = mysql_num_rows($Regvisitante);

//ESTABLECEMOS LOS PERMISOS DEL ESTABLECIMIENTO PARA TODA LA SESION
if ($totalRows_Regvisitante>0){
    $loginStrGroup=$row_visitante['permiso'];
}

//COMPROBAMOS SI EL USUARIO YA HA ESTADO EN EL ESTABLECIMIENTO SI NO SE LE REGISTRA
if (!$totalRows_Regvisitante>0){
    mysql_select_db($database_usuario, $comcon_usuario);
   //$insert_visitante="INSERT INTO visitantes VALUES(".$_SESSION['id_usuario'].",". $_SESSION['permiso'].",now(),1)";
    $insert_visitante="INSERT INTO visitantes VALUES(".$_SESSION['id_usuario'].",". $_SESSION['permiso'].",1,".$_SESSION['mesa']." , 0, 0, now(),1)";
    mysql_query($insert_visitante, $comcon_usuario) or die(mysql_error());
    $row_visitante['permiso']=1;
    $row_visitante['cantidad_visitas']=0;
}
//SI YA LO HA ESTADO COMPROBAMOS EL NIVEL DE PERMISOS QUE TIENE QUE POR DEFECTO ES VERDADERO SI NO SE LO HAN CAMBIADO EN EL ESTABLECIMIENTO
//SI EL PERMISO EL FALSO SE LE EXPULSA DE LA APLICACION 
 if($row_visitante['permiso']){
//SI EL NIVEL DE PERMISO ES VERDADERO SE CAMBIA LA FECHA/HORA DE LA ULTIMA VISITA, SE LE SUMA UNA VISITA Y SE CONTINUA CON EL PROGRAMA

mysql_select_db($database_usuario, $comcon_usuario);   
$set_visitante="UPDATE visitantes SET ultima_visita=now(), cantidad_visitas=".($row_visitante['cantidad_visitas']+1)." WHERE id=".$_SESSION['id_usuario'];
mysql_query($set_visitante, $comcon_usuario) or die(mysql_error());

//COMPROBAMOS SI LA MESA NO ESTA OCUPADA Y REALIZAMOS LA PETICION
mysql_select_db($database_usuario, $comcon_usuario);
$query_MesaConfirmada = "SELECT * FROM mesas WHERE idMesa=".$_SESSION['mesa'];
$RegMesaConfirmada = mysql_query($query_MesaConfirmada, $comcon_usuario) or die(mysql_error());
$row_MesaConfirmada = mysql_fetch_assoc($RegMesaConfirmada );

if($row_MesaConfirmada['estadoMesa']){  

       /* $query_adminMesa = "SELECT * FROM visitantes WHERE id_mesa=".$_SESSION['mesa']." AND activo=1 ORDER BY ultima_visita";
        $RegAdminMesa= mysql_query($query_adminMesa, $comcon_usuario) or die(mysql_error());
        $row_AdminMesa = mysql_fetch_assoc($RegAdminMesa );
        $totalRows_RegAdminMesa = mysql_num_rows($RegAdminMesa);
        envioAUno( $row_AdminMesa['id'], 'revalidar');
        mysql_free_result($RegAdminMesa);*/
        //$direction="comprobarConfirmacionMesa.php?revalidar";
        $direction="principalUsuario.php";
}else{
    envioGCM(1, "MESAS", "");
    $queryPedirMesa = "UPDATE mesas SET peticionMesa='1' WHERE idMesa=".$_SESSION['mesa'];   
    $RegPedirMesa = mysql_query($queryPedirMesa, $comcon_usuario) or die(mysql_error());    
    mysql_free_result($RegMesaConfirmada);
    $direction="comprobarConfirmacionMesa.php";
}?>
    <div data-role="page" id="page">
    <div id="container">
        
     <?php include ("../includes/cabeceraUsuario.php"); ?>
        
    <br>
    <br>
    <div class="margensup"> 
    <div class="centrar" >
    <img src="../Imagenes/UsuarioImages/esperandoConfirmacion.jpg" width="250" height="250" style="display:none;" class="esperandoConfirmacion" />  
    <img src="../Imagenes/UsuarioImages/refresco.gif" width="250" height="250" style="display:none;" class="refresco" />  
    <script type="text/javascript"> 
                    
                  var control=0;
                    
                  function mensaje(){
                      
                     
                     $(document).ready(function(){
                          if (control==0){
                          $('.esperandoConfirmacion').fadeIn(2500);
                          $('.esperandoConfirmacion').fadeOut(2500);                        
                         
                                }
                                
                          if (control==1){
                          $('.refresco').fadeIn(5000);
                          $('.refresco').fadeOut(2500);
                          
                                 }
                                 
                           });
                       }
                       
                       function confirmacion(){
                      var confirmada = $.ajax({
                                url:'<?php echo $direction; ?>', //indicamos la ruta donde se genera la hora
                                dataType: 'text',//indicamos que es de tipo texto plano
                                async: false     //ponemos el parámetro asyn a falso
                            }).responseText;
                                if (confirmada==0){
                                   mensaje();                               
   
                                }else{
                                     //window.print(confirmada);
                                     window.location="principalUsuario.php";
                                }
                            }
                      setInterval(confirmacion,1000);
    </script>
    </div>
    </div>
    </div>
    </div>
   
    </div> 
    <?php
   
}else{ ?>
    <script language="javascript">
    window.location="sinPermisoEstablecimientoUsuario.php";
    </script>
<?php }

    ?>
    </body>
    </html>


