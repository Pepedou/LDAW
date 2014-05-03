<script>



    function getXMLHTTP() { //funcion que regresa el objeto xml http
        var xmlhttp = false;
        try {
            xmlhttp = new XMLHttpRequest();
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e1) {
                    xmlhttp = false;
                }
            }
        }

        return xmlhttp;
    }


    function llenaEstados() {

        var strURL = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/select_direccion.php?op=1";
        var req = getXMLHTTP();
        if (req) {
        
            req.onreadystatechange = function() {
                if (req.readyState === 4) {
                    if (req.status === 200) {
                        document.getElementById('estados').innerHTML = req.responseText;
                        
                    } else {
                        alert("Hay un problema al utilizar  XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);

            req.send(null);
        }
    }


    function llenaMunicipios(estadoId) {

        var strURL = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/select_direccion.php?op=2&edo=" + estadoId;

        var req = getXMLHTTP();
        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('municipios').innerHTML = req.responseText;
                    } else {
                        alert("Hay un problema al utilizar  XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }

    }

    function llenaDespachos() {

        var strURL = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/select_direccion.php?op=3";

        var req = getXMLHTTP();
        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('despachos').innerHTML = req.responseText;
                    } else {
                        alert("Hay un problema al utilizar  XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }



    }

    function llenaRoles() {


        var strURL = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/select_direccion.php?op=4";

        var req = getXMLHTTP();
        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('roles').innerHTML = req.responseText;
                    } else {
                        alert("Hay un problema al utilizar  XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }



    }

    function llenaTipos() {


        var strURL = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/select_direccion.php?op=6";

        var req = getXMLHTTP();
        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('tipos').innerHTML = req.responseText;
                    } else {
                        alert("Hay un problema al utilizar  XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }



    }



    function llenaEntidad(name, tabla, campo) {

        var strURL = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/select_direccion.php?op=5&tabla=" + tabla + "&campo=" + campo + "&name=" + name;

        var req = getXMLHTTP();
        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById(name).innerHTML = req.responseText;
                        
                    } else {
                        alert("Hay un problema al utilizar  XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }


    }
    
     

</script>