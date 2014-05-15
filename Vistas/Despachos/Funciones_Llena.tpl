<script>

    /*Función para recargar la página con la selección deseada*/
    function nombre_desp(name) {

        var sel = name.options[name.selectedIndex].value;
        if (sel !== 0) {
            var x = name.options[name.selectedIndex].text;
            var input = document.getElementById("nombre");
            input.value = x;
            var op = document.getElementById("op");
            var o = op.value;

            newUrl = "bajas.php?nombre=" + x + "&sel=" + sel + "&op=" + o;
            document.location.href = newUrl;
        }

    }
    /*Función para eliminar registro al seleccionar el botón*/
    function eliminar() {

        var x = document.getElementById("nombre");
        var a = x.value;

        var op = document.getElementById("op");
        var o = op.value;

        newUrl = "bajas.php?nombre=" + a + "&elim=1" + "&op=" + o;
        document.location.href = newUrl;
        alert("");

    }

    function selected_direccion(sel_edo, sel_mun) {
        /*Select del estado*/

        var a = document.getElementById("estados");

        setTimeout(function() {

            var e = a.options;
            var opt = e[sel_edo];
            opt.selected = "true";
            selected_mun(sel_mun); //selecciona el apropiado en el municipio
        }, 300);

    }

    function selected_mun(sel_mun) {

        /* Select del municipio*/

        var m = document.getElementById("municipios");
        var moptions = m.options;
        var opt2 = moptions[sel_mun];
        opt2.selected = "true";

    }

    function sel(sel, id) {

        var a = document.getElementById(id);
        
        setTimeout(function() {

            var e = a.options;
            var opt = e[sel];
            opt.selected = "true";           
        }, 300);

    }

    /*Función para establecer el select del nombre seleccionado en actualización y bajas*/

    function select_entidad(sel, nombre) {

        var ent = document.getElementById(nombre);

        setTimeout(function() {
            var entoptions = ent.options;
            var opt3 = entoptions[sel];
            setTimeout("", 1000);
            opt3.selected = "true";
        }, 300);

    }

    function show(val) {

        if (val === 0) {
            document.getElementById("campos").style.display = "none";
        }
        else {

            document.getElementById("campos").style.display = "block";
        }
    }

    function actualiza(name) {
        var sel = name.options[name.selectedIndex].value;
        if (sel !== 0) {
            var x = name.options[name.selectedIndex].text;
            var input = document.getElementById("nombre");
            input.value = x;

            var op = document.getElementById("op");
            var o = op.value;

            newUrl = "cambios.php?nombre=" + x + "&sel=" + sel + "&op=" + o;
            document.location.href = newUrl;
        }

    }
    
    
</script>