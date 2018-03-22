<?php
require_once('../includes/funcionesPlataforma.php');
?>

<!DOCTYPE html>
<html>
    <head>    
        <meta charset="utf-8">
        <title>Principal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="../includes/funcionesUsuario.js"></script>
        <script type="text/javascript" charset="UTF-8" src="../plataforma/jquery-mobile/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.transit.js"></script> 
        <script type="text/javascript" src="jquery.textFx.js"></script>
        <script type='text/javascript' src='js/menu.js'></script>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />       
        <!--<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->


        <style type="text/css">
            
            html { overflow-y: hidden; }
            
            body { background-color: rgb(36,36,36); }
            
            .no-seleccionable {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
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
            
            .cabecera{
                background: rgba(19,19,19,1);
                background: -moz-linear-gradient(top, rgba(19,19,19,1) 0%, rgba(19,19,19,1) 3%, rgba(28,28,28,1) 50%, rgba(76,76,76,1) 89%, rgba(76,76,76,1) 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(19,19,19,1)), color-stop(3%, rgba(19,19,19,1)), color-stop(50%, rgba(28,28,28,1)), color-stop(89%, rgba(76,76,76,1)), color-stop(100%, rgba(76,76,76,1)));
                background: -webkit-linear-gradient(top, rgba(19,19,19,1) 0%, rgba(19,19,19,1) 3%, rgba(28,28,28,1) 50%, rgba(76,76,76,1) 89%, rgba(76,76,76,1) 100%);
                background: -o-linear-gradient(top, rgba(19,19,19,1) 0%, rgba(19,19,19,1) 3%, rgba(28,28,28,1) 50%, rgba(76,76,76,1) 89%, rgba(76,76,76,1) 100%);
                background: -ms-linear-gradient(top, rgba(19,19,19,1) 0%, rgba(19,19,19,1) 3%, rgba(28,28,28,1) 50%, rgba(76,76,76,1) 89%, rgba(76,76,76,1) 100%);
                background: linear-gradient(to bottom, rgba(19,19,19,1) 0%, rgba(19,19,19,1) 3%, rgba(28,28,28,1) 50%, rgba(76,76,76,1) 89%, rgba(76,76,76,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#131313', endColorstr='#4c4c4c', GradientType=0 );
            }
            
            #divmenu a:hover{
                cursor: pointer;
            }
            
        </style>

        <script type="text/javascript">
            var currentpage = 1;
            var altura;
            var ancho;
            var mitad;
            var tope;
            var myIndex = 0;
            
            $(window).load(function () {
                altura = $(window).height();
                ancho = $(window).width();
                mitad = altura/2;
                console.log(tope);
                $("#p2").fadeIn(700);
                $("#divmenu").attr("style", "width: 70%;position: fixed;top: 34px;left: " + ancho/4.5+ "px;display: none;");
                $("#marcoservicios").attr("style", "background-color: #FFFFFF;width: 70%;height: " + (altura*60)/100 + "px;margin-top: 5%;;margin-right: auto;margin-bottom: 0;margin-left: auto;text-align: center;");
                console.log(altura + " / " + ancho);
                carousel();
            });
            
            //FUNCION PARA MOSTRAR TOAST
            function toast(text) {
                $('.toast').text(text);
                $('.toast').fadeIn(400).delay(2000).fadeOut(400);
            }
            
            function goto(pagina){
                var url;
                switch(pagina){
                    case 1:
                    $("#p2").fadeOut(700);
                    url = "index.php";
                }
                window.location.href=url;
            }

            $(document).ready(function () {
                $('#logo').fadeIn(600);
                var mY = 0;
                $('body').mousemove(function(e) {
                    if (e.pageY > mitad - 150){
                        // moving upward
                        if (e.pageY < mY) {
                            //console.log('From Bottom');
                           /* $("#tituloportada").height(110);
                            $('#divmenu').fadeIn(800);*/

                        // moving downward
                        } else {
                            //console.log('From Top');
                            /*$("#tituloportada").height(1);
                            $('#divmenu').fadeOut(100);*/
                        }

                        // set new mY after doing test above
                        mY = e.pageY;
                    }
                });
                
                $('body').bind('mousewheel', function(e){
                    if(e.originalEvent.wheelDelta /120 > 0) {
                        console.log('scrolling up !');
                        $("#tituloportada").height(110);
                        $('#divmenu').fadeIn(800);
                    }
                    else{
                        console.log('scrolling down !');
                        $("#tituloportada").height(1);
                        $('#divmenu').fadeOut(100);
                    }
                });
            });
            
        </script>

        <?php include '../includes/importacionesUsuario.php'; ?>

    <body class="">
        
        <!--CABECERA-->
        <div class="cabecera" id="tituloportada" style="padding-top: 6px;padding-bottom: 10px;width: 100%;height: 1px;color: white;-webkit-transition: height 0.5s;transition: height 0.5s;"></div>
        
        <!--DIV PRINCIPAL TRANSICIONES-->
        <div class="" id="portada" style="width: 100%;position: relative;">
            <!--PAGINA 2-->
            <div id="p2" style="display: none;">
                <div id="fotopagi2" style="width: 100%;position: absolute;top: 1px;">
                    <div id="marcoservicios" style="">
                        <div style="display: inline-block;width: 25%;height: 40%;background-color: blue;"><img src="img/PROYECTOS_03.jpg" alt=""/></div>
                        <div style="display: inline-block;width: 25%;height: 40%;background-color: blue;"><img src="img/PROYECTOS_04.jpg" alt=""/></div>
                        <div style="display: inline-block;width: 25%;height: 40%;background-color: blue;"><img src="img/PROYECTOS_05.jpg" alt=""/></div>
                    </div>
                </div> 
            </div>
        </div>
            
            
        
        <!--MENU CABECERA-->
        <div class="w3-xlarge" style="display: none;" id="divmenu">
            <ul id="nav" style="margin-left: 50px;">
                <li><a href="#" onclick="goto(1)">INICIO</a></li>
                <li><a href="#" onclick="">SERVICIOS</a></li>
                <li><a href="#">RRHH</a>
                    <ul>
                        <li><a href="#">Personal Auxiliar</a></li>
                        <li><a href="#">Azafatas</a></li>
                        <li><a href="#">Personal Especializado</a></li>
                        <li><a href="#">Personal Técnico</a></li>
                    </ul>
                </li>
                <li><a href="#">CLIENTES</a></li>
                <li><a href="#">CONTACTO</a></li>
            </ul>
        </div>
        <img src="img/logo_trans.png" alt="" width="180" height="96" style="position: absolute;top:20px;left: 20px;display: none;" id="logo"/>
        <footer class="w3-bottom" style="position: fixed;">
            <div class="w3-padding-large" style="background-color: #242424;color: white;">
                <div class="w3-center">2017 © Iliadas Team | Gran Via de les Corts Catalanes 600 pral. 1a 08007 Barcelona | iliadasteam@iliadasteam.com | Tel: +33  93 342 43 93 | Fax +34 93 342 57 28</div>
            </div>
	</footer>
    </body>
</html>
