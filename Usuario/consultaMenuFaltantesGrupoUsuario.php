<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

$idGrupo = filter_input(INPUT_GET, 'idGrupo');

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegMenus = "SELECT * FROM comandaTemp_".$_SESSION['id_usuario']." WHERE idGrupoMenuComandaTemp = $idGrupo";
$RegMenus= mysql_query($query_RegMenus, $comcon_usuario) or die(mysql_error());
$row_RegMenus = mysql_fetch_assoc($RegMenus);
$totalRows_RegMenus = mysql_num_rows($RegMenus);

$cantidadRegistros;
$registros;
$jsonData = Array();
$x=0;

if($totalRows_RegMenus){    
do {
    $cantidadRegistros = count(compararSubmenuMenuYSubmenuGrupoMenu($row_RegMenus['idMenuComandaTemp'], "comandaTemp_".$_SESSION['id_usuario']."",    
    $row_RegMenus['idGrupoMenuComandaTemp']));
    if($cantidadRegistros){
        $registros = compararSubmenuMenuYSubmenuGrupoMenu($row_RegMenus['idMenuComandaTemp'], "comandaTemp_".$_SESSION['id_usuario']."",
        $row_RegMenus['idGrupoMenuComandaTemp']);
        foreach ($registros as $id){
            mysql_select_db($database_usuario, $comcon_usuario);
            $query_submenus = "SELECT * FROM submenus WHERE idSubmenu='$id' AND estadoSubmenu=1";
            $Menus= mysql_query($query_submenus, $comcon_usuario) or die(mysql_error());
            $row_RegMenu = mysql_fetch_assoc($Menus);
            $totalRows_Menus = mysql_num_rows($Menus);
            
            if($totalRows_Menus){
                $jsonData[$x][0] = $row_RegMenu['idSubmenu'];
                $jsonData[$x][1] = $row_RegMenu['nombreSubmenu'];
                $jsonData[$x][2] = $row_RegMenus['idMenuComandaTemp'];
                $jsonData[$x][3] = $row_RegMenus['idGrupoMenuComandaTemp'];
                $x++;
                mysql_free_result($Menus);
            }
        }
        break;
    }
    
}while($row_RegMenus = mysql_fetch_assoc($RegMenus));
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonData, JSON_FORCE_OBJECT);


?>
