cont = 0;
var AboActual = 1;
var promActual = 0;
var timer;

function generarGrafica(idAbogado) {
    var params = {
        "op": "des",
        "entidad": "Abogado",
        "params[id]": idAbogado
    };
    servicio(params, function(data) {
        $.each(data.Resultados, function(i, resultado) {
            var total = Number(resultado.total);
            var finalizadas = Number(resultado.finalizadas);
            var pendientes = total - finalizadas;
            var vencidas = Number(resultado.vencidas);
            $('#grafica').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Desempeño del abogado'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                        type: 'pie',
                        name: 'Tareas',
                        data: [
                            ['Pendientes', pendientes],
                            {
                                name: 'Completas',
                                y: finalizadas,
                                sliced: true,
                                selected: true,
                                color: "green"
                            },
                            {
                                name: 'Vencidas',
                                y: vencidas,
                                color: "red"
                            }
                        ]
                    }]
            });
        });
    });
}

function mostrarExpediente(id) {
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Vistas/vista-admin-expediente.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main_content").empty().append(data);
        },
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {   //the status returned will be "timeout" 
            alert(status + " " + errorThrown + ": No se pudo conectar con el servidor. Intente de nuevo.");
        }
    });
//Carga el expediente
    var params = {
        op: "sii",
        entidad: "Expediente",
        "params[id]": id
    };
    servicio(params, function(data) {
        $.each(data.Resultados, function(i, resultado) {
            var nombre = "Expediente " + resultado.nombre;
            $("#nombreExpediente span").append(nombre);
            var documentos = {
                op: "st",
                entidad: "Documento",
                "params[id_Expediente]": id
            };
            servicio(documentos, function(data) {
                $("#main_table thead").append("<tr><th>Documento</th><th>Tamaño</th><th>D</th><th>E</th></tr>");
                $.each(data.Resultados, function(i, resultado) {
                    $("#main_table tbody").append("<tr><td>" + resultado.nombre + "</td><td>" + Math.floor(parseInt(resultado.tamano) / 1024) +
                            " KB</td><td><button type=\"button\" onclick=\"window.open('" + resultado.documento +
                            "')\">Descargar</button></td><td><button type=\"button\" onclick=\"borrarDocumento(" + resultado.id + ");mostrarExpediente(" + id + ");\">Eliminar</button></td></tr>");
                });
            });

        });
        cambiaTabla();
    });
}

function mostrarCliente(id) {
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Vistas/vista-admin-cliente.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main_content").empty().append(data);
        },
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {   //the status returned will be "timeout" 
            alert(status + " " + errorThrown + ": No se pudo conectar con el servidor. Intente de nuevo.");
        }
    });
//Carga el cliente
    var params = {
        op: "sii",
        entidad: "Cliente",
        "params[id]": id
    };
    servicio(params, function(data) {
        $.each(data.Resultados, function(i, resultado) {
            var nombre = resultado.nombre + " " + resultado.apellidoP + " " + resultado.apellidoM;
            $("#nombre_cliente").append(nombre);
            var telefono = resultado.telefono;
            var email = resultado.email;
            $("#telefono_cliente").append(telefono);
            $("#email_cliente").append(email);
        });
    });
    var params = {
        op: "pagos",
        entidad: "Cliente",
        'params[id]': id
    };
    var myurl2 = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicios_Tv.php";
    $
            .ajax({
                url: myurl2,
                dataType: 'jsonp',
                crossDomain: true,
                data: params,
                success: function(data) {

                    $.each(data.Resultados, function(i, resultado) {

                        var row = $("<tr><td>" + resultado.id + "</td><td>"
                                + resultado.cantidad + "</td></tr>");
                        $("#pagos").append(row);

                    });
                    Tabla("pagos");

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

function mostrarCaso(id) {
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Vistas/vista-admin-caso.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main_content").empty().append(data);
        },
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {   //the status returned will be "timeout" 
            alert(status + " " + errorThrown + ": No se pudo conectar con el servidor. Intente de nuevo.");
        }
    });
    var params = {
        op: "sii",
        entidad: "Caso",
        "params[id]": id
    };
    servicio(params, function(data) {
        $.each(data.Resultados, function(i, resultado) {
            var nombre = resultado.nombre;
            var estado = resultado.status;
            var clienteID = resultado.id_Cliente;
            var despachoID = resultado.id_Despacho;
            $("#nombreCaso span").append(nombre);
            $("#estado span").append(estado === "1" ? "Activo" : "Cerrado");
            var cliente = {
                op: "sii",
                entidad: "Cliente",
                "params[id]": clienteID
            };
            servicio(cliente, function(data) {
                $.each(data.Resultados, function(i, resultado) {
                    $("#nombreCliente span").append(resultado.nombre + " " + resultado.apellidoP + " " + resultado.apellidoM);
                });
            });
            var despacho = {
                op: "sii",
                entidad: "Despacho",
                "params[id]": despachoID
            };
            servicio(despacho, function(data) {
                $.each(data.Resultados, function(i, resultado) {
                    $("#despacho span").append(resultado.nombre);
                });
            });
            var expedientes = {
                op: "st",
                entidad: "Expediente",
                "params[id_Caso]": id
            };
            servicio(expedientes, function(data) {
                $("#main-table tbody").append("<tr><th>Expediente</th><th></th></tr>");
                $.each(data.Resultados, function(i, resultado) {
                    $("#main-table tbody").append("<tr><td>" + resultado.nombre + "</td><td><button type=\"button\" onclick=\"mostrarExpediente(" + resultado.id + ");\">Detalles</button></td></tr>");
                });
            });
        });
    });
}


