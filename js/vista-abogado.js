var usuario = {
    id: -1,
    nombre: "",
    apellidoP: "",
    apellidoM: "",
    id_Despacho: -1
};

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
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Vistas/vista-expediente.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main_content_abogs").empty().append(data);
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
                op: "stw",
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

function enviarComentarioCaso(idCaso) {
    var comentario = $("#comentario input").val();
    if (comentario === "") {
        alert("El comentario está vacío.");
        return;
    }
    ;
    var params = {
        "op": "in",
        "entidad": "ComentarioCaso",
        "params[id_Abogado]": usuario.id,
        "params[id_Caso]": idCaso,
        "params[comentario]": comentario
    };
    servicio(params, function(data) {
        if (data.Resultados['comentario'] === comentario)
            alert("Comentario registrado exitosamente.");
        else
            alert("No se pudo registrar el comentario.");
    });
    mostrarCaso(idCaso);
}

function enviarComentarioTarea(idTarea) {
    var comentario = $("#comentario" + idTarea).val();
    if (comentario === "") {
        alert("El comentario está vacío.");
        return;
    }
    var params = {
        "op": "in",
        "entidad": "ComentarioTarea",
        "params[id_Abogado]": usuario.id,
        "params[id_Tarea]": idTarea,
        "params[comentario]": comentario
    };
    servicio(params, function(data) {
        if (data.Resultados['comentario'] === comentario)
            alert("Comentario registrado exitosamente.");
        else
            alert("No se pudo registrar el comentario.");
    });
    loadMain("Tarea");
}

function mostrarCaso(id) {
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Vistas/vista-caso.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#main_content_abogs").empty().append(data);
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
            var descripcion = resultado.descripcion;
            var clienteID = resultado.id_Cliente;
            var despachoID = resultado.id_Despacho;
            $("#nombreCaso span").append(nombre);
            $("#estado span").append(estado === "1" ? "Activo" : "Cerrado");
            $("#descripcion span").append(descripcion);
            $("button").attr("onclick", "enviarComentarioCaso(" + id + ");");
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
                op: "stw",
                entidad: "Expediente",
                "params[id_Caso]": id
            };
            servicio(expedientes, function(data) {
                $("#main-table tbody").append("<tr><th>Expediente</th><th></th></tr>");
                $.each(data.Resultados, function(i, resultado) {
                    $("#main-table tbody").append("<tr><td>" + resultado.nombre + "</td><td><button type=\"button\" onclick=\"mostrarExpediente(" + resultado.id + ");\">Detalles</button></td></tr>");
                });
            });
            var comentarios = {
                op: "stw",
                entidad: "ComentarioCaso",
                "params[id_Caso]": id
            };
            servicio(comentarios, function(data) {
                $("#tablaComentarios tbody").append("<tr><th>Comentario</th><th>Autor</th><th>Fecha</th></tr>");
                $.each(data.Resultados, function(i, resultado) {
                    var idComentario = resultado.id;
                    $("#tablaComentarios tbody").append("<tr><td>" + resultado.comentario + "</td><td id=\"abogado" + resultado.id + "\"></td><td>" + resultado.creado + "</td></tr>");
                    var abogado = {
                        op: "sii",
                        entidad: "Abogado",
                        "params[id]": resultado.id_Abogado
                    };
                    servicio(abogado, function(data) {
                        $.each(data.Resultados, function(i, resultado) {
                            var nombre = resultado.nombre;
                            var apellidoP = resultado.apellidoP;
                            $("#abogado" + idComentario).append(nombre + " " + apellidoP);
                        });
                    });
                });
            });
        });
    });
}

function successFuncCaso(data) {
    var string = '<table id="main-table" class="display"><thead><tr><th>Nombre</th><th>Descripci&oacute;n<th>Estado</th><th></th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var caso = resultado.nombre;
        var descripcion = String(resultado.descripcion);
        var estado = resultado.status;
        if (descripcion.length == 0)
            descripcion = "-";
        string += "<tr><td>" + caso + "</td><td>" + descripcion.substring(0, 40) + ((descripcion.length > 40) ? "..." : "") + "</td><td>" + (estado === "1" ? "Activo" : "Inactivo") + "</td><td><button type=\"button\" onclick=\"mostrarCaso(" + id + ");\">Mostrar</button></td></tr>";
    });
    string += "</tbody></table>";
    $("#main_content_abogs").empty().append(string);
    cambiaTabla();
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
    var string = '<table id="main-table" class="display"><thead><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var nombre = resultado.nombre;
        var apellidoP = resultado.apellidoP;
        var apellidoM = resultado.apellidoM;
        var telefono = resultado.telefono;
        var email = resultado.email;
        string += "<tr><td>" + nombre + " " + apellidoP + " " + apellidoM + "</td><td>" + telefono + "</td><td>" + email + "</td></tr>";
    });
    string += "</tbody></table>";
    $("#main_content_abogs").empty().append(string);
    cambiaTabla();
}

