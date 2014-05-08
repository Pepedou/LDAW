function borrarDocumento(id) {
    var params = {
        op: "del",
        entidad: "Documento",
        "params[id]": id
    };
    servicio(params, function(data) {
    });
}

function mostrarExpediente(id) {
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1015544/proyecto/Vistas/vista-expediente.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main").empty().append(data);
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
            var nombre = resultado.nombre;
            $("#nombreExpediente span").append(nombre);

            var documentos = {
                op: "st",
                entidad: "Documento",
                "params[id_Expediente]": id
            };
            servicio(documentos, function(data) {
                $("#main-table tbody").append("<tr><th>Documento</th><th>Tamaño</th><th></th><th></th></tr>");
                $.each(data.Resultados, function(i, resultado) {
                    $("#main-table tbody").append("<tr><td>" + resultado.nombre + "</td><td>" + Math.floor(parseInt(resultado.tamano) / 1024) +
                            " KB</td><td><button type=\"button\" onclick=\"window.open('" + resultado.documento +
                            "')\">Descargar</button></td><td><button type=\"button\" onclick=\"borrarDocumento(" + resultado.id + ");mostrarExpediente(" + id + ");\">Eliminar</button></td></tr>");
                });
            });
        });
    });
}

function mostrarCaso(id) {
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1015544/proyecto/Vistas/vista-caso.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main").empty().append(data);
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

function successFuncCaso(data) {
    var string = '<table id="main_table" class="tablesorter"><thead><tr><th>Nombre</th><th>Estado</th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var caso = resultado.nombre;
        var estado = resultado.status;
        string += "<tr><td>" + caso + "</td><td>" + (estado === "1" ? "Activo" : "Inactivo") + "</td><td><button type=\"button\" onclick=\"mostrarCaso(" + id + ");\">Mostrar</button></td></tr>";
    });
    string += "</tbody></table>";
    $("#main").empty().append(string);
}

function successFuncAbogadosClientes(data) {
    $.each(data.Resultados, function(i, resultado) {
        var idCliente = resultado.id_Cliente;
        var iParams = {
            op: "sii", //Select individual con ID
            entidad: "Cliente",
            "params[id]": idCliente
        };
        servicio(iParams, successFuncCliente);
    });
}

function successFuncCliente(data) {
    var string = '<table id="main_table" class="tablesorter"><thead><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var nombre = resultado.nombre;
        var apellidoP = resultado.apellidoP;
        var apellidoM = resultado.apellidoM;
        var telefono = resultado.telefono;
        var email = resultado.email;
        string += "<tr><td>" + nombre + " " + apellidoP + " " + apellidoM + "</td><td>" + telefono + "</td><td>" + email + "</td></tr>";
    });
    string += "</tbody></table>";
    $("#main").empty().append(string);
}

function successFuncDireccion(data) {
    var head = '<th>Calle</th><th>Colonia</th><th>Ciudad</th><th>CP</th>';
    var string = "";
    $("#main_table tr:first").append(head);
    $.each(data.Resultados, function(i, resultado) {
        var calle = resultado.calle;
        var ext = resultado.no_exterior;
        var int = resultado.no_interior;
        var colonia = resultado.colonia;
        var ciudad = resultado.ciudad;
        var cp = resultado.cp;
        string += "<td>" + calle + " #" + ext + "-" + int + "</td><td>" + colonia + "</td><td>" + ciudad + "</td><td>" + cp + "</td><td><button type=\"button\" "+
                "onclick=\"window.open('http://maps.google.com/?q="+calle + "," + ext + "," + colonia + "," + ciudad + "," + cp+"')\">Mapa</button></td>";
    });
    $("#main_table tbody tr:first").append(string);
}

function successFuncDespacho(data) {
    var string = '<table id="main_table" class="tablesorter"><thead><tr><th>Nombre</th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var nombre = resultado.nombre;
        var dirID = resultado.id_Direccion;
        string += "<tr><td>" + nombre + "</td></tr>";
        var params = {
            op: "sii",
            entidad: "Direccion",
            "params[id]": dirID
        };
        servicio(params, successFuncDireccion);
    });
    string += "</tbody></table>";
    $("#main").empty().append(string);
}

