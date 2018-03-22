<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
        <script type="text/javascript" charset="UTF-8" src="jquery-mobile/jquery.js"></script>
    </head>
    <?php
    include '../includes/importacionesUsuario.php';
    require_once('../includes/funcionesUsuario.php');

    $MM_authorizedUsers = "1,2,3";
    $MM_donotCheckaccess = "false";
    ?>
    <?php include '../includes/importacionesUsuario.php'; ?>  
    <body class="w3-light-grey">
        <?php cabeceraNavegacionUsuario("Autopago", 0, 0); ?>
        <div id="sesionCaducada" class="w3-modal w3-top" style="display: block;">
            <div class= "w3-container  w3-center w3-light-grey">
                <br><br><br><br>  
                <img src="../imagenes/UsuarioImages/alerta.jpg" width="128" height="128"><br>
                <br>
                <div class="w3-large w3-margin-top">
                    SE HA PRODUCIDO UN ERROR EN EL PAGO.
                    PUEDE QUE ALGÚN DATO NO SEA CORRECTO.
                    <br><br>
                    NO SE HA REALIZADO CARGO A LA TARGETA DE CREDITO.
                    <br><br>
                    INTENTALO DE NUEVO.
                </div><br> 
                <a class="w3-btn w3-white w3-border w3-round w3-card-4" style="width: 100%;" onclick="window.location.href = 'listaTiempoRealUsuario.php'">ACEPTAR</a>
            </div> 
        </div>  
    </body>
</html>
