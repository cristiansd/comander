<?phprequire_once('../includes/funcionesAdmin.php');if (!isset($_SESSION)) {  session_start();}$MM_authorizedUsers = "1,2,3";$MM_donotCheckaccess = "false";$MM_restrictGoTo = "accesoUsuarioAdmin.php";if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {     $MM_qsChar = "?";  $MM_referrer = $_SERVER['PHP_SELF'];  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)   $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);  header("Location: ". $MM_restrictGoTo);   exit;}if (isset($_GET["RecordID"])) {  $varsuboferta = $_GET["RecordID"];}mysqli_select_db($conexionComanderAdmin, $database_conexionComanderAdmin);$query_suboferta =sprintf ("SELECT * FROM submenus WHERE idMenuSubmenu=%s", GetSQLValueString($varsuboferta, "int"));$suboferta = mysqli_query($conexionComanderAdmin, $query_suboferta) or die(mysqli_connect_error());$row_suboferta = mysqli_fetch_assoc($suboferta);if (isset($_GET['totalRows_suboferta'])) {  $totalRows_suboferta = $_GET['totalRows_suboferta'];} else {  $all_suboferta = mysqli_query($conexionComanderAdmin, $query_suboferta);  $totalRows_suboferta = mysqli_num_rows($all_suboferta);}$totalPages_suboferta = ceil($totalRows_suboferta/$maxRows_suboferta)-1;$queryString_suboferta = "";if (!empty($_SERVER['QUERY_STRING'])) {  $params = explode("&", $_SERVER['QUERY_STRING']);  $newParams = array();  foreach ($params as $param) {    if (stristr($param, "pageNum_suboferta") == false &&         stristr($param, "totalRows_suboferta") == false) {      array_push($newParams, $param);    }  }  if (count($newParams) != 0) {    $queryString_suboferta = "&" . htmlentities(implode("&", $newParams));  }}$queryString_suboferta = sprintf("&totalRows_suboferta=%d%s", $totalRows_suboferta, $queryString_suboferta);?><!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <link rel="stylesheet" href="../estilos/w3.css">        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">        <script type="text/javascript" src="../envCam/jquery-mobile/jquery.js"></script>        <link href="../estilos/admin.css" rel="stylesheet" type="text/css" />        <link href="../estilos/w3-theme-indigo.css" rel="stylesheet" type="text/css" />        <title><?php echo $titleSheet; ?></title>        <style type="text/css"></style>        <script type="text/javascript">            var height;            var width;            $(document).ready(function () {                height = $(window).height();                width = $(window).width();                var styleSidevar1 = "height:" + (height-100) + "px;";                //$(".content").attr("style", styleSidevar1);                //$(".subcontenedor").attr("style", styleSidevar1);                if(height > $(".sidebar1").height()){                $(".sidebar1").attr("style", styleSidevar1);                                }                if($(".subcontenedor").height()>$(".sidebar1").height()){                    $(".sidebar1").attr("style", "height:" + $(".subcontenedor").height() + "px;");                                                }            });        </script>    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico"></head>    <body>        <header class="w3-card-4 w3-theme header w3-padding-large" style="height: 100px;">            <div class ="w3-margin" style="float: left;"><img src="../imagenes/mano.png" class="w3-round-small" alt="Norway" style="width:40px;height: 40px;"></div>            <div class="w3-xxxlarge" style="width: 50%;float: left;">COMANDER</div>            <div class="w3-xlarge w3-right" style="margin-top: 20px;margin-right: 10px;"><?php echo $headerTitle; ?></div>        </header>        <div class="subcontenedor">                <div class="sidebar1 w3-card-4 w3-theme-l1 w3-large">                    <div class="w3-xlarge w3-margin-top w3-margin-bottom w3-padding-left"><?php echo $sidevarTitle; ?></div>                    <?php include("../includes/BotoneraAdmin.php"); ?>                </div>                  <div class="content w3-center no-seleccionable">                      <h1>                        <p>                                                        <?php echo $compositionMenuTag; ?> "<?php  echo recuperarString(ObtenerNombreMenu($varsuboferta));?>"                             <div class="botonAnadir">                                <button class="w3-btn w3-light-grey w3-border w3-card-8 w3-text-grey w3-xlarge"onclick="window.location.href='insertarSubmenuAdmin.php?RecordID=<?php echo $varsuboferta; ?>'"><?php echo $addElementToThisMenu; ?></button>                            </div>                        </p>                    </h1>                    <div class="contenido">                        <br>                        <br>                        <div class="contenidoConAnadir">                            <div class="resultadoproductosConAnadir">                                <?php if ($totalRows_suboferta > 0) {                                    do { ?>                                <div class="producto w3-hover-light-grey">                                                      <div align="center">                                        <h3>                                            <a title = "<?php echo $seeProductsOfThisMenu; ?>" href="productosMenuAdmin.php?RecordID=<?php echo $row_suboferta['idSubmenu']; ?>&ctrlmn=<?php echo $row_suboferta['idMenuSubmenu']; ?>"><?php echo $row_suboferta['nombreSubmenu']; ?></a>                                        </h3>                                        <p><?php echo"<b>". $menTag."</b>".recuperarString(ObtenerNombreMenu($row_suboferta['idMenuSubmenu']));?></p>                                        <p class="w3-center">                                            <?php if($row_suboferta['estadoSubmenu']==1){?>                                            <?php echo $availableTag;}                                            else{?>  <?php echo $notAvailableTag;} ?>                                        </p>                                    </div>                                    <div style="margin-left: 70px;">                                                                                <div class="textoproductoiconseditar">                                            <input name="" type="image" title="<?php echo $modifySubmenuTag; ?>" src="../imagenes/adminImages/modificar.png" onclick="location='modificarSubofertaAdmin.php?RecordID=<?php echo $row_suboferta['idSubmenu']; ?>'"/>                                        </div>                                        <div class="textoproductoiconseliminar">                                            <input name="eliminar" type="image" title="<?php echo $deletteThisSubmenu; ?>" value="eliminar" src="../imagenes/adminImages/eliminar.png" height="20" width="20" onclick="location='verificarEliminarAdmin.php?menu&subofertaSup=<?php echo $row_suboferta['idSubmenu']; ?>&nombre=<?php echo $row_suboferta['nombreSubmenu']; ?>&idString=<?php echo $row_suboferta['id_string'];?>'"/>                                        </div>                                             <div class="textoproductoiconsAnadir" style="margin-left: 30px;">                                           <input name="añadir" type="image" title="<?php echo $addProductToThisSubmenu; ?>" src="../imagenes/adminImages/insertar.png" onclick="location='administracionCategoriaAdmin.php?ctrl=<?php echo $row_suboferta['idSubmenu']; ?>&ctrlmn=<?php echo $row_suboferta['idMenuSubmenu']; ?>'" />                                        </div>                                    </div>                                                                   </div>                                                        <?php } while ($row_suboferta = mysqli_fetch_assoc($suboferta)); ?>                            </div>                                                       <?php }if ($totalRows_suboferta == 0) {?>                             <h3><?php echo $notSubmenu;?></h3>                                                                <?php } ?>                           </div>                    </div>                </div>            </div>        <div class="footer"></div>    </body></html><?phpmysqli_free_result($suboferta);?>