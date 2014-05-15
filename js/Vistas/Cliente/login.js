

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
            	
                var usuario = {
                    "id": resultado.id,
                    "nombre": resultado.nombre,
                    "apellidoP": resultado.apellidoP,
                    "apellidoM": resultado.apellidoM,
                    "telefono": resultado.telefono,
                    "email": resultado.email
                };

                var url = "app/content/menu.html?";

                $.each(usuario, function(key, value) {
                    url += key + "=" + value + "&";
                });      
                
                url = url.substring(0, url.length - 1); //Retiro el último  &               
                //url = url.split(0, -1);
                window.location.href = url;
                //redirectTo(url);
            });
        },
        timeout: 3000, //3 second timeout, 
        error: function(jqXHR, status, errorThrown) {   //the status returned will be "timeout" 
            alert(status + ": No se pudo conectar con el servidor. Intente de nuevo.");
        }
    });
}




function Login(){
	var usuario = document.forms["loginForm"]["username"].value;
	var passwd = document.forms["loginForm"]["password"].value;
	
	$.getJSON("http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php?op=lgc&entidad=Cliente&params[email]="+usuario+"&params[contrasena]="+passwd+"&callback=?",
			function(data){ 
		   
			$.each(data.Resultados, function(i, resultado) {
				
            var user = resultado.email;
            
            if (user === usuario) {
            	
                getUserData(user);
            }
            else {
                alert("Usuario y/o contraseña incorrectos.");
            }
	                          
	    });
        });     
	
}