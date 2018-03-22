<?php 
require_once('../includes/funcionesUsuario.php'); 

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';  

mysql_select_db($database_usuario, $comcon_usuario);
$query_RegProducto = "SELECT * FROM productos WHERE estadoProducto=1";
$RegProducto = mysql_query($query_RegProducto, $comcon_usuario) or die(mysql_error());
$row_RegProducto = mysql_fetch_assoc($RegProducto);
$totalRows_RegProducto = mysql_num_rows($RegProducto);?>

<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <script type="text/javascript" src="jquery-mobile/jquery.js"></script>
    <script type="text/javascript" charset="UTF-8" src="cordova.js"></script>
    <style>
        input[type=text]:focus{
        border:0px; 
        }
        
        :focus{
            outline: 0px;           
        }
    </style>
    <script type="text/javascript">
    function changeColor(x){
        x.style.background="#C6D5FF";
    }
    
    function myFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            if (li[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    var width;
    $(document).ready(function () {
        width=$(window).width();
        anchura = "width:" + ((width)-120)+ "px;height:35px;";
        $("#myInput").attr("style", anchura);
    
    $("#myInput").focus();
    $("#myInput").click();  

    });
    
    </script>
    
    <?php include '../includes/importacionesUsuario.php';?>    
    <body class="w3-light-grey">
        <header class="w3-container w3-card-4 w3-theme header">
            <h3 style="margin-top: 10px;">
                <i class="w3-xlarge w3-margin-right" onclick="window.location.href = 'closeKeyboard.html';">
                    <img  src="../imagenes/UsuarioImages/back.png" alt="Norway">
                </i>
                <i class="w3-xlarge w3-margin-right" onclick="">
                    <img  src="../imagenes/UsuarioImages/buscar.png" alt="Norway">
                </i>
                 <input class="w3-input w3-theme header w3-right myInput w3-medium" placeholder="<?php echo $search; ?>" type="text"  id="myInput" onkeyup="myFunction()">
                              
            </h3>
        </header>
        <ul id="myUL" class="w3-ul w3-card-2"style="margin-top: 10px;">
        <?php do { ?>
            <li style="height: 90px;padding: 0px;margin-top: 1px;margin-bottom: 1px;" onclick="window.location.href='mostrarDetalleUsuario.php?idProducto=<?php echo $row_RegProducto['idProducto']."&nombre=".recuperarString($row_RegProducto['id_string'])."&imagen=".$row_RegProducto['id_imagen']; ?>';changeColor(this);">                                 
                <img src="../includes/imagen.php?id=<?php echo($row_RegProducto['id_imagen']); ?>&local=<?php echo $_SESSION['establecimiento']; ?>" class="w3-left" style="width:90px;height:88px;">
                <div class="w3-centered w3-medium letraBotones"style="padding-top: 30px;padding-left: 10px;margin-left: 100px;"><?php echo recuperarString($row_RegProducto['id_string']); ?><br><?php echo number_format($row_RegProducto['precioVentaProducto'], 2); ?>&euro;</div>
            </li>
            <?php } while ($row_RegProducto = mysql_fetch_assoc($RegProducto)); ?>
        </ul>     
    </body>
</html>

