<?php


//RECUPERAMOS LOS PARAMETROS PASADOS POR POST
$id = filter_input(INPUT_GET, 'id');

//DECLARAMOS LAS VARIABLES NECESARIAS
$jsondata = array();
$control = 0;
$idCat;
$imagen;
$nombre;
$precio;

//DECLARAMOS LAS VARIABLES DE CONEXION NECESARIAS
$hostname_comcon = "localhost";
$database_comcon = "eh1w1ia3_main";
$username_comcon = "eh1w1ia3_sangar";
$password_comcon = "290172crissan";

//CREAMOS LA VARIABLE DE CONEXION
$comcon = mysqli_connect($hostname_comcon, $username_comcon, $password_comcon);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon, $database_comcon);
$consulta = "SELECT * FROM establecimientos WHERE id_establecimiento = '$id'";
$comprobarUsuario_query = mysqli_query($comcon, $consulta);
$row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query);
$total_rows = mysqli_num_rows($comprobarUsuario_query);

//SETEAMOS VARIABLES PARA CONECTAR CON LA BD DEL ESTABLECIMIENTO
    do{
    $database_establecimiento = $row_comprobarUsuario['name_database'];
    $username_establecimiento = $row_comprobarUsuario['username_database'];
    $password_establecimiento = $row_comprobarUsuario['password_database'];
    }while($row_comprobarUsuario = mysqli_fetch_assoc($comprobarUsuario_query));
    
//CREAMOS LA VARIABLE DE CONEXION
$comcon_establecimiento = mysqli_connect($hostname_comcon, $username_establecimiento, $password_establecimiento);

//SELECCIONAMOS LA BD
mysqli_select_db($comcon_establecimiento, $database_establecimiento);

//FUNCION PARA RECUPERAR LOS STRINGS
function recuperarString($idString){
	global $database_establecimiento, $comcon_establecimiento;
        $string = "";
	mysqli_select_db($comcon_establecimiento, $database_establecimiento);
	$query_consultaFuncion = sprintf("SELECT * FROM strings WHERE id = %s",
	$idString);
	$consultaFuncion = mysqli_query($comcon_establecimiento, $query_consultaFuncion) or die(mysqli_error($comcon_establecimiento));
	$row_consultaFuncion = mysqli_fetch_assoc($consultaFuncion);
        switch ($_GET['idioma']){
            case "es":
                $string = $row_consultaFuncion['spanish'];
                break;
            case "en":
                $string = $row_consultaFuncion['ingles'];
                break;
            case "ca":
                $string = $row_consultaFuncion['catalan'];
                break;
            case "de":
                $string = $row_consultaFuncion['aleman'];
                break;
            case "fr":
                $string = $row_consultaFuncion['frances'];
                break;
            case "it":
                $string = $row_consultaFuncion['italiano'];
                break;
            case "ru":
                $string = $row_consultaFuncion['ruso'];
                break;
            case "zh":
                $string = $row_consultaFuncion['chino'];
                break;
            case "ja":
                $string = $row_consultaFuncion['japones'];
                break;
            case "ar":
                $string = $row_consultaFuncion['arabe'];
                break;
            default:
                $string = $row_consultaFuncion['ingles'];
        }
	return $string;
	
	}

//REALIZAMOS LA CONSULTA DEPENDIENDO DE LOS PARAMETROS QUE HEMOS RECIBIDO
if(isset($_GET['idCategoria'])){
    $idCategoria = filter_input(INPUT_GET, 'idCategoria');
    $consulta_establecimiento = "SELECT * FROM subcategorias WHERE idCategoriaSubcategoria = '$idCategoria'";
    $comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
    $row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
    $total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);
    
//PARSEAMOS LA VARIABLES OBTENIDAS    
do{
$idCat = $row_comprobarUsuario_establecimiento['idSubcategoria'];
$imagen = $row_comprobarUsuario_establecimiento['id_imagen'];
$nombre = recuperarString($row_comprobarUsuario_establecimiento['id_string']);

//CARGAMOS TODO A JSON
$jsondata[$control]['idCategoria'] = $idCat;
$jsondata[$control]['nombreCategoria'] = $nombre;
$jsondata[$control]['imagen'] = utf8_encode($imagen);
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));

}else if(isset($_GET['idProducto'])){
    $idCategoria = filter_input(INPUT_GET, 'idProducto');
    $consulta_establecimiento = "SELECT * FROM productos WHERE idSubcategoriaProducto = '$idCategoria'";
    $comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
    $row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
    $total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);
    