function mostrarAbogado(id) {
    //Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1015544/proyecto/Vistas/vista-admin-abogado.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main_content").empty().append(data);
        },
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {   //the status returned will be "timeout" 
            alert(status + " " + errorThrown + ": No se pudo conectar con el servidor. Intente de nuevo.");
        }
    });

    var params = {
        op: "sii",
        entidad: "Abogado",
        'params[id]': id
    };

    servicio(params, function(data) {
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
            generarGrafica(resultado.id);
        });
    });

}


function servicio(params, successFunc) {
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1015544/proyecto/Servicios/servicio.php";
    $.ajax({
        url: myurl,
        dataType: 'jsonp',
        crossDomain: true,
        data: params,
        success: successFunc,
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {
            alert(errorThrown + ": No se pudo conectar con el servidor [" + status + "]. Intente de nuevo.");
        }
    });
}

function successFuncCaso(data) {
    var string = '<div id=\"leyenda\"><a href=\"../altas.php?op=Caso\"><img src="../css/images/add_general.png"\n\
    style=\"width: 36px; height: 36px;\"></a></div>\n\
    <table id="main_table" class="display"><thead><tr><th>Nombre</th><th>Descripcion</th><th>Estado</th><th>Opciones</th></tr></thead>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var caso = resultado.nombre;
        var estado = resultado.status;
        var desc = resultado.descripcion;
        string += "<tr><td>" + caso + "</td><td>" + desc + "</td><td>" + (estado ? "Activo" : "Inactivo") + "</td><td><a href=\"#\"\n\
        onclick=\"mostrarCaso(" + id + ");\">Mostrar</a>&nbsp;&nbsp;<a href=\"../cambios.php?nombre=" + caso + "&sel=" + id + "&op=Caso\" \n\
        \">Editar</a>&nbsp<a href=\"../bajas.php?nombre=" + caso + "&sel=" + id + "&op=Caso\" onclick=\"mostrarCaso(" + id + ");\">   Eliminar   </a></td></tr>";
    });
    string += "</table>";
    $("#main_content").empty().append(string);
    cambiaTabla();
}

function successFuncAbogados(data) {
    var string = '<div id=\"leyenda\"><a href=\"../altas.php?op=Abogado\"><img src="../css/images/add_abogado.jpg"\n\
    style=\"width: 36px; height: 36px;\"></a></div>\n\
    <table id="main_table" class="display"><thead><tr><th>Nombre</th><th>Email</th><th>Telefono</th><th>Opciones</th></tr></thead>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var nombre = resultado.nombre + " " + resultado.apellidoP + " " + resultado.apellidoM;
        var telefono = resultado.telefono;
        var email = resultado.email;
        string += "<tr><td>" + nombre + "</td><td>" + email + "</td><td>" + telefono + "</td><td>\n\
        <a href=\"#\"onclick=\"mostrarAbogado(" + id + ");\">Mostrar</a>&nbsp;&nbsp;<a href=\"../cambios.php?nombre=" + resultado.nombre + "&sel=" + id + "&op=Abogado\" \n\
      \">Editar</a>&nbsp;&nbsp;<a href=\"../bajas.php?nombre=" + resultado.nombre + "&sel=" + id + "&op=Abogado\">   Eliminar   </a></td></tr>";
    });
    string += "</table>";
    $("#main_content").empty().append(string);
    cambiaTabla();
}

