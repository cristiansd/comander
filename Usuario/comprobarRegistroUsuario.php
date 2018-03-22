<?php
//$usuario='cristian';
//$password='1234';
$usuario=$_POST['nick'];
$password=$_POST['password'];
$hostname_comcon = "localhost";
  $database_comcon = "eh1w1ia3_main";
  $username_comcon = "eh1w1ia3_sangar";
  $password_comcon = "290172crissan";
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon); 
mysqli_select_db($comcon, $database_comcon);  	
$regitserUsuario="SELECT * FROM usuarios_comander WHERE nick_usuario = '$usuario'AND password_usuario='$password'";
$register =  mysqli_query($comcon, $regitserUsuario);
$rows =  mysqli_fetch_array($register);
$num_rows = mysqli_num_rows($register);

$resultados = array();



if ($num_rows > 0){
    
    echo "OK";
    
   /* $resultados['respuesta']= "Validacion Correcta";
    $resultados['validacion'] = "ok";*/
    
    
}else{}
    
 /*   $resultados['respuesta']= "Usuario o password incorrecto";
$resultados['validacion'] = "error";}

$resultadosJson = json_encode($resultados);*/
//echo $_GET['jsoncallback'] . '('. $resultadosJson .')';


/*$usuarioEnviado = $_GET['nick'];
 $passwordEnviado = $_GET['password'];
 
 $resultados = array();
 $resultados['hora'] = time();
 $resultados['generador'] = "hola cristian esto es una prueba";
 
 
 $resultados['respuesta'] = "Validacion Correcta";
 $resultados['validacion'] = "ok";
 
 
 
 $resultadosJson = json_encode($resultados);
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';*/

?>