
function conection(url) {
    window.setTimeout("timeOut()", 10000);
   $.ajax({
        type: "GET",
        url: url,
        success: function (msg) {

            window.location.href = url;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            timeOut();
        }
    });
}

function timeOut(){
     $("#sinConexion").css("display", "block");
}

function reload() {
                location.reload();
            }


