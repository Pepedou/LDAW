/*Funcion para Redireccionar
 * @param id es el id del Cliente
 * @param op opcion a elegir entre abogados, casos y pagos
 * */
myUser = {
    "id": -1,
    "nombre": "",
    "apellidoP": "",
    "apellidoM": "",
    "telefono": "",
    "email": ""

};

function getUserData(email) {

    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php";
    var params = {
        op: "si",
        entidad: "Cliente",
        'params[email]': email
    };
    $.ajax({
        url: myurl,
        dataType: 'jsonp',
        crossDomain: true,
        data: params,
        success: function(data) {
            
            $.each(data.Resultados, function(i, resultado) {

                myUser = {
                    "id": resultado.id,
                    "nombre": resultado.nombre,
                    "apellidoP": resultado.apellidoP,
                    "apellidoM": resultado.apellidoM,
                    "telefono": resultado.telefono,
                    "email": resultado.email
                };
            });
        },
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {   //the status returned will be "timeout" 
            alert(status + ": No se pudo conectar con el servidor. Intente de nuevo.");
        }
    });
}


function mandaDireccion(id, op) {

    switch (op) {
        case 1: //pagos
            url = "pagos.html?id=" + id;
            window.location.href = url;
            break;
        case 2:
            url = "abogados.html?id=" + id;
            window.location.href = url;
            break;
        case 3:
            url = "casos.html?id=" + id;
            window.location.href = url;
            break;
    }

}

$(document).ready(function() {


    $("#refpagos").click(function() {
        mandaDireccion(myUser.id, 1);
    });
    $("#pagosref").click(function() {
        mandaDireccion(myUser.id, 1);
    });
    $("#refabogados").click(function() {
        mandaDireccion(myUser.id, 2);
    });
    $("#abogadosref").click(function() {
        mandaDireccion(myUser.id, 2);
    });
    $("#refcasos").click(function() {
        mandaDireccion(myUser.id, 3);
    });
    $("#casosref").click(function() {
        mandaDireccion(myUser.id, 3);
    });
});