function successFuncDireccion(data) {
    var head = '<th>Calle</th><th>Colonia</th><th>Ciudad</th><th>CP</th><th></th>';
    var string = "";
    $("#main-table tr:first").append(head);
    $.each(data.Resultados, function(i, resultado) {
        var calle = resultado.calle;
        var ext = resultado.no_exterior;
        var int = resultado.no_interior;
        var colonia = resultado.colonia;
        var ciudad = resultado.ciudad;
        var cp = resultado.cp;
        string += "<td>" + calle + " #" + ext + "-" + int + "</td><td>" + colonia + "</td><td>" + ciudad + "</td><td>" + cp + "</td><td><button type=\"button\" " +
                "onclick=\"window.open('http://maps.google.com/?q=" + calle + "," + ext + "," + colonia + "," + ciudad + "," + cp + "')\">Mapa</button></td>";
    });
    $("#main-table tbody tr:first").append(string);
    cambiaTabla();
}

function successFuncDespacho(data) {
    var string = '<table id="main-table" class="tablesorter"><thead><tr><th>Nombre</th></tr></thead> <tbody>';
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
    $("#main_content_abogs").empty().append(string);
   
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
                $(this).empty().append((estado === "1") ? "Finalizar" : "Reactivar");
                $(this).attr("onclick", "toggleTarea(" + id + "," + estado + ");");
            });
        });
    });
    loadMain("Tarea");
}

function mostrarComentariosTarea(idTarea) {
    var comentarios = {
        "op": "st",
        "entidad": "ComentarioTarea",
        "params[id_Tarea]": idTarea
    };
    $("#tablaComentarios").hide(0).fadeIn(250);
    servicio(comentarios, function(data) {
        $("#tablaComentarios tbody").empty().append("<tr><th>Comentario</th><th>Autor</th><th>Fecha</th></tr>");
        $.each(data.Resultados, function(i, resultado) {
            var idComentario = resultado.id;
            $("#tablaComentarios tbody").append("<tr><td>" + resultado.comentario + "</td><td id=\"abogado" + resultado.id + "\"></td><td>" + resultado.creado + "</td></tr>");
            var abogado = {
                op: "sii",
                entidad: "Abogado",
                "params[id]": resultado.id_Abogado
            };
            servicio(abogado, function(data) {
                $.each(data.Resultados, function(i, resultado) {
                    var nombre = resultado.nombre;
                    var apellidoP = resultado.apellidoP;
                    $("#abogado" + idComentario).append(nombre + " " + apellidoP);
                });
            });
        });
    });
}

function successFuncTarea(data) {
    var string = "<table id=\"tablaComentarios\"><tbody></tbody></table>";
    string += '<h4>Tareas Urgentes</h4><table id="table_urgent" class="tablesorter"><thead><tr><th>Nombre</th><th>Descripcion</th><th>Inicio</th><th>Fin</th><th>Estado</th><th></th><th>Comentario</th><th></th></tr></thead> <tbody>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var nombre = resultado.nombre;
        var desc = String(resultado.descripcion);
        var inicio = resultado.inicio;
        var fin = resultado.fin;
        var estado = resultado.status;
        string += "<tr class=\"tareas tarea" + id + "\"><td>" + nombre + "</td><td class=\"descripcionTarea\" onclick=\"alert('" + desc + "');\">" + desc.substring(0, 60) + ((desc.length > 60) ? "..." : "") + "</td><td>"
                + inicio + "</td><td>" + fin + "</td><td>" + ((estado === "1") ? "Pendiente" : "Finalizada") + "</td><td><button type=\"button\" onclick=\"toggleTarea(" + id + "," + estado + ");\">" + ((estado === "1") ? "Finalizar" : "Reactivar") + "</button></td><td><input id=\"comentario" + id + "\" type=\"text\"/></td><td><button type=\"button\" onclick=\"enviarComentarioTarea(" + id + ");\">Enviar</button></td></tr>";
    });
    string += "</tbody></table>";
    $("#main_content_abogs").empty().append(string); //Agrego las tareas


    //Ahora agregamos todas las tareas
    var params = {
        op: "stw",
        entidad: "Tarea",
        "params[id_Abogado]": usuario.id
    };
    servicio(params, function(data) {
        var string2 = '<h4>Todas mis tareas</h4><table id="table_urgent" class="tablesorter"><thead><tr><th>Nombre</th><th>Descripcion</th><th>Inicio</th><th>Fin</th><th>Estado</th><th></th><th>Comentario</th><th></th></tr></thead> <tbody>';
        $.each(data.Resultados, function(i, resultado) {
            var id = resultado.id;
            var nombre = resultado.nombre;
            var desc = String(resultado.descripcion);
            var inicio = resultado.inicio;
            var fin = resultado.fin;
            var estado = resultado.status;
            string2 += "<tr class=\"tareas tarea" + id + "\"><td>" + nombre + "</td><td class=\"descripcionTarea\" onclick=\"alert('" + desc + "');\">" + desc.substring(0, 60) + ((desc.length > 60) ? "..." : "") + "</td><td>"
                    + inicio + "</td><td>" + fin + "</td><td>" + ((estado === "1") ? "Pendiente" : "Finalizada") + "</td><td><button type=\"button\" onclick=\"toggleTarea(" + id + "," + estado + ");\">" + ((estado === "1") ? "Finalizar" : "Reactivar") + "</button></td><td><input id=\"comentario" + id + "\" type=\"text\"/></td><td><button type=\"button\" onclick=\"enviarComentarioTarea(" + id + ");\">Enviar</button></td></tr>";
        });
        string2 += "</tbody></table>";
        $("#main").append(string2); //Agrego las tareas
        $(".descripcionTarea").hover(function() {
            $(this).css('opacity', '0.5');
        }, function() {
            $(this).css('opacity', '1');
        });
        $(".tareas").each(function(i, tarea) {
            var id = String($(this).attr('class'));
            id = id.replace(/^\D+/g, '');//Obtengo el número únicamente de tarea<num>
            $(this).click(function() {
                mostrarComentariosTarea(id);
            });
        });
    });
}

