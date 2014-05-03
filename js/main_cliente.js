$(document).ready(function() {
   
    show(1); /*Al empezar, muestra casos*/

    $("#menu_entry1").click(function() {
        show(1);
    });
    $("#menu_entry2").click(function() {
        show(2);
    });
    $("#menu_entry3").click(function() {
        show(3);
    });

});

function show(op) {

    switch (op) {

        case 1: /*mostrar casos*/
            document.getElementById("abogados").style.display = "none";
            document.getElementById("casos").style.display = "block";
            break;
        case 2: /*mostrar abogados*/
          
            document.getElementById("abogados").style.display = "block";
            document.getElementById("casos").style.display = "none";
            break;
        case 3:
            break;
    }

}