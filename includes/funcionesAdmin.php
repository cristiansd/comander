<?php require_once('../Connections/conexionComanderAdmin.php'); 

$idioma = $_COOKIE['idioma'];
include "../strings/".$idioma.".php";

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
        global $conexionComanderAdmin;
        if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
      }
      $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conexionComanderAdmin, $theValue) : mysqli_escape_string($conexionComanderAdmin, $theValue);
    
      switch ($theType) {
        case "text":
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
          break;    
        case "long":
        case "int":
          $theValue = ($theValue != "") ? intval($theValue) : "NULL";
          break;
        case "double":
          $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
          break;
        case "date":
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
          break;
        case "defined":
          $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
          break;
      }
      return $theValue;
    }
}


function ObtenerNombreCategoria ($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM categorias WHERE idCategoria = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);
	return $row_consultaFuncion['id_string']; 
	mysqli_free_result($consultaFuncion);
}
	/***************************************
****************************************
***************************************/

function ObtenerNombreSubcategoria ($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM subcategorias WHERE subcategorias.idSubcategoria = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);
	return $row_consultaFuncion['id_string']; 
	mysqli_free_result($consultaFuncion);
}
	/***************************************
****************************************
***************************************/
function ObtenerNombreSubmenu ($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM submenus WHERE idSubmenu = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	return $row_consultaFuncion['id_string']; 
	mysqli_free_result($consultaFuncion);
}
	/***************************************
****************************************
***************************************/
function ObtenerNombreMenu ($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM menus WHERE idMenu = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_error($conexionComanderAdmin));
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	return $row_consultaFuncion['id_string'];   
	mysqli_free_result($consultaFuncion);
}
	/***************************************
****************************************
***************************************/
function ObtenerImagen($Imagen)
{
		if ($Imagen!="")
	{
		echo $Imagen;
		}
	else 
	{
		echo "sinImagen.png"; }
	
	}

/***************************************
****************************************
***************************************/
function ConsultaRowsBD($tabla, $campoID,$valorID ){
	if ($valorID !=""){
		$sintaxi="SELECT * FROM $tabla WHERE $campoID = $valorID";
	}else{
		$sintaxi="SELECT * FROM $tabla";
	}
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consulta = sprintf($sintaxi);
	$consulta = mysqli_query($conexionComanderAdmin, $query_consulta) or die(mysqli_connect_error());
	$row_consulta = mysqli_fetch_assoc($consulta);
	$totalRows_consulta = mysqli_num_rows($consulta);
	return ($row_consulta);
	
	
	}

/***************************************
****************************************
***************************************/
function ConsultaNick( $valorID ){	
        $sintaxi="SELECT nickUsuario FROM usuarios WHERE idUsuario = $valorID";	
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consulta = sprintf($sintaxi);
	$consulta = mysqli_query($conexionComanderAdmin, $query_consulta) or die(mysqli_connect_error());
	$row_consulta = mysqli_fetch_assoc($consulta);
	$totalRows_consulta = mysqli_num_rows($consulta);        
        $usuarioDevuelto = $row_consulta['nickUsuario'];
	return ($usuarioDevuelto);
	
	
	}
	
	/***************************************
****************************************
***************************************/
function ConsultaBD($tabla, $campoID,$valorID ){
	if ($valorID !=""){
		$sintaxi="SELECT * FROM $tabla WHERE $campoID = $valorID";
	}else{
		$sintaxi="SELECT * FROM $tabla";
	}
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consulta = sprintf($sintaxi);
	$consulta = mysqli_query($conexionComanderAdmin, $query_consulta) or die(mysqli_connect_error());
	$row_consulta = mysqli_fetch_assoc($consulta);
	$totalRows_consulta = mysqli_num_rows($consulta);
	return ($consulta);
	
	
	}

