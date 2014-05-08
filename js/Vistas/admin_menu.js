
function mostrarCasos(id) {//mostrarCaso
//Carga la pagina mediante AJAX y despues le añade los datos de cada campo
    var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1015544/proyecto/Vistas/vista-caso.html";
    $.ajax({
        url: myurl,
        success: function(data) {
            $("#maint").empty().append(data); //cambiar por main_content y ajustar
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
        var string = '<table id="main_table" class="tablesorter"><thead><tr><th>Nombre</th><th>Estado</th></tr></thead> <tbody>';
        $.each(data.Resultados, function(i, resultado) {
            var nombre = resultado.nombre;
            var estado = resultado.status;
            var clienteID = resultado.id_Cliente;
            var despachoID = resultado.id_Despacho;
            $("#nombreCaso span").append(nombre);
            $("#estado span").append(estado ? "Activo" : "Cerrado");

            var iParams = {
                op: "sii",
                entidad: "Cliente",
                "params[id]": clienteID
            };
            servicio(iParams, function(data) {
                $.each(data.Resultados, function(i, resultado) {
                    $("#nombreCliente span").append(resultado.nombre + " " + resultado.apellidoP + " " + resultado.apellidoM);
                });
            });

            var iParams2 = {
                op: "sii",
                entidad: "Despacho",
                "params[id]": despachoID
            };
            servicio(iParams2, function(data) {
                $.each(data.Resultados, function(i, resultado) {
                    $("#despacho span").append(resultado.nombre);
                });
            });

            var iParams3 = {
                op: "st",
                entidad: "Expediente",
                "params[id_Caso]": id
            };
            servicio(iParams3, function(data) {
                $("#main-table tbody").append("<tr><th>Expediente</th></tr>");
                $.each(data.Resultados, function(i, resultado) {
                    $("#main-table tbody").append("<tr><td>" + resultado.nombre + "</td></tr>");
                });
            });
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
            alert(errorThrown + ": No se pudo conectar con el servidor ["+status +"]. Intente de nuevo.");
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
                op: "st",
                entidad: "Tarea",
                "params[id_Abogado]": 1
            };
            servicio(params, successFuncTarea);
            break;
    }
}

/*Conversión de la tabla a tabla dinámica*/
function cambiaTabla(){
	
	$('#main_table').dataTable({
		
        "scrollY":        "200px",
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
	   mandaDireccion(myUser.id,1);
   });
   $("#pagosref").click(function() {
	   mandaDireccion(myUser.id,1);
   });
   $("#refabogados").click(function() {
	   mandaDireccion(myUser.id,2);
   });
   $("#abogadosref").click(function() {
	   mandaDireccion(myUser.id,2);
   });
   $("#refcasos").click(function() {
	   mandaDireccion(myUser.id,3);
   });
   $("#casosref").click(function() {
	   mandaDireccion(myUser.id,3);
   });

    $("#navAbogados").click(function() {
	   
   });
    $("#navCasos").click(function() {
	    loadMain("Caso");
   });
 
   $("#navDespachos").click(function() {
	   
   });
});