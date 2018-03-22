<?php require_once('../includes/funcionesUsuario.php'); 

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";
include '../includes/errorIdentificacionUsuario.php';

//DECLARAMOS LAS VARIABLES QUE SE UTILIZARAN

$cantidad = 1;
$comentario="";

//CREAMOS UNA FUNCION PARA SORTEAR UN NUMERO PARA EL GRUPO DE MENU DE COMANDA 

function idGrupoComanda(){
    global $idGrupoMenuComandaTemp;
    $idGrupoMenuComandaTemp = mt_rand(1,9999999);
}


//RECOGEMOS TODOS LOS DATOS QUE SE HAN PASASDO Y SE PROCESAN

if ((isset($_POST['idProducto']))) {
$precioProducto = recuperaPrecio($_POST['idProducto']);
$cantidad=$_POST['cantidad'];
$precioTotal = $precioProducto*$_POST['cantidad'];
$idProducto = $_POST['idProducto'];
$comentario=$_POST['comentario'];
$idMenu = "";
$idSubmenu = "";
$esmenu = 0;
$idGrupoMenuComandaTemp = "";
 
}


if (filter_input(INPUT_POST, 'idMenu')){
    $idMenu = filter_input(INPUT_POST, 'idMenu');
}

if (filter_input(INPUT_POST, 'idSubmenu')){
    $idSubmenu = filter_input(INPUT_POST, 'idSubmenu');
}
if(filter_input(INPUT_POST, 'esmenu')){
    $esmenu = filter_input(INPUT_POST, 'esmenu');
    if (filter_input(INPUT_POST, 'idGrupoComanda')){
        $idGrupoMenuComandaTemp = filter_input(INPUT_POST, 'idGrupoComanda');
    } else {
    idGrupoComanda();
    }
}

//COMPROBAMOS SI EXISTE UNA TABLA TEMPORAL DE COMANDAS DEL USUARIO

mysql_select_db($database_usuario, $comcon_usuario);
$result = "show tables like 'comandaTemp_".$_SESSION['id_usuario']."'";
$resultados=mysql_query($result, $comcon_usuario) or die(mysql_error());
$existe = mysql_num_rows($resultados);

//SI NO EXISTE CREAMOS UNA TABLA A MODO TEMPORAL PARA IR CARGANDO LOS PRODUCTOS ANTES DE REALIZAR EL PEDIDO

if (!$existe){
$crearTablaTemporal="CREATE  TABLE comandaTemp_".$_SESSION['id_usuario']." (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
idProductoComandaTemp INT,
cantidadComandaTemp INT,
totalComandaTemp DOUBLE,
comentarioComandaTemp VARCHAR(100),
idMenuComandaTemp INT,
idSubmenuComandaTemp INT,
idGrupoMenuComandaTemp INT)";
mysql_query($crearTablaTemporal, $comcon_usuario) or die(mysql_error());
}

if(filter_input(INPUT_POST, 'listaMenu')){
$listaProductos = json_decode(filter_input(INPUT_POST, 'listaMenu'));
    
    $completado ="OK";
    idGrupoComanda(); 

    foreach($listaProductos as $producto){
        
        $idProducto = $producto->idProductoPedir;
        $idMenu = $producto->idMenu;
        $idSubmenu = $producto->idSubmenu;
        
        $comentario = $producto->comentario;
        
        $precioTotal = "";
        
        $insertSQL = sprintf("INSERT INTO comandaTemp_"
        .$_SESSION['id_usuario']." (idProductoComandaTemp, cantidadComandaTemp, totalComandaTemp,comentarioComandaTemp, "
        . "idMenuComandaTemp, idSubmenuComandaTemp, idGrupoMenuComandaTemp) "
        . "VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($idProducto, "int"),
        GetSQLValueString($cantidad, "int"),
        GetSQLValueString($precioTotal, "double"),
        GetSQLValueString($comentario, "text"),
        GetSQLValueString($idMenu, "int"),
        GetSQLValueString($idSubmenu,"int"),
        GetSQLValueString($idGrupoMenuComandaTemp, "int"));
        $resultado=mysql_query($insertSQL, $comcon_usuario) or die(mysql_error());
        if(!$resultado){
            $delete = "DELETE FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp=$idGrupoMenuComandaTemp";
            mysql_query($delete, $comcon_usuario);
            $completado = "ERROR";
            break;
        } 
    }
    
    echo $completado;
    
} else {
    
    if (!$esmenu){
    $insertSQL = sprintf("INSERT INTO comandaTemp_".$_SESSION['id_usuario']." (idProductoComandaTemp, cantidadComandaTemp, totalComandaTemp,comentarioComandaTemp) "
            . "VALUES (%s, %s, %s,%s)",
                           GetSQLValueString($idProducto, "int"),
                           GetSQLValueString($cantidad, "int"),
                           GetSQLValueString($precioTotal, "double"),
                           GetSQLValueString($comentario,"text"));
    }else{
       $insertSQL = sprintf("INSERT INTO comandaTemp_".$_SESSION['id_usuario']." (idProductoComandaTemp, cantidadComandaTemp, totalComandaTemp,comentarioComandaTemp, "
               . "idMenuComandaTemp, idSubmenuComandaTemp, idGrupoMenuComandaTemp) "
            . "VALUES (%s, %s, %s, %s, %s, %s, %s)",
                           GetSQLValueString($idProducto, "int"),
                           GetSQLValueString($cantidad, "int"),
                           GetSQLValueString($precioTotal, "double"),
                           GetSQLValueString($comentario, "text"),
                           GetSQLValueString($idMenu, "int"),
                           GetSQLValueString($idSubmenu,"int"),
                           GetSQLValueString($idGrupoMenuComandaTemp, "int")); 
    }


$resultado=mysql_query($insertSQL, $comcon_usuario) or die(mysql_error());
if($resultado){
  echo "OK";
}
}

?>