/***************************************
****************************************
***************************************/
function ConsultaNoRowsBD($tabla, $campoID,$valorID ){
	if ($valorID !=""){
		$sintaxi="SELECT * FROM $tabla WHERE $campoID != $valorID";
	}else{
		$sintaxi="SELECT * FROM $tabla";
	}
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consulta = sprintf($sintaxi);
	$consulta = mysqli_query($conexionComanderAdmin, $query_consulta) or die(mysqli_connect_error());
	$row_consulta = mysqli_fetch_assoc($consulta);
	$totalRows_consulta = mysqli_num_rows($consulta);
	return ($row_consulta);
	
	
	}
	
	/***************************************
****************************************
***************************************/
function ConsultaNoBD($tabla, $campoID,$valorID ){
	if ($valorID !=""){
		$sintaxi="SELECT * FROM $tabla WHERE $campoID != $valorID";
	}else{
		$sintaxi="SELECT * FROM $tabla";
	}
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consulta = sprintf($sintaxi);
	$consulta = mysqli_query($conexionComanderAdmin, $query_consulta) or die(mysqli_connect_error());
	$row_consulta = mysqli_fetch_assoc($consulta);
	$totalRows_consulta = mysqli_num_rows($consulta);
	return ($consulta);
	
	
	}

	/***************************************
****************************************
***************************************/
function ObtenerNombreZona($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM zonas WHERE idZona = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);	
	return  $row_consultaFuncion['id_string'];
	mysqli_free_result($consultaFuncion);
}


/***************************************
****************************************
***************************************/
function ObtenerNombreOferta ($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT nombreOferta FROM ofertas WHERE idOferta = %s",
	$identificador);
	$consultaFuncion = mysql_query($query_consultaFuncion, $conexionComanderAdmin) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);
	return $row_consultaFuncion['nombreOferta']; 
	mysqli_free_result($consultaFuncion);
}

/***************************************
****************************************
***************************************/
function ObtenerNombreSuboferta ($identificador){
        global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT nombreSuboferta FROM subcategoriasofertas WHERE idSuboferta = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);
	return $row_consultaFuncion['nombreSuboferta']; 
	mysqli_free_result($consultaFuncion);
}

	/***************************************
****************************************
***************************************/
function ObtenerImagenProductoMenu($identificador){
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM productos WHERE idProducto = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	return $row_consultaFuncion['id_imagen']; 
	mysqli_free_result($consultaFuncion);
	
	}
	
	/***************************************
****************************************
***************************************/
function ObtenerNombreProductoMenu($identificador){
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM productos WHERE idProducto = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);
	return $row_consultaFuncion['id_string']; 
	mysqli_free_result($consultaFuncion);
	
	}
	
		/***************************************
****************************************
***************************************/
function RecuperarEstadoProducto($identificador){
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT estadoProducto FROM productos WHERE idProducto = %s",
	$identificador);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
	$totalRows_consultaFuncion = mysqli_num_rows($consultaFuncion);
	return $row_consultaFuncion['estadoProducto']; 
	mysqli_free_result($consultaFuncion);
	
	}
	
			/***************************************
****************************************
***************************************/
function conexiones() 
{ 



$tiempo_logout = 600; // segundos tras los cuales un usuario es marcado como inactivo

$arr = file("usuarios.dat");
$contenido = $REMOTE_ADDR.":".time()." ";

for ( $i = 0 ; $i < sizeof($arr) ; $i++ )
{
$tmp = explode(":",$arr[$i]);
if (( $tmp[0] != $REMOTE_ADDR ) && (( time() - $tmp[1] ) < $tiempo_logout ))
{
$contenido .= $REMOTE_ADDR.":".time()." ";
}
}

$fp = fopen("usuarios.dat","w");
fputs($fp,$contenido);
fclose($fp);

$array = file("usuarios.dat");

$USUARIOS_ACTIVOS = count($array);



}  

			/***************************************
****************************************
***************************************/
function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad){	
            $img = ImageCreateFromJPEG($img_original);
            $thumb = imagecreatetruecolor($img_nueva_anchura,$img_nueva_altura);
            ImageCopyResized($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,ImageSX($img),ImageSY($img));
            ImageJPEG($thumb,$img_nueva,$img_nueva_calidad);
            ImageDestroy($img);
            }


	/***************************************
****************************************
***************************************/
function recuperarString($idString){
	global $database_conexionComanderAdmin, $conexionComanderAdmin;
        $string = "";
	mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
	$query_consultaFuncion = sprintf("SELECT * FROM strings WHERE id = %s",
	$idString);
	$consultaFuncion = mysqli_query($conexionComanderAdmin, $query_consultaFuncion) or die(mysqli_connect_error());
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
        switch ($_COOKIE['idioma']){
            case "es":
                $string = $row_consultaFuncion['spanish'];
                break;
            case "en":
                $string = $row_consultaFuncion['ingles'];
                break;
            case "ca":
                $string = $row_consultaFuncion['catalan'];
                break;
        }
	return $string;
	
	}




?>