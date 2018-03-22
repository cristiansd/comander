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
            
            .rellena{
                background-repeat:no-repeat ;
                -moz-background-size: 100% 100%;           /* Gecko 1.9.2 (Firefox 3.6) */
                -o-background-size: 100% 100%;           /* Opera 9.5 */
                -webkit-background-size: 100% 100%;           /* Safari 3.0 */
                background-size: 100% 100%;           /* CSS3-compliant browsers */ 
                background-size: cover;  /* Gecko 1.9.1 (Firefox 3.5) */
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
                //tope = "width: 100%;height: 1px;color: white;-webkit-transition: height 0.5s;transition: height 0.5s;";
                //$("#tituloportada").attr("style", tope);
                console.log(tope);
                $("#tituloportada").height(70);
                $("#divmenu").attr("style", "width: 70%;position: fixed;top: 34px;left: " + (ancho/4.5)+ "px;display: none;");
                $('#divmenu').fadeIn(900);
                $("#foto1").attr("style", "position: absolute;height: " + (altura-1) + "px;width: 100%;display: none;");
                $("#foto1").fadeIn(800);
                $("#foto2").attr("style", "position: absolute;height: " + (altura-1) + "px;width: 100%;display: none;");
                $("#foto3").attr("style", "position: absolute;height: " + (altura-1) + "px;width: 100%;display: none;");
                $("#marcoservicios").attr("style", "text-align: center;width: 70%;height: " + (altura*70)/100 + "px;margin-top: 5%;;margin-right: auto;margin-bottom: 0;margin-left: auto;text-align: center;");
                console.log(altura + " / " + ancho);
                carousel();
            });
            
            //FUNCION PARA MOSTRAR TOAST
            function toast(text) {
                $('.toast').text(text);
                $('.toast').fadeIn(400).delay(2000).fadeOut(400);
            }
            
            function goto(pagina){
                if (pagina !== currentpage){
                    $("#p" + currentpage).fadeOut(700);
                    $("#p" + pagina).fadeIn(700);
                    currentpage = pagina;
                }
            }
            
            function flip(elemento){
                $("#serv" + elemento).css({opacity: 0.4});
                //$("#serv" + elemento).fadeOut(500);
                console.log("in");
                $("#divtextoserv" + elemento).fadeIn(500);
            }
            
            function reflip(elemento){
                $("#serv" + elemento).css({opacity: 1});
                //$("#serv" + elemento).fadeOut(500);
                console.log("out");
                $("#divtextoserv" + elemento).fadeOut(500);
            }
            
            function carousel() {
                var tx;
                var ti;
                var i;
                var x = document.getElementsByClassName("mySlides");
                for (i = 0; i < x.length; i++) {
                   //x[i].style.display = "none";  
                }
                myIndex++;
                if (myIndex > x.length) {myIndex = 1;}    
                //x[myIndex-1].style.display = "block";
                switch(myIndex) {
                    case 1:
                        tx = "El motor que impulsa Iliadas Team es ofrecer un servicio para cada necesidad.";
                        ti = 4;
                    break;
                    case 2:
                        tx = "Nuestro objetivo es proporcionarle una inmediata y excelente solución a sus necesidades.";
                        ti = 3;
                    break;
                    case 3:
                        tx = "En Iliadas Team trabajamos siempre investigando sobre nuevas áreas de acción.";
                        ti = 1;
                    break;
                }
                $('#foto' + myIndex).fadeIn(800).delay(9900).fadeOut(800);
                animarTexto(tx,ti);
                $('#foto' + myIndex+1).fadeIn(800).delay(9900).fadeOut(800);
                console.log("foto_" + myIndex);
                setTimeout(carousel, 10000); // Change image every 2 seconds
            }
            
            function animarTexto(texto, tipo){
               var el = document.getElementById("divtexto");
               el.innerHTML = texto;
               
               //ANIMACION TEXTO
               switch(tipo) {
                    case 1:
                        $('.test').textFx({
                            type: 'fadeIn',
                            iChar: 100,
                            iAnim: 1000
                        });
                    break;
                    case 2:
                        $('.test').textFx({
                            type: 'slideIn',
                            direction: 'bottom',
                            iChar: 70,
                            iAnim: 1000
                        });
                    break;
                    case 3:
                        $('.test').textFx({
                            type: 'rotate',
                            iChar: 100,
                            iAnim: 1000
                        });
                    break;
                    case 4:
                        $('.test').textFx({
                            type: 'scale',
                            iAnim: 2000
                        });
                    break;
                }
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
                        $("#tituloportada").height(70);
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
        <div class="cabecera" id="tituloportada" style="padding-top: 6px;padding-bottom: 10px;width: 100%;height: 1px;color: white;-webkit-transition: height 0.8s;transition: height 0.8s;"></div>
        
        <!--DIV PRINCIPAL TRANSICIONES-->
        <div class="" id="portada" style="width: 100%;position: relative;">
            <!--PAGINA 1-->
            <div id="p1">
                <div id="fotoportada" style="width: 100%;position: absolute;">
                    <img class="mySlides" src="img/1.jpg" alt="" style="display: none;" id="foto1"/>
                    <img class="mySlides" src="img/2.jpg" alt="" style="display: none;" id="foto2"/>
                    <img class="mySlides" src="img/3.jpg" alt="" style="display: none;" id="foto3"/>
                </div>
                <div id="texto1" class="" style="width: 80%;margin-top: 0;margin-right: auto;margin-bottom: 0;margin-left: auto;position: relative;top: 350px;color: white;">
                    <div class="test w3-xxxlarge w3-center" id="divtexto"></div>
                </div>
            </div>
            
            <!--PAGINA 2-->
            <div id="p2" style="display: none;">
                <div id="fotopagi2" style="width: 100%;position: absolute;top: 1px;">
                    <div id="marcoservicios" style="">
                        <div id="serv1" class="rellena" style="position: relative;display: inline-block;width: 31%;height: 45%;margin-right: 3%;background-image: url('img/PROYECTOS_01.jpg')" onmouseover="flip(1);" onmouseout="reflip(1);">
                            <div id="divtextoserv1" style="position: absolute;z-index: 999;width: 100%;height: 100%;padding-top: 20px;font-weight: bold;font-size: 24px;color: white;display: none;">
                                Reconversión de espacios no utilizados, acciones puntuales dinamizando espacios desconocidos
                            </div>
                        </div>
                        <div id="serv2" class="rellena" style="position: relative;display: inline-block;width: 31%;height: 45%;background-image: url('img/PROYECTOS_02.jpg')" onmouseover="flip(2);" onmouseout="reflip(2);">
                            <div id="divtextoserv2" style="position: absolute;width: 100%;height: 100%;padding-top: 20px;font-weight: bold;font-size: 24px;color: white;display: none;">
                                Organización de talleres infantiles
                            </div>
                        </div>
                        <div id="serv3" class="rellena" style="display: inline-block;width: 31%;height: 45%;margin-left: 3%;background-image: url('img/PROYECTOS_03.jpg')" onmouseover="flip(3);" onmouseout="reflip(3);">
                            
                        </div>
                        
                        <div id="serv4" class="rellena" style="display: inline-block;width: 31%;height: 45%;margin-top: 3%;margin-right: 3%;background-image: url('img/PROYECTOS_04.jpg')" onmouseover="flip(4);" onmouseout="reflip(4);">
                            
                        </div>
                        <div id="serv5" class="rellena" style="display: inline-block;width: 31%;height: 45%;margin-top: 3%;background-image: url('img/PROYECTOS_05.jpg')" onmouseover="flip(5);" onmouseout="reflip(5);">
                            
                        </div>
                        <div id="serv6" class="rellena" style="display: inline-block;width: 31%;height: 45%;margin-top: 3%;margin-left: 3%;background-image: url('img/PROYECTOS_06.jpg')" onmouseover="flip(6);" onmouseout="reflip(6);">
                            
                        </div>
                    </div>
                </div> 
            </div>
        </div>
            
            
        
        <!--MENU CABECERA-->
        <div class="w3-xlarge" style="display: none;" id="divmenu">
            <ul id="nav" style="margin-left: 50px;">
                <li><a href="#" onclick="goto(1)">INICIO</a></li>
                <li><a href="#" onclick="goto(2)">SERVICIOS</a></li>
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
        
        <!--LOGO-->
        <img src="img/logo_trans.png" alt="" width="180" height="96" style="position: absolute;top:95px;left: 20px;display: none;" id="logo"/>
        
        <!--SOCIAL BUTTONS-->
        <div style="position: fixed; bottom: 120px;left: 65px;">
            <div style="float:left;">
                <a href="https://www.facebook.com/"><img src="img/fb.png" alt="" width="40" height="40" style="margin-right: 16px;"/></a>
            </div>
            <div style="float:left;">
                <a href="https://twitter.com/"><img src="img/twitter_1.png" alt="" width="40" height="40"/></a>
            </div>
            <div style="float:left;">
                <a href="https://plus.google.com/"><img src="img/google.png" alt="" width="40" height="40" style="margin-left: 16px;"/></a>
            </div>
        </div>   
        
        <footer class="w3-bottom" style="position: fixed;">
            <div class="w3-padding-large" style="background-color: #242424;color: white;">
                <div class="w3-center">2017 © Iliadas Team | Gran Via de les Corts Catalanes 600 pral. 1a 08007 Barcelona | iliadasteam@iliadasteam.com | Tel: +33  93 342 43 93 | Fax +34 93 342 57 28</div>
            </div>
	</footer>
    </body>
</html>
