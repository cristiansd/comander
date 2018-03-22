function sendPush(tipo, usuario, pedido) {

    var mensaje;

    if (tipo == 1) {
        mensaje = 'PAGAR EN METALICO';
    }
    if (tipo == 2) {
        mensaje = 'PAGAR CON TARJETA DE CREDITO';
    }
    if (tipo == 3) {
        mensaje = 'PEDIDO PAGADO ASIGNAR CAMARERO';
    }

    $.ajax({
        type: 'POST',
        url: "../Usuario/comprobarCamarero.php",
        success: function (data) {
            if ($.trim(data) === "null") {
                sendPushAutopago(4, usuario,pedido);
            } else {
                sendPushAutopago(5, $.trim(data), usuario,pedido);
            }
        },
        error: function () {
        }
    });
}

