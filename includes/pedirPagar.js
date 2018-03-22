
 function pedirPagar(tipo,usuario) {
                $.ajax({
                    type: 'POST',
                    url: "../Usuario/comprobarCamarero.php",
                    success: function (data) {
                        if ($.trim(data) === "null") {
                            sendPushSinPedido(tipo,usuario);
                        } else {
                            sendPushCamareroSinPedido(tipo,$.trim(data),usuario);
                        }
                    },
                    error: function () {
                    }
                });
            }