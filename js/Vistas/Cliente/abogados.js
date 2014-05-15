var AboActual = 1;
var promActual = 0;
function llenaAbogados() {

    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php";
    var primero = 1;
    var params = {
        op: "sti",
        entidad: "AbogadosClientes",
        'params[id_Cliente]': myUser.id,
        'params[campo]': "Abogado"
    };
    $
            .ajax({
                url: myurl,
                dataType: 'jsonp',
                crossDomain: true,
                data: params,
                success: function(data) {

                    $.each(data.Resultados, function(i, resultado) {
                        if (primero == 1) {
                            var row = $("<tr onclick=\"actualiza_abo(" + resultado.id + ")\"><td>" + resultado.id + "</td><td>"
                                    + resultado.nombre + "</td><td>" + resultado.apellidoP + "</td></tr>");
                            $("#abogados").append(row);
                            var nombre = $("<p>" + resultado.nombre + "&nbsp" + resultado.apellidoP + "&nbsp" + resultado.apellidoM + "</p>");
                            $("#nombre").append(nombre);
                            var tel = $("<p>" + resultado.telefono + "&nbsp </p>");
                            $("#telefono").append(tel);
                            var email = $("<p>" + resultado.email + "&nbsp </p>");
                            $("#email").append(email);
                            var imagen = $("<img alt=\"\" src=" + resultado.fotografia + " style=\"width: 362px; height: 217px; border-width: 5px; border-style: solid; float: left; margin-top: 20px; margin-bottom: 20px;\"/>");
                            $("#imagen").append(imagen);
                            llenaPuntaje(resultado.id);
                            AboActual = resultado.id;
                            primero++;
                        } else {
                            var row = $("<tr onclick=\"actualiza_abo(" + resultado.id + ")\"><td>" + resultado.id + "</td><td>"
                                    + resultado.nombre + "</td><td>" + resultado.apellidoP + "</td></tr>");
                            $("#abogados").append(row);
                        }

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
/*Funcion para recuperar la información del abogado seleccionado*/
function actualiza_abo(id) {
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php";
    var params = {
        op: "sii",
        entidad: "Abogado",
        'params[id]': id,
    };
    $
            .ajax({
                url: myurl,
                dataType: 'jsonp',
                crossDomain: true,
                data: params,
                success: function(data) {

                    $.each(data.Resultados, function(i, resultado) {

                        var row = $("<p>Nombre: <br>" + resultado.nombre + "&nbsp" + resultado.apellidoP + "&nbsp" + resultado.apellidoM + "</p>");
                        $("#nombre").html(row);
                        var tel = $("<p>Tel&eacute;fono: <br>" + resultado.telefono + "&nbsp </p>");
                        $("#telefono").html(tel);
                        var email = $("<p> Email: <br>" + resultado.email + "&nbsp </p>");
                        $("#email").html(email);
                        var imagen = $("<img alt=\"\" src=" + resultado.fotografia + " style=\"width: 362px; height: 217px; border-width: 5px; border-style: solid; float: left; margin-top: 20px; margin-bottom: 20px;\"/>");
                        $("#imagen").html(imagen);
                        AboActual = resultado.id;
                        llenaPuntaje(resultado.id);
                    });
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

    $('#abogados').dataTable({
        "scrollY": "100px",
        "scrollCollapse": true,
        "columnDefs": [
            {
                "targets": [0], //id invisible
                "visible": false,
                "searchable": false
            },
            {
                "targets": [1, 2],
                "visible": true,
            }
        ], //funcion para añadir una clase a las filas
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            /* imagine aData[0] is an object, not a string {text: 'X1', title: 'Title X1'} */
          // $('td:eq(0)', nRow).addClass("registros");
           $(nRow).addClass( 'registros' );
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
    
    $('#abogados_filter label').addClass('busca');
    $('#abogados_length label').addClass('mostrar');
   
}
/*Seleccionar El puntaje*/
function llenaPuntaje(id) {

    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php";
    var params = {
        op: "gcal",
        entidad: "Abogado",
        'params[id]': id
    };
    $
            .ajax({
                url: myurl,
                dataType: 'jsonp',
                crossDomain: true,
                data: params,
                success: function(data) {
                    var promedio = data.Resultados;
                    promActual = promedio;
                    set_votes(promedio);
                },
                timeout: 3000, // 3 second timeout,
                error: function(jqXHR, status, errorThrown) {
                    alert(status
                            + ": No se pudo conectar con el servidor. Intente de nuevo.");
                }
            });
}

function mandaVoto(puntos, id) {

    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php";
    var params = {
        op: "scal",
        entidad: "Abogado",
        'params[id]': AboActual,
        'params[puntos]': puntos
    };
    $
            .ajax({
                url: myurl,
                dataType: 'jsonp',
                crossDomain: true,
                data: params,
                success: function(data) {
                    alert("Registrado");
                    set_votes(puntos);
                },
                timeout: 3000, // 3 second timeout,
                error: function(jqXHR, status, errorThrown) {
                    alert(status
                            + ": No se pudo conectar con el servidor. Intente de nuevo.");
                }
            });
}

function getSearchParameters() {
    var prmstr = window.location.search.substr(1);
    return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
}

function transformToAssocArray(prmstr) {
    var params = {};
    var prmarr = prmstr.split("&");
    for (var i = 0; i < prmarr.length; i++) {
        var tmparr = prmarr[i].split("=");
        params[tmparr[0]] = tmparr[1];
    }
    return params;
}

function set_votes(promedio) {
    promActual = promedio;
    var avg = Math.round(promedio);
    $(califica).find('.star_' + avg).prevAll().andSelf().addClass('ratings_vote');
    $(califica).find('.star_' + avg).nextAll().removeClass('ratings_vote');
}

/*Recupera el id del Cliente*/
function procesa() {

    var params = getSearchParameters();
    var id = params.id;
    myUser = {
        "id": id

    };
    llenaAbogados();
}

$(document).ready(function() {
    procesa();
    /*Hover para colorear las estrellas on hover y las anteriores*/
    $('.ratings_stars').hover(
            // Handles the mouseover
                    function() {
                        $(this).prevAll().andSelf().addClass('ratings_over');
                        $(this).nextAll().removeClass('ratings_vote');
                    },
                    // Handles the mouseout
                            function() {
                                $(this).prevAll().andSelf().removeClass('ratings_over');
                                set_votes($(this).parent());
                            }
                    );
                    $('.ratings_stars').bind('click', function() {
                        var star = this;
                        var clicked_on = $(star).attr('id');
                        var voto_entero = parseInt(clicked_on);
                        mandaVoto(voto_entero, AboActual);
                    });
                });