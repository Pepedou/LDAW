/*Casos*/
function llenaCasos() {

    var nombre_status = "";
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicios_Tv.php";

    var params = {
        op: "casos",
        entidad: "Cliente",
        'params[id]': myUser.id
    };
    $
            .ajax({
                url: myurl,
                dataType: 'jsonp',
                crossDomain: true,
                data: params,
                success: function(data) {

                    $.each(data.Resultados, function(i, resultado) {

                        if (resultado.status === 1) {
                            nombre_status = "Activo";

                        } else {
                            nombre_status = "Inactivo";
                        }

                        var row = $("<tr><td>" + resultado.nombre + "</td><td>"
                                + resultado.descripcion + "</td><td>"
                                + nombre_status + "</td></tr>");
                        $("#casos").append(row);

                    });
                    cambiaTabla();

                },
                timeout: 3000, // 3 second timeout,
                error: function(jqXHR, status, errorThrown) { // the status
                    // returned will
                    // be "timeout"
                    alert(status
                            + ": No se pudo conectar con el servidor. Intente de nuevo.");
                }
            });

}


/*Conversión de la tabla a tabla dinámica*/
function cambiaTabla() {

    $('#casos').dataTable({
        "scrollY": "200px",
        "scrollCollapse": true,
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            /* imagine aData[0] is an object, not a string {text: 'X1', title: 'Title X1'} */
            // $('td:eq(0)', nRow).addClass("registros");
            $(nRow).addClass('registros');
            return nRow;
        },
        "language": {
            "lengthMenu": "Mostrar _MENU_ resultados",
            "zeroRecords": "Lo sentimos, no hay resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay resultados disponibles",
            "sSearch": "Buscar: ",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });

}




/*Recupera el id del Cliente*/
function procesa() {

    var params = getSearchParameters();
    var id = params.id;
    myUser = {
        "id": id

    };
    llenaCasos();

}

$(document).ready(function() {
    procesa();
});