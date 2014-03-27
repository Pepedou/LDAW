<script>
    function nombre_desp(name) {
        
        var sel = name.options[name.selectedIndex].value;       
        if (sel !== 0) {
            var x = name.options[name.selectedIndex].text;
            var input = document.getElementById("nombre");
            input.value= x;
            newUrl = "bajas.php?nombre=" + x + "&sel="+sel;            
            document.location.href = newUrl;
        }
    
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

</script>