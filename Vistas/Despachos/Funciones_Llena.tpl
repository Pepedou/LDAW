<script>
    function nombre_desp(name) {

        var sel = name.options[name.selectedIndex].value;
        if (sel !== 0) {
            var x = name.options[name.selectedIndex].text;
            var input = document.getElementById("nombre");
            input.value = x;
            var op = document.getElementById("op");  
            var o = op.value; 
            
            newUrl = "bajas.php?nombre=" + x + "&sel=" + sel +"&op=" + o;
            document.location.href = newUrl;
        }

    }
    function eliminar(){    
       
            var x = document.getElementById("nombre");  
            var a = x.value;   
            
            var op = document.getElementById("op");  
            var o = op.value; 
            
            newUrl = "bajas.php?nombre=" + a + "&elim=1" +"&op=" +o;            
            document.location.href = newUrl;
            alert("");
            
        }
    
    

    function show(val) {

        if (val === 0) {
            document.getElementById("campos").style.display = "none";
        }
        else {

            //$("campos").populate(<?php echo $json; ?>); 

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
            
            newUrl = "cambios.php?nombre=" + x + "&sel=" + sel +"&op=" +o; 
            document.location.href = newUrl;
        }

    }
</script>