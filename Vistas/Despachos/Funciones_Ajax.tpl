<script>

  function getXMLHTTP() { //funcion que regresa el objeto xml http
    var xmlhttp = false;
            try{
            xmlhttp = new XMLHttpRequest();
            }
    catch (e)        {
    try{
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e){
    try{
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e1){
    xmlhttp = false;
    }
    }
    }

    return xmlhttp;
  }


  function llenaEstados() {

    var strURL = "../../Servicios/select_direccion.php?op=1";
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
</script>