<?php
require_once('../includes/funcionesAdmin.php');

$mesa = $_GET['mesa'];
//DECLARAMOS LA CONEXION A LA BASE DE DATOS
mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);

//CONSULTAMOS LOS DATOS DE LAS MESAS
$consulta_mesa = "SELECT * FROM mesas";
$consulta_mesa_query = mysqli_query($conexionComanderAdmin, $consulta_mesa) or die (mysqli_error($conexionComanderAdmin));
$row_consulta_mesa = mysqli_fetch_array($consulta_mesa_query);
$total_rows = mysqli_num_rows($consulta_mesa_query);
$total_mesas = $total_rows/2;
?>
<!DOCTYPE html>
<html>
    <head>        
        <title></title>
        <script type="text/javascript">
            function imprimir() {
                if (window.print) {
                    window.print();
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
                window.location = "administracionMesasAdmin.php";
            }
        </script>
        <style type="text/css">
            .celdas{
                border: 1px solid #000;
            }
        </style>
    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
</head>
    <body onload="imprimir()">
                <?php do{ ?>           
                    <div class="celdas" style="padding: 15px;float: left;margin: 5px;">
                        <img src="../includes/imagen.php?id=<?php echo $row_consulta_mesa['id_imagen']; ?>&local=<?php echo $_COOKIE['establecimiento']; ?>" width="120" height="120" />
                        <div class="w3-large">
                            <?php echo $establishmentTag.$_COOKIE['establecimiento']."<br>".$tableTagMin.$row_consulta_mesa['idMesa']; ?>
                        </div>
                    </div> 
                <?php }while($row_consulta_mesa = mysqli_fetch_array($consulta_mesa_query)); ?>
    </body>
</html>

