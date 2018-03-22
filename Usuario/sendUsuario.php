<?php

require_once('../includes/funcionesUsuario.php');
require_once('../Gcm/sending_push.php');

if (!isset($_SESSION)) {
    session_start();
}

mysql_select_db($database_usuario, $comcon_usuario);

//EN EL CASO QUE EXISTA PEDIDO Y CAMARERO

if (filter_input(INPUT_POST, 'idPedido')) {
    
    if (filter_input(INPUT_POST, 'idCamarero')) {
        
        $tipo = filter_input(INPUT_POST, 'tipo');
        
        $destinatario = $_SESSION['idCamarero'];
        
        $insertSQL = sprintf("INSERT INTO notificaciones "
            . " (idUsuarioNotificaciones, idMesaNotificaciones, mensajeNotificaciones, idCamareroNotificaciones, idPedido, tipoNotificacion) "
            . "VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString(filter_input(INPUT_POST, 'idUsuario'), "int"),
            GetSQLValueString($_SESSION['mesa'], "int"),
            GetSQLValueString(filter_input(INPUT_POST, 'mensaje'), "text"),
            GetSQLValueString(filter_input(INPUT_POST, 'idCamarero'),"int"),
            GetSQLValueString(filter_input(INPUT_POST, 'idPedido'), "int"),
            GetSQLValueString(4, "int"));
        
            if($resultados = mysql_query($insertSQL, $comcon_usuario) or die(mysql_error())){
                envioGCM($_SESSION['establecimiento'], "NOTIFICACIONES", $destinatario);
            echo "OK";
        }
    }else{
    
//EN EL CASO QUE EXISTA PEDIDO PERO NO CAMARERO
        
    $titulo = "MESAS";
    
    $insertSQL = sprintf("INSERT INTO notificaciones "
            . " (idUsuarioNotificaciones, idMesaNotificaciones, mensajeNotificaciones, idCamareroNotificaciones, idPedido, leidoNotificaciones,tipoNotificacion) "
            . "VALUES (%s, %s, %s,%s,%s,%s, %s)",
            GetSQLValueString(filter_input(INPUT_POST, 'idUsuario'), "int"),
            GetSQLValueString($_SESSION['mesa'], "int"),
            GetSQLValueString(filter_input(INPUT_POST, 'mensaje'), "text"),
            GetSQLValueString(filter_input(INPUT_POST, 'idCamarero'),"int"),
            GetSQLValueString(filter_input(INPUT_POST, 'idPedido'), "int"),
            GetSQLValueString(0,"int"),
            GetSQLValueString(5,"int"));
    
    if($resultados = mysql_query($insertSQL, $comcon_usuario) or die(mysql_error())){
        envioGCM($_SESSION['establecimiento'], "MESAS", "");
        echo "OK";
        }   
    }
    
//EN EL CASO QUE EXISTA CAMARERO Y NO PEDIDO O SEA NO SE REALIZA PEDIDO
    
}else if (filter_input(INPUT_POST, 'idCamarero')) {
     $tipo = filter_input(INPUT_POST, 'tipo');
     
    $insertSQL = sprintf("INSERT INTO notificaciones "
            . " (idUsuarioNotificaciones, idMesaNotificaciones, mensajeNotificaciones, idCamareroNotificaciones, tipoNotificacion) "
            . "VALUES (%s, %s, %s,%s, %s)",
            GetSQLValueString(filter_input(INPUT_POST, 'idUsuario'), "int"),
            GetSQLValueString($_SESSION['mesa'], "int"),
            GetSQLValueString(filter_input(INPUT_POST, 'mensaje'), "text"),
            GetSQLValueString(filter_input(INPUT_POST, 'idCamarero'),"int"),
            GetSQLValueString($tipo, "int"));
    
            if($resultados = mysql_query($insertSQL, $comcon_usuario) or die(mysql_error())){
                envioGCM($_SESSION['establecimiento'], 'NOTIFICACIONES', filter_input(INPUT_POST, 'idCamarero'));
            echo "OK";
        }
        
//EN EL CASO QUE NO EXISTA NI CAMARERO NI PEDIDO
        
    } else {
        $insertSQL = sprintf("INSERT INTO notificaciones "
                . " (idUsuarioNotificaciones, idMesaNotificaciones, mensajeNotificaciones, tipoNotificacion) "
                . "VALUES (%s, %s, %s, %s)",
                GetSQLValueString(filter_input(INPUT_POST, 'idUsuario'), "int"),
                GetSQLValueString($_SESSION['mesa'], "int"),
                GetSQLValueString(filter_input(INPUT_POST, 'mensaje'), "text"),
                GetSQLValueString(filter_input(INPUT_POST, 'tipo'), "int"));

                if($resultados = mysql_query($insertSQL, $comcon_usuario) or die(mysql_error())){
                    envioGCM($_SESSION['establecimiento'], "NOTIFICACIONES", "");
                echo "OK";
            }
        }


