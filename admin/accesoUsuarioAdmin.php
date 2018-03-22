<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

$errorEstablecimiento = 0;
$errorLogin = 0;
$haycokkie = false;
$error_establecimiento = false;
$MM_redirectLoginSuccess = "accesoCorrectoAdmin.php";
$MM_redirectLoginFailed = "accesoUsuarioAdmin.php?errorlogin=1";
$MM_redirectEstFailed = "accesoUsuarioAdmin.php?errorestablecimiento=1";

$loginUsername = "";
$password = "";

if (isset($_COOKIE['establecimiento'])) {
    $idEstablecimiento = $_COOKIE['establecimiento'];
    $haycokkie = true;
} else {
    $idEstablecimiento = "";
}

if(isset($_COOKIE['idioma'])){
    $idioma = $_COOKIE['idioma'];
    include "../strings/".$idioma.".php";
} else {
    if(isset($_POST['idioma'])){
        $idioma = $_COOKIE['idioma'];
    } else {
    $idioma =substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
    include "../strings/".$idioma.".php";
    }
}
if(isset($_POST['idioma'])){
$idioma = $_POST['idioma'];
}

if (isset($_GET['errorestablecimiento']) && $_GET['errorestablecimiento'] == 1){
    $errorEstablecimiento = 1;
}

if (isset($_GET['errorlogin']) && $_GET['errorlogin'] == 1){
    $errorLogin = 1;
}