function successFuncDireccion(data) {

    $.each(data.Resultados, function(i, resultado) {
        var stringdir = "";
        var calle = resultado.calle;
        var ext = resultado.no_exterior;
        var int = resultado.no_interior;
        var colonia = resultado.colonia;
        var ciudad = resultado.ciudad;
        var cp = resultado.cp;
        stringdir += "<td>" + calle + " #" + ext + " - " + int + "  " + "</td><td>  " + colonia + "  " + "</td><td>" + ciudad + "</td><td>" + cp + "</td>\n\
        <td><button type=\"button\" " +
                "onclick=\"window.open('http://maps.google.com/?q=" + calle + "," + ext + "," + colonia + "," + ciudad + "," + cp + "')\">Mapa</button></td>";
        $("#desp_table tbody tr:eq(" + cont + ")").append(stringdir);
        cont++;
    });
    timer = setInterval(function() {
        Tabla("desp_table");
    }, 100);

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

    /*Votos*/
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

        function set_votes(promedio) {

            promActual = promedio;
            var avg = Math.round(promedio);
            $(califica).find('.star_' + avg).prevAll().andSelf().addClass('ratings_vote');
            $(califica).find('.star_' + avg).nextAll().removeClass('ratings_vote');
        }

        function successFuncDespacho2(data) {

            var string = '<div id=\"leyenda\"><a href=\"../altas.php?op=Despacho\"><img src="../css/images/add_general.png"\n\
    style=\"width: 36px; height: 36px;\"></a></div>\n\
    <table id="desp_table" class="display"><thead><tr><th>Opciones</th><th>Nombre</th><th>Calle</th><th>Colonia</th><th>Ciudad</th><th>CP</th><th>Mapa</th></tr></thead>';
            $.each(data.Resultados, function(i, resultado) {
                var id = resultado.id;
                var nombre = resultado.nombre;
                var dirID = resultado.id_Direccion;
                string += "<tr><td><a href=\"../cambios.php?nombre=" + nombre + "&sel=" + id + "&op=Despacho\" \n\
       \">Editar</a>&nbsp;&nbsp;<a href=\"../bajas.php?nombre=" + nombre + "&sel=" + id + "&op=Despacho\">   Eliminar   </a></td><td>" + nombre + " " + "</td></tr>";
                var params = {
                    op: "sii",
                    entidad: "Direccion",
                    "params[id]": dirID
                };
                servicio(params, successFuncDireccion);
            });
            cont = 0;
            string += "</table>";
            $("#main_content").empty().append(string);


        }


        function successFuncDespacho(data) {

            var string = '<div id=\"leyenda\"><a href=\"../altas.php?op=Despacho\"><img src="../css/images/add_general.png"\n\
    style=\"width: 36px; height: 36px;\"></a></div>\n\
    <table id="main_table" class="display"><thead><tr><th>Opciones</th><th>Nombre</th><th>Calle</th><th>Colonia</th><th>Ciudad</th><th>CP</th><th>Mapa</th></tr></thead>';
            $.each(data.Resultados, function(i, resultado) {
                var id = resultado.id;
                var nombre = resultado.nombre;
                var dirID = resultado.id_Direccion;
                string += "<tr><td><a href=\"../cambios.php?nombre=" + nombre + "&sel=" + id + "&op=Despacho\" \n\
       \">Editar</a>&nbsp;&nbsp;<a href=\"../bajas.php?nombre=" + nombre + "&sel=" + id + "&op=Despacho\">   Eliminar   </a></td><td>" + nombre + " " + "</td></tr>";
                var params = {
                    op: "sii",
                    entidad: "Direccion",
                    "params[id]": dirID
                };
                servicio(params, function()
                {

                    $.each(data.Resultados, function(i, resultado) {
                        var calle = resultado.calle;
                        var ext = resultado.no_exterior;
                        var int = resultado.no_interior;
                        var colonia = resultado.colonia;
                        var ciudad = resultado.ciudad;
                        var cp = resultado.cp;
                        string += "<td>" + calle + " #" + ext + " - " + int + "  " + "</td><td>  " + colonia + "  " + "</td><td>" + ciudad + "</td><td>" + cp + "</td>\n\
                         <td><button type=\"button\" " +
                                "onclick=\"window.open('http://maps.google.com/?q=" + calle + "," + ext + "," + colonia + "," + ciudad + "," + cp + "')\">Mapa</button></td>";
                    });
                });
            });
            string += "</table>";
            $("#main_content").empty().append(string);

        }



        function successFuncClientes(data) {

            var string = '<div id=\"leyenda\"><a href=\"../altas.php?op=Despacho\"><img src="../css/images/add_general.png"\n\
    style=\"width: 36px; height: 36px;\"></a></div>\n\
    <table id="main_table" class="display"><thead><tr><th>Opciones</th><th>Nombre</th><th>Telefono</th><th>Email</th></tr></thead>';

            $.each(data.Resultados, function(i, resultado) {
                var id = resultado.id;
                var nombre = resultado.nombre + " " + resultado.apellidoP + " " + resultado.apellidoM;
                var telefono = resultado.telefono;
                var email = resultado.email;
                string += "<tr><td>" + nombre + "</td><td>" + email + "</td><td>" + telefono + "</td><td>\n\
        <a href=\"#\"onclick=\"mostrarCliente(" + id + ");\">Mostrar</a>&nbsp;&nbsp;<a href=\"../cambios.php?nombre=" + resultado.nombre + "&sel=" + id + "&op=Cliente\" \n\
      \">Editar</a>&nbsp;&nbsp;<a href=\"../bajas.php?nombre=" + resultado.nombre + "&sel=" + id + "&op=Cliente\">   Eliminar   </a></td></tr>";
            });
            string += "</table>";
            $("#main_content").empty().append(string);
            cambiaTabla();

        }


        function loadMain(clase) {
            switch (clase) {
                case "Caso":
                    var params = {
                        op: "st",
                        entidad: "Caso",
                        "params[id_Abogado]": 1//Cambiar este 1 por variable
                    };
                    servicio(params, successFuncCaso);
                    break;
                case "Abogado":
                    var params = {
                        op: "st",
                        entidad: "Abogado",
                        "params[id]": 1
                    };
                    servicio(params, successFuncAbogados);
                    break;
                case "AbogadoActualiza":
                    var params = {
                        op: "sii",
                        entidad: "Abogado",
                        'params[id]': id,
                    };
                    servicio(params, successFuncAbogadosActual);
                    break;
                case "Cliente":
                    var params = {
                        op: "st",
                        entidad: "AbogadosClientes",
                        "params[id_Abogado]": 1//Cambiar este 1 por variable
                    };
                    servicio(params, successFuncAbogadosClientes);
                    break;
                case "Despacho":
                    var params = {
                        op: "st",
                        entidad: "Despacho",
                        "params[id]": 1
                    };
                    servicio(params, successFuncDespacho2);
                    break;
                case "Tarea":
                    var params = {
                        op: "st",
                        entidad: "Tarea",
                        "params[id_Abogado]": 1
                    };
                    servicio(params, successFuncTarea);
                    break;
                case "Clientes":
                    var params = {
                        op: "st",
                        entidad: "Cliente",
                        "params[id]": 1//Cambiar este 1 por variable
                    };
                    servicio(params, successFuncClientes);
                    break;
            }
        }

        /*Conversión de la tabla a tabla dinámica*/
        function cambiaTabla() {
            $('#main_table').dataTable({
                "scrollY": "200px",
                "scrollCollapse": true,
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
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

        function Tabla(tabla) {
            $.fn.dataTableExt.sErrMode = 'throw';
            $("#" + tabla).dataTable({
                "scrollY": "200px",
                "scrollCollapse": true,
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
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



        $(document).ready(function() {

            $("#refclientes").click(function() {
                loadMain("Clientes");
            });
            $("#clientesref").click(function() {
                loadMain("Clientes");
            });
            $("#refabogados").click(function() {
                loadMain("Abogado");
            });
            $("#abogadosref").click(function() {
                loadMain("Abogado");
            });
            $("#refcasos").click(function() {
                loadMain("Caso");
            });
            $("#casosref").click(function() {
                loadMain("Caso");
            });
            $("#refdespachos").click(function() {
                loadMain("Despacho");
            });
            $("#despachosref").click(function() {
                loadMain("Despacho");
                cont = 0;
            });
            $("#navAbogados").click(function() {
                loadMain("Abogado");
            });
            $("#navCasos").click(function() {
                loadMain("Caso");
            });
            $("#navDespachos").click(function() {
                loadMain("Despacho");
            });
            $("#navClientes").click(function() {
                loadMain("Clientes");
            });


            $("#home").click(function() {

                location.reload(true);
            });



        });
                