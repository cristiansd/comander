<?php
require_once('../includes/funcionesUsuario.php');

$MM_authorizedUsers = "1,2,3";
$MM_donotCheckaccess = "false";

include '../includes/errorIdentificacionUsuario.php';

require_once('vendor/autoload.php');

if (filter_input(INPUT_GET, 'amount')) {
    $amount = filter_input(INPUT_GET, 'amount');
    $charge = $amount * 100;
}
if ($_POST) {
    \Stripe\Stripe::setApiKey("sk_test_cxGq0UKazBqFWIueCZcSe3qh");
    $error = '';
    $success = '';
    try {
        if (!isset($_POST['stripeToken']))
            throw new Exception("The Stripe Token was not generated correctly");
        \Stripe\Charge::create(array(
            "amount" => $charge,
            "currency" => "eur",
            "card" => $_POST['stripeToken'],
            "receipt_email" => "cristsd84@gmail.com"));
        header('Location:enviarPedidoUsuario.php?amount=' . $amount);
    } catch (Exception $e) {
        header('Location:errorPago.php');
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>  
        <script src="jquery.payment-master/lib/jquery.payment.js"></script>        
        <style type="text/css" media="screen">
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
            .no-seleccionable {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none; 
            }

            .has-error input {
                border-width: 2px;
            }

            .validation.text-danger:after {
                content: 'Fallo de validación';
            }

            .validation.text-success:after {
                content: 'Validación correcta';
            }

            .centro {;
                     text-align: center;
            }
            .clear{
                display:inline;
                width: 47.5%;
                text-align: center;
            }
            .salto{
                display: block;

            }
            .tamaño{
                width: 100%;
                /* padding-left: 10%;
                 padding-right: 10%;*/
                padding: 10%;
                text-align: center;
            }
            .form-control{
                text-align: center;

            }
            .cvc{
                /* width: 70px;*/
                /*padding-left: 35%;*/
                /* padding-right: 35%;
                 /*float: bottom;*/

            }

        </style>        
        <script type="text/javascript">

            var tokens = 0;

            //FUNCION PARA MOSTRAR TOAST
            function toast(text) {
                $('.toast').text(text);
                $('.toast').fadeIn(400).delay(2000).fadeOut(400);
            }
            //FUNCION PARA EL MANEJO DEL CLICK EN CARTA EN LA BARRA DE OPCIONES
            function clickCarta() {
                $("#productos").css("border", "1px solid #cdcdcd");
                $("#carta").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('verCategoriasUsuario.php');
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN MI LISTA EN LA BARRA DE OPCIONES
            function clickMiLista() {
                $("#productos").css("border", "1px solid #cdcdcd");
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('listaTiempoRealUsuario.php');
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN BUSCAR EN LA BARRA DEL HEADER
            function clickBuscar() {
                $("#productos").css("border", "1px solid #cdcdcd");
                $("#lista").css("border-bottom", "5px solid #3f51b5");
                loadPage();
                conection('productosBuscarUsuario.php');
            }

            //FUNCION PARA MANEJAR EL CLICK EN AYUDA CAMARERO   
            function clickAyudaNotificacion() {
                document.getElementById('id1').style.display = 'block';
            }

            //FUNCION PARA GESTIONAR EL ENVIO DE PETICION DE AYUDA
            function confirmacionNotificacion() {
                pedirPagar(3, '<?php echo $_SESSION['id_usuario']; ?>');
                document.getElementById('id1').style.display = 'none';
                toast("<?php echo $sentToWaiterToast; ?>");
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN PRINCIPAL EN LA BARRA DEL HEADER
            function atras() {
                loadPage();
                window.history.back();
            }

            //FUNCION PARA CARGAR EL DIV CARGAR
            function loadPage() {
                $("#container").css("display", "none");
                $("#cargar").css("display", "block");
            }

            //FUNCION PARA EL MANEJO DEL CLICK EN PRINCIPAL EN LA BARRA DEL HEADER
            function clickEnPrincipal() {
                loadPage();
                conection('principalUsuario.php');
            }
            
            //FUNCION PARA COMPROBAR QUE ESTAN TODOS LOS DIGITOS DE LA TARGETA DE CREDITO
            function comprobarnumTargeta(){
                var n = $("#cc-number").val().length;
                if(n != 19){
                    return false;
                }else{
                    return true;
                }
            }

            //FUNCION PARA COMPROBAR EL MES
            function comprobarMes(month, year) {
                var n = year.toString();
                var literalYear = "20" + n;
                var numericYear = parseInt(literalYear);
                var fecha = new Date();
                var ano = fecha.getFullYear();
                var mes = fecha.getMonth();
                if (numericYear == ano && month < (mes+1)) {
                    $('.month').css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                    $("#cc-exp-month").focus();
                    return false;
                } else {  
                    $("#cc-cvc").focus();
                    return true;
                }
            }

            function correcto(location) {
                window.location.href = location + '?amount=' + <?php echo $amount; ?>;
            }
            
            //FUNCION PARA COMPROBAR EL MES UNICO
            function comprobarUnicMes(mes){
                var n = mes;
                if(n > 12 || n < 1){
                    $('.month').css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                    $("#cc-exp-month").focus();
                    return false;
                } else {
                    $("#cc-exp-month").css("border", "3px solid #17A05E");
                    $("#cc-exp-year").focus();
                    return true;
                }
            }

            //FUNCION PARA COMPROBAR EL AÑO
            function comprobarYear(year) {
                var n = year.toString();
                var literalYear = "20" + n;
                var numericYear = parseInt(literalYear);
                var fecha = new Date();
                var ano = fecha.getFullYear();
                if (numericYear < ano) {                   
                    $('.year').css({'border-width': '3px', 'border-color': '#a94442'}).val('');                    
                    $("#cc-exp-year").focus();
                    return false;
                }else{
                    $("#cc-exp-year").css("border", "3px solid #17A05E");
                    //comprobarMes($("#cc-exp-month").val(), $("#cc-exp-year").val());
                    $("#cc-cvc").focus();
                    return true;
                }
            }
            
            //FUNCION PARA COMROBAR EL CCV
            function comprobarCCV(){
                if ($("#cc-cvc").val().length != 3){
                    return false;
                }else{
                    return true;
                }
            }

            function comprobar() {
                if (tokens <= 1) {
                    $("#pay").prop('disabled', false);
                    tokens++;

                    $("#payment-form").submit(function (e) {
                        // $('.cc-exp-month').css({'color':'red','font-size':'1.3em','background':'yellow'});   
                        loadPage();
                        $("#payment-form").prop('disabled', true);
                        comprobarMes($('.month').val(), $('.year').val());
                        comprobarYear($('.year').val());
                        e.preventDefault();


                        // disable the submit button to prevent repeated clicks
                        // $('.btn btn-lg btn-primary').attr("disabled", "disabled");


                        var cardType = $.payment.cardType($('.cc-number').val());
                        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
                        //$('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
                        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));

                        //IMPLEMENTADO POR CRISTIAN
                        //$('.#cc-exp-month').css({'color':'red','font-size':'1.3em','background':'yellow'});
                        //$('.cc-exp-month').toggleInputError(!$.payment.validateMonth($('.cc-exp-month').val()).);       

                        $('.validation').removeClass('text-danger text-success');
                        $('.validation').addClass($('.has-error').length ? 'text-danger' : 'text-success');

                        // disable the submit button to prevent repeated clicks
                        //$('.btn-primary').attr("disabled", "disabled");

                        // createToken returns immediately - the supplied callback submits the form if there are no errors
                        Stripe.createToken({
                            number: $('.cc-number').val(),
                            cvc: $('.cc-cvc').val(),
                            exp_month: $('.month').val(),
                            exp_year: $('.year').val(),
                            address_country: 'SPAIN'
                        }, stripeResponseHandler);
                        return false; // submit from callback
                    });
                } else {
                    $("#pay").prop('disabled', true);
                }
            }


            function comprobacion() {
                $.ajax({
                    url: "comprobarTemporalUsuario.php",
                    success: function (data) {

                        if ($.trim(data) === "OK") {

                        } else {
                            conection('principalUsuario.php');
                        }
                    }
                });
            }
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('pk_test_gO06k6oYsxwzxwdPBmpQZ4lE');

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    conection('errorPago.php');
                    $(".payment-errors").html(response.error.message);
                    tokens = 0;

                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }

            jQuery(function ($) {
                $('[data-numeric]').payment('restrictNumeric');
                $('.cc-number').payment('formatCardNumber');
                //$('.cc-exp').payment('formatCardExpiry');
                $('.cc-cvc').payment('formatCardCVC');

                //implementado por cristian   

                $.fn.toggleInputError = function (erred) {
                    this.parent('.form-group').toggleClass('has-error', erred);
                    return this;
                };
            });
            
            //FUNCION PARA REALIZAR UN COMPROBACION TOTAL
            function comprobacionTotal(){
                switch(false){
                    case comprobarnumTargeta():
                        $('.cc-number').css({'border-width': '3px', 'border-color': '#a94442'}).val(''); 
                        $("#cc-cvc").css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-number").focus();
                        $("#pay").css("display", "none"); 
                        break;
                    case comprobarUnicMes($("#cc-exp-month").val()):
                        $('.month').css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-cvc").css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-exp-month").focus();
                        $("#pay").css("display", "none"); 
                        break;
                    case comprobarYear($(".year").val()):
                        $('.year').css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-cvc").css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-exp-year").focus();
                        $("#pay").css("display", "none"); 
                        break;
                    case comprobarMes($("#cc-exp-month").val(), $("#cc-exp-year").val()):
                        $('.month').css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-cvc").css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-exp-month").focus();
                        $("#pay").css("display", "none"); 
                        break;
                    case comprobarCCV():
                        $("#cc-cvc").css({'border-width': '3px', 'border-color': '#a94442'}).val('');
                        $("#cc-cvc").focus();
                        $("#pay").css("display", "none"); 
                        break;
                    default:
                        //$("#pay").removeClass("w3-disabled");   
                        $("#pay").css("display", "block");   
                }
            }


            var imagen;
            var height;
            var lista;
            var width;
            $(document).ready(function () {
                comprobacion();
                $("#pay").prop('disabled', true);
                comprobar();
                height = $(window).height();
                width = $(window).width();
                imagen = "px;width:" + ((width / 100) * 35) + "px;";
                $("#cc-exp-month").attr("style", imagen);
                $("#cc-exp-year").attr("style", imagen);
                $("#cc-number").on('keyup', function () {
                    $("#cc-cvc").val('');
                    var value = $(this).val().length;
                    if (value == 19) {
                        $("#cc-number").css("border", "3px solid #17A05E");
                        $("#cc-exp-month").focus();
                    }
                });
                $("#cc-exp-month").on('keyup', function () {
                    $("#cc-cvc").val('');
                    var value = $(this).val().length;
                    if (value == 2) {
                        $("#cc-exp-month").css("border", "3px solid #17A05E");
                        comprobarUnicMes($("#cc-exp-month").val());
                    }
                });
                $("#cc-exp-year").on('keyup', function () {
                    $("#cc-cvc").val('');
                    var value = $(this).val().length;
                    if (value == 2) {
                        comprobarYear($("#cc-exp-year").val());                                              
                    }
                });
                $("#cc-cvc").on('keyup', function () {
                    var value = $(this).val().length;
                    if (value == 3) {
                        $("#cc-cvc").css("border", "3px solid #17A05E");
                        $("#cc-cvc").blur();
                        comprobacionTotal();
                }            
                });
            });
        </script>        

    </head>
    <meta name="viewport" content="width=device-width"/>    
    <?php include '../includes/importacionesUsuario.php'; ?>  
    <body class="w3-light-grey">
        <?php cabeceraNavegacionUsuario($autoayment, 0, 0); ?>
        <div id="container" style="margin-top: 100px;">
            <style type="text/css">
                .imgbg {
                    background-color:#ef975d;

                }
                .ui-icon-bars{
                    background-color:#ef975d;
                }
            </style>
            <script>
                $("#ui-link ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-shadow ui-corner-all").css("color", "#33ffe6");
            </script>

            <form novalidate autocomplete="on" action="" method="POST" id="payment-form" >
                <div class="form-group w3-center">
                    <label for="cc-number" class="control-label"><?php echo $numberTarget; ?> <small class="text-muted"></small></label>
                    <input id="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="off" placeholder="•••• •••• •••• ••••" required>
                </div>
                <div class="form-group w3-center">
                    <label id= "cc-exp" for="cc-exp" class="control-label salto" ><?php echo $expirationDate; ?></label>
                    <!--<input type="text" size="2" class="card-expiry-month"/>-->
                    <input id="cc-exp-month" type="tel" maxlength="2" class="input-lg form-control clear month" autocomplete="off" placeholder="••" required>
                    <span> / </span>
                    <input id="cc-exp-year" type="tel" maxlength="2" class="input-lg form-control clear year" autocomplete="off" placeholder="••" required>
                </div>
                <div class="form-group w3-center">
                    <label for="cc-cvc" class="control-label ">CVC</label>
                    <input id="cc-cvc" type="tel" class="input-lg form-control cc-cvc cvc " autocomplete="off" placeholder="•••" required>
                </div>
                <button id="pay" class="w3-large w3-container w3-theme-l2 w3-bottom w3-padding-16 w3-btn-block w3-margin-top"           
                        style="display:none" onclick="comprobar();"><?php echo $payTag; ?> <?php echo number_format($amount, 2); ?> €</button>        


                <!--<h2 class="validation"></h2>-->
            </form>
        </div>
        <div id="id1" class="w3-modal" style="display: none">
            <div class="w3-container w3-section w3-yellow w3-center">
                <span onclick="document.getElementById('id1').style.display = 'none';" class="w3-closebtn">&times;</span>
                <h3><?php echo $atentionTag; ?></h3>
                <div id="prueba"></div>
                <b><?php echo $sentNotfificationToWaiter; ?></b><br>
                <b><?php echo $confirmNotification; ?></b><br><br>
                <div class="w3-margin-top w3-margin-bottom w3-center">
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-right: 5px;" id="" onclick="confirmacionNotificacion();"><?php echo $yesTag; ?></button>
                    <button class="w3-btn w3-indigo w3-small" style="width:30%;margin-left: 5px;" id="" onclick="document.getElementById('id1').style.display = 'none';" class="w3-closebtn"><?php echo $nonTag; ?></button>                       
                </div>
            </div>    
        </div>
        <img id="cargar" src="../imagenes/UsuarioImages/page-loader.gif" style="display: none; margin: 35% 35%; margin-top:150px!important">
        <div id="sinConexion" class="w3-modal w3-top">
            <div class= "w3-container  w3-center w3-light-grey">
                <br><br><br><br>  
                <img src="../imagenes/UsuarioImages/alerta.jpg" width="128" height="128"><br>
                <br>
                <div class="w3-large w3-margin-top">
                    <?php echo $errorServer; ?>
                    <br>
                    <?php echo $checkInternet; ?>
                </div>
                <br><br><br> 
                <a class="w3-btn w3-white w3-border w3-round w3-card-4" style="width: 100%;" onclick="reload()"><?php echo $retrieveTag; ?></a>
            </div> 
        </div>
    </body>
    <div class='toast' style='display:none'>TOAST</div>
</html>
