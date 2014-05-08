
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
    <table id="main_table" class="display"><thead><tr><th>Nombre</th><th>Estado</th><th>Opciones</th></tr></thead>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var caso = resultado.nombre;
        var estado = resultado.status;
        string += "<tr><td>" + caso + "</td><td>" + (estado ? "Activo" : "Inactivo") + "</td><td><a href=\"#\"\n\
        onclick=\"mostrarCaso(" + id + ");\">Mostrar</a><a href=\"../cambios.php?nombre=" + caso + "&sel=" + id + "&op=Caso\" \n\
       onclick=\"mostrarCaso(" + id + ");\">Editar</a><a href=\"../bajas.php?nombre=" + caso + "&sel=" + id + "&op=Caso\" onclick=\"mostrarCaso(" + id + ");\">   Eliminar   </a></td></tr>";
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
        var nombre = resultado.nombre+" "+resultado.apellidoP+" "+resultado.apellidoM;
        var telefono = resultado.telefono;
        var email = resultado.email;
        string += "<tr><td>" + nombre + "</td><td>" + email + "</td><td>" + telefono + "</td><td><a href=\"#\"\n\
        onclick=\"mostrarAbogado(" + id + ");\">Mostrar</a><a href=\"../cambios.php?nombre=" + resultado.nombre + "&sel=" + id + "&op=Abogado\" \n\
       onclick=\"mostrarAbogado(" + id + ");\">Editar</a><a href=\"../bajas.php?nombre=" + resultado.nombre + "&sel=" + id + "&op=Abogado\" onclick=\"mostrarAbogado(" + id + ");\">   Eliminar   </a></td></tr>";
    });
    string += "</table>";
    $("#main_content").empty().append(string);
    cambiaTabla();
}

function successFuncDireccion(data) {
    var head = '<th>Calle</th><th>Colonia</th><th>Ciudad</th><th>CP</th><th>Mapa</th>';
    var string = "";
    $("#main_table tr:first").append(head);
    $.each(data.Resultados, function(i, resultado) {
        var calle = resultado.calle;
        var ext = resultado.no_exterior;
        var int = resultado.no_interior;
        var colonia = resultado.colonia;
        var ciudad = resultado.ciudad;
        var cp = resultado.cp;
        string += "<td>" + calle + " #" + ext + " - " + int + "  "+"</td><td>  "+ colonia + "  "+"</td><td>" + ciudad + "</td><td>" + cp + "</td>\n\
        <td><button type=\"button\" "+
                "onclick=\"window.open('http://maps.google.com/?q="+calle + "," + ext + "," + colonia + "," + ciudad + "," + cp+"')\">Mapa</button></td>";
    });
    $("#main_table tbody tr:first").append(string);
}

function successFuncDespacho(data) {

    var string = '<table id="main_table" class="display"><thead><tr><th>Opciones</th><th>Nombre</th></tr></thead>';
    $.each(data.Resultados, function(i, resultado) {
        var id = resultado.id;
        var nombre = resultado.nombre;
        var dirID = resultado.id_Direccion;
        string += "<tr><td><a href=\"#\"\n\
        onclick=\"mostrarAbogado(" + id + ");\">Mostrar</a><a href=\"../cambios.php?nombre=" + nombre + "&sel=" + id + "&op=Despacho\" \n\
       onclick=\"mostrarAbogado(" + id + ");\">Editar</a><a href=\"../bajas.php?nombre=" + nombre + "&sel=" + id + "&op=Despacho\" onclick=\"mostrarAbogado(" + id + ");\">   Eliminar   </a></td><td>" + nombre + " "+"</td></tr>";
        var params = {
            op: "sii",
            entidad: "Direccion",
            "params[id]": dirID
        };
        servicio(params, successFuncDireccion);
    });
    string += "</table>";
    $("#main_content").empty().append(string);
   // cambiaTabla();
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
            servicio(params, successFuncDespacho);
            break;
        case "Tarea":
            var params = {
                op: "st",
                entidad: "Tarea",
                "params[id_Abogado]": 1
            };
            servicio(params, successFuncTarea);
            break;
    }
}

/*Conversión de la tabla a tabla dinámica*/
function cambiaTabla() {

    $('#main_table').dataTable({
        "scrollY": "200px",
        "scrollCollapse": true,
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

    $("#refpagos").click(function() {
        mandaDireccion(myUser.id, 1);
    });
    $("#pagosref").click(function() {
        mandaDireccion(myUser.id, 1);
    });
    $("#refabogados").click(function() {
       loadMain("Abogado");
    });
    $("#abogadosref").click(function() {
        loadMain("Abogado");
    });
    $("#refcasos").click(function() {
        mandaDireccion(myUser.id, 3);
    });
    $("#casosref").click(function() {
        mandaDireccion(myUser.id, 3);
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

    $("#home").click(function() {

        location.reload(true);
    });
    
});