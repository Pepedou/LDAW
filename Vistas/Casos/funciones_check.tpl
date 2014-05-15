<script>
    function check() {
        var selected = [];
        var id_caso = parseInt(document.getElementById("id_caso").value);

        $(".chk:checked").each(function(index, resultado) {
            selected.push($(this).val());

        });
        /*Por cada uno hago un insert en Abogados_Casos*/
        $.each(selected, function(i, value) {
            llenaCasosAbogados(value, id_caso);
        });

        /*newUrl = "altas.php?op=Caso";
         document.location.href = newUrl;*/
    }

    /*Servicio para llenar Muchos a muchos*/
    function llenaCasosAbogados(abogado, caso) {

        var myurl = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Servicios/servicio.php?op=in&params[id_Abogado]=" + abogado + "&params[id_Caso]=" + caso + "&entidad=AbogadosCasos";


        $.getJSON(myurl,
                function(data) {

                });

    }


    function cambiaTabla() {

        $('#abogs').dataTable({
            "scrollY": "100px",
            "scrollCollapse": true,
            //funcion para añadir una clase a las filas
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

        $('#abogados_filter label').addClass('busca');
        $('#abogados_length label').addClass('mostrar');

    }


</script>