function successFuncHono(data) {
    var string = '<h4>Mis honorarios</h4><table id="main-table" class="tablesorter"><thead><tr><th>Tarea</th><th>Duración</th></tr></thead><tbody>';
    var honorarios = "";
    $.each(data.Resultados, function(i, resultado) {
        honorarios = resultado.honorarios;
        var tareas = resultado.Tareas;
        $.each(tareas, function(i, tarea) {
            var nombre = tarea.nombre;
            var dias = tarea.dias;
            string += "<tr><td>" + nombre + "</td><td>" + dias + " días</td></tr>";
        });
    });
    string += "<tr><td>Honorarios:</td><td>$" + honorarios + " M.N.</td></tr>";
    string += "</tbody></table>";
    $("#main").empty().append(string); //Agrego los honorarios
}

function successFuncHono(data) {
    var string = '<h4>Mis honorarios</h4><table id="main-table" class="display"><thead><tr><th>Tarea</th><th>Duración</th></tr></thead><tbody>';
    var honorarios = "";
    $.each(data.Resultados, function(i, resultado) {
        honorarios = resultado.honorarios;
        var tareas = resultado.Tareas;
        $.each(tareas, function(i, tarea) {
            var nombre = tarea.nombre;
            var dias = tarea.dias;
            string += "<tr><td>" + nombre + "</td><td>" + dias + " días</td></tr>";
        });
    });
    string += "<tr><td>Honorarios:</td><td>$" + honorarios + " M.N.</td></tr>";
    string += "</tbody></table>";
    $("#main_content_abogs").empty().append(string); //Agrego los honorarios
    cambiaTabla();
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
            var params1 = {
                op: "stw",
                entidad: "Caso",
                "params[id_Despacho]": usuario.id_Despacho
            };
            servicio(params1, successFuncCaso);
            break;
        case "Cliente":
            var params2 = {
                op: "st",
                entidad: "AbogadosClientes",
                "params[id_Abogado]": usuario.id
            };
            servicio(params2, successFuncAbogadosClientes);
            break;
        case "Despacho":
            var params3 = {
                op: "sii",
                entidad: "Despacho",
                "params[id]": usuario.id_Despacho
            };
            servicio(params3, successFuncDespacho);
            break;
        case "Tarea":
            var params4 = {
                op: "stu",
                entidad: "Tarea",
                "params[id_Abogado]": usuario.id
            };
            servicio(params4, successFuncTarea);
            break;
        case "Honorarios":
            var params5 = {
                op: "hon",
                entidad: "Abogado",
                "params[id]": usuario.id
            }
            servicio(params5, successFuncHono);
            break;
    }
}

function cambiaTabla() {
    $('#main-table').dataTable({
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
    usuario.id = $("userTag").attr("uid");
    usuario.nombre = $("userTag").attr("nombre");
    usuario.apellidoP = $("userTag").attr("apellidoP");
    usuario.apellidoM = $("userTag").attr("apellidoM");
    usuario.id_Despacho = $("userTag").attr("id_Despacho");

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
    $("#menu_entry5").click(function() {
        loadMain("Honorarios");
    });
    $("#menu_entry6").click(function() {
        alert("Nada que reportar.");
    });
    
    loadMain("Caso");
});