function toggleTarea(id, estado) {
    var params = {
        op: "up",
        entidad: "Tarea",
        "params[id]": id,
        "params[status]": (estado === 1) ? 0 : 1
    };
    servicio(params, function(data) {//Este servicio actualiza
        $.each(data.Resultados, function(i, resultado) {
            var id = resultado.id;
            var estado = resultado.status;
            $(".tarea" + id + " button").each(function(index, tupla) {//Para las tuplas en la tabla urgentes y en la de todas
                $(this).empty().append((estado === "1") ? "Completa" : "Reactivar");
                $(this).attr("onclick", "toggleTarea(" + id + "," + estado + ");");
            });
        });
    });
    loadMain("Tarea");
}

function successFuncTarea(data) {
    var string = '<h4>Tareas Urgentes</h4><table id="table_urgent" class="tablesorter"><thead><tr><th>Nombre</th><th>Descripcion</th><th>Inicio</th><th>Fin</th><th>Estado</th><th></th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var nombre = resultado.nombre;
        var desc = resultado.descripcion;
        var inicio = resultado.inicio;
        var fin = resultado.fin;
        var estado = resultado.status;
        string += "<tr class=\"tarea" + id + "\"><td>" + nombre + "</td><td>" + desc + "</td><td>"
                + inicio + "</td><td>" + fin + "</td><td>" + ((estado === "1") ? "Activa" : "Finalizada") + "</td><td><button type=\"button\" onclick=\"toggleTarea(" + id + "," + estado + ");\">" + ((estado === "1") ? "Completa" : "Reactivar") + "</button></td></tr>";
    });
    string += "</tbody></table>";
    $("#main").empty().append(string);//Agrego las tareas

    //Ahora agregamos las tareas urgentes
    var params = {
        op: "st",
        entidad: "Tarea",
        "params[id_Abogado]": 1//Cambiar por el id correcto
    };

    servicio(params, function(data) {
        var string2 = '<h4>Todas mis tareas</h4><table id="main_table" class="tablesorter"><thead><tr><th>Nombre</th><th>Descripcion</th><th>Inicio</th><th>Fin</th><th>Estado</th><th></th></tr></thead> <tbody>';
        $.each(data.Resultados, function(i, resultado) {
            var id = resultado.id;
            var nombre = resultado.nombre;
            var desc = resultado.descripcion;
            var inicio = resultado.inicio;
            var fin = resultado.fin;
            var estado = resultado.status;

            string2 += "<tr class=\"tarea" + id + "\"><td>" + nombre + "</td><td>" + desc + "</td><td>"
                    + inicio + "</td><td>" + fin + "</td><td>" + (estado === "1" ? "Activa" : "Finalizada") + "</td><td><button type=\"button\" onclick=\"toggleTarea(" + id + "," + estado + ");\">" + (estado === "1" ? "Completa" : "Reactivar") + "</button></td></tr>";
        });
        string2 += "</tbody></table>";
        $("#main").append(string2);//Agrego las tareas
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
                op: "sii",
                entidad: "Despacho",
                "params[id]": 1
            };
            servicio(params, successFuncDespacho);
            break;
        case "Tarea":
            var params = {
                op: "stu",
                entidad: "Tarea",
                "params[id_Abogado]": 1
            };
            servicio(params, successFuncTarea);
            break;
    }
}

function initMenuEntries(entryNumber) {
    $("#menu_entry" + entryNumber).hover(function() {
        $(this).css('opacity', '0.5');
    }, function() {
        $(this).css('opacity', '1');
    });
    $("#menu_entry" + entryNumber).hide();
    $("#menu_entry" + entryNumber).fadeIn((entryNumber + 1) * 250);
}

$(document).ready(function() {
    $(".menuEntry").each(function(index) {
        initMenuEntries(index);
    });
    $("#menu_entry1").click(function() {
        loadMain("Caso");
    });
    $("#menu_entry2").click(function() {
        loadMain("Cliente");
    });
    $("#menu_entry3").click(function() {
        loadMain("Despacho");
    });
    $("#menu_entry4").click(function() {
        loadMain("Tarea");
    });
});