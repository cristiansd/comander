function sendPushCamarero(tipo,camarero,pedido,usuario,mesa) {

    var mensaje;

    if (tipo == 1) {
        mensaje = 'PAGAR EN METALICO';
    }
    if (tipo == 2) {
        mensaje = 'PAGAR CON TARJETA DE CREDITO';
    }
    if (tipo == 3) {                    
        mensaje = 'NUEVO PEDIDO EN MESA ' + mesa;                    
    } 

    var notificacion = {'idUsuario':usuario,
                'mensaje': mensaje,
                'idPedido':pedido,
                'idCamarero':camarero,
                'tipo':4};


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

