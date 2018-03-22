function sendPushSinPedido(tipo,usuario) {

    var mensaje;                    

    if (tipo == 1) {
        mensaje = 'PAGAR EN METALICO';
    }
    if (tipo == 2) {
        mensaje = 'PAGAR CON TARJETA DE CREDITO';
    }
    if (tipo == 3) {                    
        mensaje = 'NECESITO AYUDA';                    
    }    

    var notificacion = {'idUsuario':usuario,
                'mensaje': mensaje, 'tipo':tipo};

   $.ajax({
        type: 'POST',
        url: "../Usuario/sendUsuario.php",
        data: notificacion,
        success: function (data) {
            if ($.trim(data) === "OK") {
            } else {
            }
        },
        error: function () {
        }
    });
}