//PARSEAMOS LA VARIABLES OBTENIDAS    
do{
$idCat = $row_comprobarUsuario_establecimiento['idProducto'];
$imagen = $row_comprobarUsuario_establecimiento['id_imagen'];
$nombre = recuperarString($row_comprobarUsuario_establecimiento['id_string']);
$precio = $row_comprobarUsuario_establecimiento['precioVentaProducto'];
if ($row_comprobarUsuario_establecimiento['id_string_descripcion'] != null){
$descripcion = recuperarString($row_comprobarUsuario_establecimiento['id_string_descripcion']);
}
if ($row_comprobarUsuario_establecimiento['id_string_alergenos'] != null){
$alergenos = recuperarString($row_comprobarUsuario_establecimiento['id_string_alergenos']);
}
if($row_comprobarUsuario_establecimiento['id_string_nutricional'] != null){
$nutricional = recuperarString($row_comprobarUsuario_establecimiento['id_string_nutricional']);
}

//CARGAMOS TODO A JSON 
$jsondata[$control]['idCategoria'] = $idCat;
$jsondata[$control]['nombreCategoria'] = $nombre;
$jsondata[$control]['imagen'] = utf8_encode($imagen);
$jsondata[$control]['precio'] = $precio;
$jsondata[$control]['descripcion'] = $descripcion;
$jsondata[$control]['alergenos'] = $alergenos;
$jsondata[$control]['nutricional'] = $nutricional;
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));

}else if(isset($_GET['menu'])){
    $consulta_establecimiento = "SELECT * FROM menus WHERE estadoMenu = 1";
    $comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
    $row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
    $total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);
    
//PARSEAMOS LA VARIABLES OBTENIDAS    
do{
$idCat = $row_comprobarUsuario_establecimiento['idMenu'];
$nombre = recuperarString($row_comprobarUsuario_establecimiento['id_string']);
$precio = $row_comprobarUsuario_establecimiento['precioMenu'];

//CARGAMOS TODO A JSON
$jsondata[$control]['idCategoria'] = $idCat;
$jsondata[$control]['nombreCategoria'] = $nombre;
$jsondata[$control]['precio'] = $precio;
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));

}else if(isset($_GET['idmenu'])){
    $idCategoria = filter_input(INPUT_GET, 'idmenu');
    $consulta_establecimiento = "SELECT * FROM submenus WHERE idMenuSubmenu = '$idCategoria' ";
    $comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
    $row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
    $total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);
    
//PARSEAMOS LA VARIABLES OBTENIDAS    
do{
$idCat = $row_comprobarUsuario_establecimiento['idSubmenu'];
$nombre = recuperarString($row_comprobarUsuario_establecimiento['id_string']);

//CARGAMOS TODO A JSON
$jsondata[$control]['idCategoria'] = $idCat;
$jsondata[$control]['nombreCategoria'] = $nombre;
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));

}else if(isset($_GET['idSubmenu'])){
    $idCategoria = filter_input(INPUT_GET, 'idSubmenu')*1;
    $consulta_establecimiento = "SELECT * FROM productosmenu WHERE idSubmenu = '$idCategoria' ";
    $comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
    $row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
    $total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);
    
//PARSEAMOS LA VARIABLES OBTENIDAS    
do{
$idCat = $row_comprobarUsuario_establecimiento['idProducto'];

$consultaProducto = "SELECT * FROM productos WHERE idProducto = '$idCat' ";
$query_Producto = mysqli_query($comcon_establecimiento, $consultaProducto);
$row_producto = mysqli_fetch_assoc($query_Producto);

//PARSEAMOS LOS DATOS OBTENIDOS DE LA CONSULTA
do{
    $imagen = $row_producto['id_imagen'];
    $nombre = recuperarString($row_producto['id_string']);
    $descripcion = $row_producto['descripcionProducto'];
    $nutricional = $row_producto['nutricionalProducto'];
    $alergenos = $row_producto['alergenosProducto'];
}while($row_producto = mysqli_fetch_assoc($query_Producto));

//CARGAMOS TODO A JSON
$jsondata[$control]['idCategoria'] = $idCat;
$jsondata[$control]['nombreCategoria'] = $nombre;
$jsondata[$control]['imagen'] = utf8_encode($imagen);
$jsondata[$control]['nutricional'] = utf8_encode($nutricional);
$jsondata[$control]['descripcion'] = utf8_encode($descripcion);
$jsondata[$control]['alergenos'] = utf8_encode($alergenos);
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));

}else{
$consulta_establecimiento = "SELECT * FROM categorias";
$comprobarUsuario_query_establecimiento = mysqli_query($comcon_establecimiento, $consulta_establecimiento);
$row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento);
$total_rows_establecimiento = mysqli_num_rows($comprobarUsuario_query_establecimiento);

//PARSEAMOS LA VARIABLES OBTENIDAS
do{
$idCat = $row_comprobarUsuario_establecimiento['idCategoria'];
$imagen = $row_comprobarUsuario_establecimiento['id_imagen'];
$nombre = recuperarString($row_comprobarUsuario_establecimiento['id_string']);

//CARGAMOS TODO A JSON
$jsondata[$control]['idCategoria'] = $idCat;
$jsondata[$control]['nombreCategoria'] = $nombre;
$jsondata[$control]['imagen'] = utf8_encode($imagen);
$control++;
}while($row_comprobarUsuario_establecimiento = mysqli_fetch_assoc($comprobarUsuario_query_establecimiento));
}
echo $_GET['callback'].'('.json_encode($jsondata).')';
exit;

?>

