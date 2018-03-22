function sendPushAutopago(tipo,usuario,pedido) {

    var mensaje;                    

    
    if (tipo == 4) {                    
        mensaje = 'PEDIDO PAGADO ASIGNAR CAMARERO';                    
    } 
    if (tipo == 5) {                    
        mensaje = 'NUEVO PEDIDO EN MESA';                    
    } 

    var notificacion = {'idUsuario':usuario,
                'mensaje': mensaje,
                'idPedido':pedido};

   $.ajax({
        type: 'POST',
        url: "../Usuario/sendUsuario.php",
        data: notificacion,
        success: function (data) {
        },
        error: function () {
        }
    });
}

