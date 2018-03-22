<?php
 $id = filter_input(INPUT_GET,'id');
 $cantidad = filter_input(INPUT_GET,'cantidad');
 
 //DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;
 
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon) or trigger_error(mysql_error(),E_USER_ERROR); 

mysqli_select_db($comcon, $database_comcon);  	
$LoginRS__query= "SELECT pago_metalico, pago_tarjeta, auto_pago, max_autopago FROM establecimientos WHERE id_establecimiento = '$id'";    
$LoginRS = mysqli_query($comcon, $LoginRS__query) or die(mysqli_error($comcon));
$LoginRS_rows = mysqli_fetch_array($LoginRS);  
$loginFoundUser = mysqli_num_rows($LoginRS);

$autopago = '0';

if ($LoginRS_rows['auto_pago']){
    if( $cantidad <= $LoginRS_rows['max_autopago']){
        $autopago = '1';
    } 
} 

do{

//Y GENERAMOS EL ARCHIVO DE DEVOLUCION
$jsondata[$control]['metalico'] = $LoginRS_rows['pago_metalico'];
$jsondata[$control]['tarjeta'] = $LoginRS_rows['pago_tarjeta'];
$jsondata[$control]['autopago'] = $autopago;
$control++;
} while ($LoginRS_rows = mysqli_fetch_array($LoginRS));

//POR ULTIMO DEVOLVEMOS EL ARCHIVO
    echo $_GET['callback'].'('.json_encode($jsondata).')';
    exit;