if (isset($_POST['apodo'])) {
    //$zona = $_POST['listZonas'];
    $loginUsername = $_POST['apodo'];
    $password = $_POST['password'];
    if (isset($_COOKIE['establecimiento'])) {
        $idEstablecimiento = $_COOKIE['establecimiento'];
        $haycokkie = true;
    } else {
        $idEstablecimiento = $_POST['idEstablecimiento'];
    }

    $hostname_main = "localhost";
    $database_main = "eh1w1ia3_main";
    $username_main = "eh1w1ia3_sangar";
    $password_main = "290172crissan";

    $conn_main = mysqli_connect($hostname_main, $username_main, $password_main) or trigger_error(mysqli_connect_error(), E_USER_ERROR);
    mysqli_select_db($conn_main, $database_main);

    //RECUPERAMOS DATOS DE CONEXION
    $establecimiento__query = "SELECT hostname_database, name_database, username_database, password_database, nombre_establecimiento FROM establecimientos WHERE id_establecimiento='$idEstablecimiento'";
    $establecimientoRS = mysqli_query($conn_main, $establecimiento__query) or die(mysqli_connect_error());
    $establecimientoRS_rows = mysqli_fetch_array($establecimientoRS);
    $totalRows_establecimientoRS = mysqli_num_rows($establecimientoRS);
    if ($totalRows_establecimientoRS != 0){
        $hostname_local = $establecimientoRS_rows['hostname_database'];
        $database_local = $establecimientoRS_rows['name_database'];
        $username_local = $establecimientoRS_rows['username_database'];
        $password_local = $establecimientoRS_rows['password_database'];
        $_SESSION['nombre_establecimiento'] = $establecimientoRS_rows['nombre_establecimiento'];

        //CREAMOS NUEVA CONEXION CON LOS DATOS RECUPERADOS
        $conn_local = mysqli_connect($hostname_local, $username_local, $password_local) or trigger_error(mysqli_connect_error(), E_USER_ERROR);
        mysqli_select_db($conn_local, $database_local);

        //RECUPERAMOS DATOS DEL USUARIO EN EL LOCAL
        $LoginRS__query = "SELECT nickUsuario, passwordUsuario, nivelPermisoUsuario FROM usuarios WHERE nickUsuario='$loginUsername' AND passwordUsuario='$password'";
        $LoginRS = mysqli_query($conn_local, $LoginRS__query);
        $LoginRS_rows = mysqli_fetch_array($LoginRS);
        $loginFoundUser = mysqli_num_rows($LoginRS);

        //COMPROBAMOS SI EL USUARIO ESTA EN EL LOCAL
        if ($loginFoundUser) {

            $loginStrGroup = $LoginRS_rows['nivelPermisoUsuario'];
            if (PHP_VERSION >= 5.1) {
                session_regenerate_id(true);
            } else {
                session_regenerate_id();
            }

            //declare two session variables and assign them
            $_SESSION['MM_Username'] = $loginUsername;
            $_SESSION['MM_UserGroup'] = $loginStrGroup;
            //$_SESSION['MM_Zona'] = $zona; 
            //
            //DECLARAMOS VARIABLES DE SESION PARA LA CONEXION
            $_SESSION['hostname_database'] = $hostname_local;
            $_SESSION['name_database'] = $database_local;
            $_SESSION['username_database'] = $username_local;
            $_SESSION['password_database'] = $password_local;

            //CREAMOS COKKIE DE ESTABLECIMIENTO
            setcookie("establecimiento", $idEstablecimiento, time() + 3600 * 24 * 365);   
            
            //CREAMOS COKKIE DE IDIOMA
            setcookie("idioma", $idioma, time() + 3600 * 24 * 365);   
            
            if (isset($_SESSION['PrevUrl']) && false) {
                $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
            }
            header("Location: " . $MM_redirectLoginSuccess);
        } else {
            header("Location: " . $MM_redirectLoginFailed);
        }
    } else {
        header("Location: " . $MM_redirectEstFailed);      
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../estilos/w3.css">
        <link rel="stylesheet" href="../estilos/w3-theme-indigo.css">
        <link rel="stylesheet" href="..\font-awesome-4.7.0\css\font-awesome.min.css">
        <script type="text/javascript" src="../envCam/jquery-mobile/jquery.js"></script>
        <script src="../includes/jquery.cookie.js" type="text/javascript"></script>
        <title><?php echo $titleSheet; ?></title>
        <style type="text/css">
        </style>
        
        <script type="text/javascript">
            
        $(window).load(function () {
            var errorEstablecimiento = <?php echo $errorEstablecimiento;?>;
            var errorLogin = <?php echo $errorLogin;?>;
            if (errorEstablecimiento == 1){
                document.getElementById('id02').style.display = 'block';
            }
            
            if (errorLogin == 1){
                document.getElementById('id01').style.display = 'block';
            }
            
            var cokie = $.cookie('idioma');            
            if(typeof cokie !== 'undefined'){                
                $("#idioma > option[value='" + cokie + "']").attr('selected', 'selected');
            }        
            
        });
        
        function recarga(valor){
            if(valor = 1){
                document.getElementById('id01').style.display='none'
                location.href = 'accesoUsuarioAdmin.php?errorlogin=0';
            }
            if(valor = 2){
                document.getElementById('id02').style.display='none'
                location.href = 'accesoUsuarioAdmin.php?errorestablecimiento=0';
            }
        }
        
        </script>
    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
</head>

    <body>
        <header class="w3-card-4 w3-theme header w3-padding-large" style="height: 100px;">
            <div class ="w3-margin" style="float: left;"><img src="../imagenes/mano.png" class="w3-round-small" alt="Norway" style="width:40px;height: 40px;"></div>
            <div class="w3-xxxlarge" style="width: 50%;float: left;">COMANDER</div>
            <div class="w3-xlarge w3-right" style="margin-top: 20px;margin-right: 10px;"><?php echo $headerTitle; ?></div>
        </header>
        <br>
        <div class="w3-container w3-theme-l2"><h2><?php echo $instruccionsAcces; ?></h2></div>
        <div style="width: 25%;margin-left: 40px;">

            <form action="<?php echo $loginFormAction; ?>" method="POST" name="formRecepcion" class="w3-container">
                <br />
                <label class="w3-label w3-text-grey"><b><?php echo $userTag; ?></b></label>
                <input class="w3-input w3-light-grey" name="apodo" type="text" required size="20" maxlength="20" style=";border: 1px;border: solid;border-color: #000000" value="<?php echo $loginUsername?>" />
                <br><br><br>
                <label class="w3-label w3-text-grey"><b><?php echo $passwordTag; ?></b></label>
                <input class="w3-input w3-light-grey" name="password" type="password" required size="20" maxlength="20" style="border: 1px;border: solid;border-color: #000000" value="<?php echo $password?>" />
                <br><br><br>
                <?php if(!$haycokkie){ ?>
                <label class="w3-label w3-text-grey"><b><?php echo $codeStablishmentTag; ?></b></label>
                <input class="w3-input w3-light-grey" name="idEstablecimiento" type="number" min=1 required size="20" maxlength="20" style="" value="<?php echo $idEstablecimiento ?>" />
                <br><br><br>                
                <?php }?>
                <select id="idioma" class="w3-select w3-border" name="idioma">
                    <option id="es" value="es" selected>Idioma: Español</option>
                    <option id="ca" value="ca">Idioma: Català</option>
                    <option id="en" value="en">Language: English</option>
                </select>
                <br><br><br>
                <button class="w3-btn w3-blue-grey" onclick="document.getElementById('formulario').submit();"><?php echo $enterButton; ?></button>
                <br><br>                
                <?php if($haycokkie){ 
                echo $codeStablishmentTag." " . $idEstablecimiento ?>
                <br><br><br>
                <a href="borrarest.php?borraest=1"><?php echo $changeEstablishment; ?></a>
                <?php }?>                
            </form> 
        </div>
        
        <footer class="w3-container w3-bottom w3-padding-0">
            <div style="">
                <button class="w3-indigo w3-small w3-center w3-margin-top w3-padding-small" style="width: 100%;"><?php echo $footerButton; ?></button>
            </div>
        </footer>

        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <header class="w3-container w3-theme-l2"> 
                  <span onclick="document.getElementById('id01').style.display='none'" 
                  class="w3-closebtn">&times;</span>
                  <h3><?php echo $errorLoginTag; ?></h3>
                </header>
                <div class="w3-container">
                  <p><?php echo $descriptionErrorLogin; ?></p>
                </div>
                <button class="w3-btn w3-large w3-theme" style="width: 100%;" onclick="recarga(1)"><?php echo $aceptedTag; ?></button>
              </div>
        </div>
        
        <div id="id02" class="w3-modal">
            <div class="w3-modal-content">
                <header class="w3-container w3-theme-l2"> 
                  <span onclick="document.getElementById('id02').style.display='none'" 
                  class="w3-closebtn">&times;</span>
                  <h3><?php echo $errorTag; ?></h3>
                </header>
                <div class="w3-container">
                  <p><?php echo $descriptionErrorEstablishment; ?></p>
                </div>
                <button class="w3-btn w3-large w3-theme" style="width: 100%;" onclick="recarga(2)"><?php echo $aceptedTag; ?></button>
              </div>
        </div> 
    </body>
</html>

