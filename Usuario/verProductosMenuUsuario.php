<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

$idGrupoComanda = 0;

if (filter_input(INPUT_GET, 'idComanda')){
    
    $idComanda = filter_input(INPUT_GET, 'idComanda');
    
mysql_select_db($database_usuario, $comcon_usuario);
$query_submenu = "SELECT * FROM comandaTemp_".$_SESSION['id_usuario']." WHERE id=$idComanda";
$RegSubmenu = mysql_query($query_submenu, $comcon_usuario) or die(mysql_error());
$row_RegSubmenu = mysql_fetch_assoc($RegSubmenu);

$idSubmenu = $row_RegSubmenu['idSubmenuComandaTemp'];
$idMenu = $row_RegSubmenu['idMenuComandaTemp'];

mysql_select_db($database_usuario, $comcon_usuario);
$query_menu = "SELECT nombreMenu FROM menus WHERE idMenu=$idMenu";
$Regmenu = mysql_query($query_menu, $comcon_usuario) or die(mysql_error());
$row_Regmenu = mysql_fetch_assoc($Regmenu);

$nombreSubmenu = $row_Regmenu['nombreMenu'];
    
}

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegCategorias = "SELECT * FROM productosmenu WHERE idSubmenu=$idSubmenu AND estadoProductoMenu=1";
$RegCategorias = mysql_query($query_RegCategorias, $comcon_usuario) or die(mysql_error());
$row_RegCategorias = mysql_fetch_assoc($RegCategorias);
$totalRows_RegCategorias = mysql_num_rows($RegCategorias);?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
    
    <style>
    .toast {

                width:200px;

                height:20px;

                height:auto;

                position:absolute;

                left:50%;

                margin-left:-100px;

                bottom:140px;

                background-color: #383838;

                color: #F0F0F0;

                font-family: Calibri;

                font-size: 20px;

                padding:10px;

                text-align:center;

                border-radius: 5px;

                -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);

                -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);

                box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);

            }
            
    </style>
    
    <script type="text/javascript">
        
        var imagen;
        var height;
        var lista;

        function changeColor(x){
            x.style.background="#C6D5FF";
        }
        
        function modificarMenu(id, idProducto){ 
            
            var dataString = {'id': id, 'idProducto': idProducto};
            
            $.ajax({
                type: "POST",
                url: "modificarComandaTempUsuario.php",
                data: dataString,
                cache: false,

                success: function(data){
                    if($.trim(data)==="OK"){
                        $('.toast').text('Menú modificado');
                        $('.toast').fadeIn(100).delay(500).fadeOut(100);
                        setTimeout(function(){
                            window.location = "listaTiempoRealUsuario.php";
                            }, 700);
                    } 
                    if($.trim(data)==="ERROR"){
                        $('.toast').text('Error al actualizar');
                        $('.toast').fadeIn(400).delay(2000).fadeOut(400);
                    }
                }
            });
        }

        $(document).ready(function () {        
            height=$(window).height();
            imagen = "height:"+((height/100)*30)+"px;width: 100%;margin-top:0px;";        
            $("#imagen").attr("style",imagen);
            lista = "overflow: scroll;height:"+(((height/100)*70)-70)+"px;margin-top: 10px;";
            $("#lista").attr("style",lista);
        });
        
    </script>
    <?php include '../includes/importacionesUsuario.php';?>    
    <body class="w3-light-grey">
        <?php cabeceraNavegacionUsuario('MENU',0,0);
        if ($totalRows_RegCategorias > 0){
        imagenNavegacionCarta("menu",0)?>        
        <ul id="lista" class="w3-ul w3-card-2"style="margin-top: 10px;">
        <?php do { ?>           
            <li style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="modificarMenu(<?php echo $idComanda; ?>,<?php echo $row_RegCategorias['idProducto']; ?> );changeColor(this);">                                 
                <img src="../includes/imagen.php?id=<?php echo recuperaImagenProducto($row_RegCategorias['idProducto'])."&local=".$_SESSION['establecimiento']; ?>" class="w3-left" style="width:90px;height:88px;">
                <div class="w3-centered w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 100px;"><?php echo recuperaNombreProducto($row_RegCategorias['idProducto']);?></div>
            </li>
            <?php } while ($row_RegCategorias = mysql_fetch_assoc($RegCategorias)); ?>
            <?php }else{?>
            <div class="centrar">NO EXISTEN ELEMENTOS DE ESTA CATEGORIA</div>
            <?php }?>   
        </ul>
         <div class='toast' style='display:none'>TOAST</div>
    </body>
</html>
<?php
mysql_free_result($RegCategorias);
?>