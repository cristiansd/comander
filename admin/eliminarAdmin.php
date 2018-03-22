<?php
require_once('../includes/funcionesAdmin.php');

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "entrarAdmin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$varCategoria_Recordset1 = "0";
mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);

/* variable de productosMenu */
if (isset($_GET["productoSup"])){
$idAeliminar=$_GET["productoSup"];
$tabla="productosmenu";
$varibleConsulta="productosmenu.idProductosmenu";
$consulta_Recordset1 = $_GET["productoSup"];
$volver="administracionMenusAdmin.php";
}
/* **********************************
**********************************
********************************** */

/* variable de categoria */
if (isset($_GET["CategoriaSup"])){
$idAeliminar=$_GET["CategoriaSup"];
$tabla="categorias";
$varibleConsulta="categorias.idCategoria";
$consulta_Recordset1 = $_GET["CategoriaSup"];
$volver="administracionCategoriaAdmin.php";

$consulta_productos = "SELECT * FROM productos WHERE idCategoriaProducto = '$idAeliminar'";
$productos_query = mysqli_query($conexionComanderAdmin, $consulta_productos) or die(mysqli_error($conexionComanderAdmin));
$rows_productos = mysqli_fetch_assoc($productos_query);
do{
    $idProducto = $rows_productos['idProducto'];
    $idStringNutricional = $rows_productos['id_string_nutricional'];
    $idStringAlergenos = $rows_productos['id_string_alergenos'];
    $idStringDescripcion = $rows_productos['id_string_descripcion'];
    $idString = $rows_productos['id_string'];
    $imagen = $rows_productos['id_imagen'];
    $consulta_productosMenu = "SELECT * FROM productosmenu WHERE idProducto = '$idProducto'";
    $consultaProductosMenu_query = mysqli_query($conexionComanderAdmin, $consulta_productosMenu) or die (mysqli_error($conexionComanderAdmin));
    $total_rows_productosMenu = mysqli_num_rows($consultaProductosMenu_query);
    if($total_rows_productosMenu){
    $productosMenu_eliminar = "DELETE FROM productosmenu WHERE idProducto = '$idProducto'";
    mysqli_query($conexionComanderAdmin, $productosMenu_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringNutricional){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringNutricional'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringAlergenos){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringAlergenos'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringDescripcion){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringDescripcion'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    $string_eliminar = "DELETE FROM strings WHERE id = '$idString'";
    mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    if($imagen != 0){
    $imagen_eliminar = "DELETE FROM imagenes WHERE id = '$imagen'";
    mysqli_query($conexionComanderAdmin, $imagen_eliminar) or die(mysqli_error($conexionComanderAdmin));  
    }
}while($rows_productos = mysqli_fetch_assoc($productos_query));

$producto_eliminar = "DELETE FROM productos WHERE idCategoriaProducto = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $producto_eliminar) or die(mysqli_error($conexionComanderAdmin));  

$consulta_subcategorias = "SELECT * FROM subcategorias WHERE idCategoriaSubcategoria = '$idAeliminar'";
$subcategoria_query = mysqli_query($conexionComanderAdmin, $consulta_subcategorias) or die (mysqli_error($conexionComanderAdmin));
$rows_subcategorias = mysqli_fetch_array($subcategoria_query);
do{
    $idStringSubcategorias = $rows_subcategorias['id_string'];
    $idImagenSubcategorias = $rows_subcategorias['id_imagen'];
    $string_eliminar = "DELETE FROM strings WHERE id = '$idStringSubcategorias'";
    mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    if($idImagenSubcategorias != 0){
    $imagen_eliminar = "DELETE FROM imagenes WHERE id = '$idImagenSubcategorias'";
    mysqli_query($conexionComanderAdmin, $imagen_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
}while($rows_subcategorias = mysqli_fetch_array($subcategoria_query));

$subcategorias_eliminar = "DELETE FROM subcategorias WHERE idCategoriaSubcategoria = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $subcategorias_eliminar) or die(mysqli_error($conexionComanderAdmin));

$consulta_categoria="SELECT * FROM categorias WHERE idCategoria = '$idAeliminar'";
$categoria_query = mysqli_query($conexionComanderAdmin, $consulta_categoria) or die(mysqli_error($conexionComanderAdmin));
$row_categoria = mysqli_fetch_assoc($categoria_query);
do{
    $idStringCategoria = $row_categoria['id_string'];
    $idImagenCategoria = $row_categoria['id_imagen'];
    $string_eliminar = "DELETE FROM strings WHERE id = '$idStringCategoria'";
    mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    if($idImagenCategoria != 0){
    $imagen_eliminar = "DELETE FROM imagenes WHERE id = '$idImagenCategoria'";
    mysqli_query($conexionComanderAdmin, $imagen_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
}while($row_categoria = mysqli_fetch_assoc($categoria_query));

$categoria_eliminar = "DELETE FROM categorias WHERE idCategoria = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $categoria_eliminar) or die(mysqli_error($conexionComanderAdmin));

header("Location: administracionCategoriaAdmin.php");

}
/* **********************************
**********************************
********************************** */

/* variable de subcategoria */
if (isset($_GET["SubcategoriaSup"])){
$idAeliminar=$_GET["SubcategoriaSup"];
$tabla="subcategorias";
$varibleConsulta="subcategorias.idSubcategoria";
$consulta_Recordset1 = $_GET["SubcategoriaSup"];
$volver="administracionSubcategoriasAdmin.php";

$consulta_productos = "SELECT * FROM productos WHERE idSubcategoriaProducto = '$idAeliminar'";
$productos_query = mysqli_query($conexionComanderAdmin, $consulta_productos) or die(mysqli_error($conexionComanderAdmin));
$rows_productos = mysqli_fetch_assoc($productos_query);
do{
    $idProducto = $rows_productos['idProducto'];
    $idStringNutricional = $rows_productos['id_string_nutricional'];
    $idStringAlergenos = $rows_productos['id_string_alergenos'];
    $idStringDescripcion = $rows_productos['id_string_descripcion'];
    $idString = $rows_productos['id_string'];
    $imagen = $rows_productos['id_imagen'];
    $consulta_productosMenu = "SELECT * FROM productosmenu WHERE idProducto = '$idProducto'";
    $consultaProductosMenu_query = mysqli_query($conexionComanderAdmin, $consulta_productosMenu) or die (mysqli_error($conexionComanderAdmin));
    $total_rows_productosMenu = mysqli_num_rows($consultaProductosMenu_query);
    if($total_rows_productosMenu){
    $productosMenu_eliminar = "DELETE FROM productosmenu WHERE idProducto = '$idProducto'";
    mysqli_query($conexionComanderAdmin, $productosMenu_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringNutricional){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringNutricional'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringAlergenos){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringAlergenos'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringDescripcion){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringDescripcion'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    $string_eliminar = "DELETE FROM strings WHERE id = '$idString'";
    mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    if($imagen != 0){
    $imagen_eliminar = "DELETE FROM imagenes WHERE id = '$imagen'";
    mysqli_query($conexionComanderAdmin, $imagen_eliminar) or die(mysqli_error($conexionComanderAdmin));  
    }
}while($rows_productos = mysqli_fetch_assoc($productos_query));

$producto_eliminar = "DELETE FROM productos WHERE idCategoriaProducto = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $producto_eliminar) or die(mysqli_error($conexionComanderAdmin));  

$consulta_subcategorias = "SELECT * FROM subcategorias WHERE idSubcategoria = '$idAeliminar'";
$subcategoria_query = mysqli_query($conexionComanderAdmin, $consulta_subcategorias) or die (mysqli_error($conexionComanderAdmin));
$rows_subcategorias = mysqli_fetch_array($subcategoria_query);
do{
    $idStringSubcategorias = $rows_subcategorias['id_string'];
    $idImagenSubcategorias = $rows_subcategorias['id_imagen'];
    $string_eliminar = "DELETE FROM strings WHERE id = '$idStringSubcategorias'";
    mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    if($idImagenSubcategorias != 0){
    $imagen_eliminar = "DELETE FROM imagenes WHERE id = '$idImagenSubcategorias'";
    mysqli_query($conexionComanderAdmin, $imagen_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
}while($rows_subcategorias = mysqli_fetch_array($subcategoria_query));

$subcategorias_eliminar = "DELETE FROM subcategorias WHERE idSubcategoria = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $subcategorias_eliminar) or die(mysqli_error($conexionComanderAdmin));

header("Location: administracionSubcategoriaAdmin.php");

}
/* **********************************
**********************************
********************************** */

/* variable de producto */
if (isset($_GET["productogenSup"])){
$idAeliminar=$_GET["productogenSup"];
$tabla="productos";
$varibleConsulta="productos.idProducto";
$consulta_Recordset1 = $_GET["productogenSup"];
$volver="administracionProductosAdmin.php";

$consulta_productos = "SELECT * FROM productos WHERE idProducto = '$idAeliminar'";
$productos_query = mysqli_query($conexionComanderAdmin, $consulta_productos) or die(mysqli_error($conexionComanderAdmin));
$rows_productos = mysqli_fetch_assoc($productos_query);
do{
    $idProducto = $rows_productos['idProducto'];
    $idStringNutricional = $rows_productos['id_string_nutricional'];
    $idStringAlergenos = $rows_productos['id_string_alergenos'];
    $idStringDescripcion = $rows_productos['id_string_descripcion'];
    $idString = $rows_productos['id_string'];
    $imagen = $rows_productos['id_imagen'];
    $consulta_productosMenu = "SELECT * FROM productosmenu WHERE idProducto = '$idProducto'";
    $consultaProductosMenu_query = mysqli_query($conexionComanderAdmin, $consulta_productosMenu) or die (mysqli_error($conexionComanderAdmin));
    $total_rows_productosMenu = mysqli_num_rows($consultaProductosMenu_query);
    if($total_rows_productosMenu){
    $productosMenu_eliminar = "DELETE FROM productosmenu WHERE idProducto = '$idProducto'";
    mysqli_query($conexionComanderAdmin, $productosMenu_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringNutricional){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringNutricional'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringAlergenos){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringAlergenos'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    if($idStringDescripcion){
        $string_eliminar = "DELETE FROM strings WHERE id = '$idStringDescripcion'";
        mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    }
    $string_eliminar = "DELETE FROM strings WHERE id = '$idString'";
    mysqli_query($conexionComanderAdmin, $string_eliminar) or die(mysqli_error($conexionComanderAdmin));
    if($imagen != 0){
    $imagen_eliminar = "DELETE FROM imagenes WHERE id = '$imagen'";
    mysqli_query($conexionComanderAdmin, $imagen_eliminar) or die(mysqli_error($conexionComanderAdmin));  
    }
}while($rows_productos = mysqli_fetch_assoc($productos_query));

$producto_eliminar = "DELETE FROM productos WHERE idProducto = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $producto_eliminar) or die(mysqli_error($conexionComanderAdmin));  

header("Location: administracionSubcategoriasAdmin.php");

}
/* **********************************
**********************************
********************************** */

/* variable de oferta */
if (isset($_GET["ofertaSup"])){
$idAeliminar=$_GET["ofertaSup"];

$consulta_productosMenu = "SELECT * FROM productosmenu WHERE idMenu = '$idAeliminar'";
$consulta_productosMenu_query = mysqli_query($conexionComanderAdmin, $consulta_productosMenu) or die (mysqli_error($conexionComanderAdmin));
$total_rows_consulta_productosMenu = mysqli_num_rows($consulta_productosMenu_query);
if ($total_rows_consulta_productosMenu){
$producto_eliminar = "DELETE FROM productosmenu WHERE idMenu = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $producto_eliminar);
}

$consulta_submenus = "SELECT * FROM submenus WHERE idMenuSubmenu = '$idAeliminar'";
$consulta_submenus_query = mysqli_query($conexionComanderAdmin, $consulta_submenus) or die (mysqli_error($conexionComanderAdmin));
$rows_consulta_submenu = mysqli_fetch_array($consulta_submenus_query);
$total_rows_submenus = mysqli_num_rows($consulta_submenus_query);
if ($total_rows_submenus){
    do{
    $id_string = $rows_consulta_submenu['id_string'];
    $string_eliminar = "DELETE FROM strings WHERE id = '$id_string'";
    mysqli_query($conexionComanderAdmin, $string_eliminar);
    }while($rows_consulta_submenu = mysqli_fetch_array($consulta_submenus_query));
$subcategorias_eliminar = "DELETE FROM submenus WHERE idMenuSubmenu = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $subcategorias_eliminar);
}
$consulta_menus = "SELECT * FROM menus WHERE idMenu = '$idAeliminar'";
$consulat_menu_query = mysqli_query($conexionComanderAdmin, $consulta_menus) or die (mysqli_error($conexionComanderAdmin));
$rows_conluta_menus = mysqli_fetch_array($consulat_menu_query);
$total_rows_consluta_menus = mysqli_num_rows($consulat_menu_query);
if ($total_rows_consluta_menus){
    do{
    $id_string = $rows_conluta_menus['id_string'];
    $string_eliminar = "DELETE FROM strings WHERE id = '$id_string'";
    mysqli_query($conexionComanderAdmin, $string_eliminar);    
    }while($rows_conluta_menus = mysqli_fetch_array($consulat_menu_query));
}
$categoria_eliminar = "DELETE FROM menus WHERE idMenu = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $categoria_eliminar);

if(isset($_GET['menu'])){
    header("Location: administracionMenusAdmin.php");
}else{
header("Location: administracionOfertasAdmin.php");
}
}
/* **********************************
**********************************
********************************** */

/* variable de suboferta */
if (isset($_GET["subofertaSup"])){
$idAeliminar=$_GET["subofertaSup"];

$consulta_productosMenu = "SELECT * FROM productosmenu WHERE idSubmenu = '$idAeliminar'";
$consulta_productosMenu_query = mysqli_query($conexionComanderAdmin, $consulta_productosMenu) or die (mysqli_error($conexionComanderAdmin));
$total_rows_consulta_productosMenu = mysqli_num_rows($consulta_productosMenu_query);
if ($total_rows_consulta_productosMenu){
$producto_eliminar = "DELETE FROM productosmenu WHERE idSubmenu = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $producto_eliminar);
}

$consulta_submenus = "SELECT * FROM submenus WHERE idSubmenu = '$idAeliminar'";
$consulta_submenus_query = mysqli_query($conexionComanderAdmin, $consulta_submenus) or die (mysqli_error($conexionComanderAdmin));
$rows_consulta_submenu = mysqli_fetch_array($consulta_submenus_query);
$total_rows_submenus = mysqli_num_rows($consulta_submenus_query);
if ($total_rows_submenus){    
    do{
    $id_string = $rows_consulta_submenu['id_string'];
    $string_eliminar = "DELETE FROM strings WHERE id = '$id_string'";
    mysqli_query($conexionComanderAdmin, $string_eliminar);
    }while($rows_consulta_submenu = mysqli_fetch_array($consulta_submenus_query));  
$subcategorias_eliminar = "DELETE FROM submenus WHERE idSubmenu = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $subcategorias_eliminar);
}
if (isset($_GET['menu'])){
    header("Location: administracionMenusAdmin.php");
}else{
header("Location: administracionOfertasAdmin.php");
}
}
/* **********************************
**********************************
********************************** */

/* variable de producto de oferta */
if (isset($_GET["productoSupOf"])) {
$idAeliminar=$_GET["productoSupOf"];

$consulta_productosMenu = "SELECT * FROM productosmenu WHERE idProductosMenu = '$idAeliminar'";
$consulta_productosMenu_query = mysqli_query($conexionComanderAdmin, $consulta_productosMenu) or die (mysqli_error($conexionComanderAdmin));
$total_rows_consulta_productosMenu = mysqli_num_rows($consulta_productosMenu_query);
if ($total_rows_consulta_productosMenu){
$producto_eliminar = "DELETE FROM productosmenu WHERE idProductosMenu = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $producto_eliminar);
}
if(isset($_GET["menu"])){
    header("Location: administracionMenusAdmin.php");
}else{
header("Location: administracionOfertasAdmin.php");
}
}
/* **********************************
**********************************
********************************** */

/* variable de menu */
if (isset($_GET["menuSup"])){
$idAeliminar=$_GET["menuSup"];
$tabla="menus";
$varibleConsulta="menus.idMenu";
$consulta_Recordset1 = $_GET["menuSup"];
$volver="administracionOfertasAdmin.php";
}
/* **********************************
**********************************
********************************** */


/* variable de submenu */
if (isset($_GET["submenuSup"])){
$idAeliminar=$_GET["submenuSup"];
$tabla="submenus";
$varibleConsulta="submenus.idSubmenu";
$consulta_Recordset1 = $_GET["submenuSup"];
$volver="administracionMenusAdmin.php";
}
/* **********************************
**********************************
********************************** */

/* variable de zonas */
if (isset($_GET["supZona"])){
$idAeliminar=$_GET["supZona"];

$consulta_zona = "SELECT id_string FROM zonas WHERE idZona = '$idAeliminar'";
$consulta_zona_query = mysqli_query($conexionComanderAdmin, $consulta_zona) or die (mysqli_error($conexionComanderAdmin));
$row_zona = mysqli_fetch_array($consulta_zona_query);
$id_string = $row_zona['0'];
$eliminar_string = "DELETE FROM strings WHERE id = '$id_string'";
mysqli_query($conexionComanderAdmin, $eliminar_string) or die (mysqli_error($conexionComanderAdmin));
$eliminar_zona = "DELETE FROM zonas WHERE idZona = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $eliminar_zona) or die (mysqli_error($conexionComanderAdmin));

header("Location:administracionZonasAdmin.php");
}
/* **********************************
**********************************
********************************** */

/* variable de producto de usuarios */
if (isset($_GET["supUsuario"])) {
$idAeliminar=$_GET["supUsuario"];

//CONSULTAMOS LOS DATOS NECESARIO DEL USUARIO
$consulta_usuario = "SELECT * FROM usuarios WHERE idUsuario = '$idAeliminar'";
$consulta_usuario_query = mysqli_query($conexionComanderAdmin, $consulta_usuario) or die (mysqli_error($conexionComanderAdmin));
$rows_consulta_usuario = mysqli_fetch_array($consulta_usuario_query);

//ASIGNAMOS LOS VALORES A VARIABLES
$id_imagen_QR = $rows_consulta_usuario['id_imagen_QR'];
$id_imagen = $rows_consulta_usuario['id_imagen'];
$id_string_puesto = $rows_consulta_usuario['id_string_puesto'];

//ELIMINAMOS LA IMAGEN QR
$eliminar_QR = "DELETE FROM imagenes WHERE id = '$id_imagen_QR'";
mysqli_query($conexionComanderAdmin, $eliminar_QR) or die (mysqli_error($conexionComanderAdmin));

//ELIMINAMOS LA IMAGEN DE USUARIO
if (!$id_imagen){
$eliminar_imagen = "DELETE FROM imagenes WHERE id = '$id_imagen'";
mysqli_query($conexionComanderAdmin, $eliminar_imagen) or die (mysqli_error($conexionComanderAdmin));
}

//ELIMINAS EL STRING DE PUESTO DE USUARIO
$eliminar_string_puesto = "DELETE FROM strings WHERE id = '$id_string_puesto'";
mysqli_query($conexionComanderAdmin, $eliminar_string_puesto) or die (mysqli_error($conexionComanderAdmin));

//ELIMINAMOS EL USUARIO
$eliminar_usuario = "DELETE FROM usuarios WHERE idUsuario = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $eliminar_usuario) or die (mysqli_error($conexionComanderAdmin));

header("Location:administracionUsuariosAdmin.php");

}
/* **********************************
**********************************
********************************** */

/* variable de mesas */
if (isset($_GET["supMesa"])) {
$idAeliminar=$_GET["supMesa"];

//CONSULTAMOS LA ID DE LA IMAGEN
$consulta_mesa = "SELECT id_imagen FROM mesas WHERE idMesa = '$idAeliminar'";
$consulta_mesa_query = mysqli_query($conexionComanderAdmin, $consulta_mesa) or die (mysqli_errno($conexionComanderAdmin));
$row_consulta_mesa = mysqli_fetch_array($consulta_mesa_query);
$id_imagen = $row_consulta_mesa['0'];

//ELIMINAMOS LA IMAGEN 
$eliminar_imagen = "DELETE FROM imagenes WHERE id = '$id_imagen'";
mysqli_query($conexionComanderAdmin, $eliminar_imagen) or die (mysqli_errno($conexionComanderAdmin));

//ELIMINAMOS LA MESA
$eliminar_mesa = "DELETE FROM mesas WHERE idMesa = '$idAeliminar'";
mysqli_query($conexionComanderAdmin, $eliminar_mesa) or die (mysqli_error($conexionComanderAdmin));

header ("Location: administracionMesasAdmin.php");

}
/* **********************************
**********************************
********************************** */


 $consulta="SELECT * FROM ".$tabla." WHERE ".$varibleConsulta ."=%s";
 $eliminar="DELETE FROM ".$tabla." WHERE ".$varibleConsulta ."=%s";

mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);
$query_Recordset1 = sprintf($consulta, 
GetSQLValueString($consulta_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionComanderAdmin, $query_Recordset1) or die(mysql_connect_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

if ((isset($idAeliminar)) && ($idAeliminar != "")) {
  $deleteSQL = sprintf($eliminar,
                       GetSQLValueString($idAeliminar, "int"));
  
  $Result1 = mysqli_query($conexionComanderAdmin, $deleteSQL) or die(mysql_connect_error());

  $deleteGoTo = $volver;
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

