<?php
session_start();
if (!session_is_registered(myusername)) {
    header("Location: index.html");
}
?>

<html>
    <head>
        <title>Despachos</title> 

        <script>
            function mostrar(valor) {

                if (valor === 0) {
                    document.getElementById("agregar").style.display = "none";
                    document.getElementById("borrar").style.display = "none";
                }  print
                "<form action='altas.php' method='get'>
            <table>            
                <tr>
                    <td>
                        <p>Nombre del despacho</p>
                    </td>
                    <td>
                        <input type='text' name='nombre' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Dirección del despacho</p>
                    </td>
                    <td>
                        <input type='text' name='id_Direccion' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type='submit' value='Aceptar' />
                    </td>
                </tr>
            </table>
         </form>
        ";
                else if (valor === 1) {

                    document.getElementById("agregar").style.display = "block";
                    document.getElementById("borrar").style.display = "none";
                }
                else if (valor === 2) {

                    document.getElementById("borrar").style.display = "block";
                    document.getElementById("agregar").style.display = "none";
                }


            }
        </script>
    </head>    
    <body onload="mostrar(0);">  
        <h2>Administraci&oacute;n de Despachos</h2>
        <br>
        <table>
            <tr><td><a href="#" onclick="mostrar(1);">Agregar Despacho</a> </td>
                <td><a href="#" onclick="mostrar();">Mostrar Despacho</a> </td>
                <td><a href="#" onclick="mostrar(2);">Eliminar Despacho</a> </td>
            </tr>

        </table>

        <div  id="agregar">

            <p>Ingresa los siguientes Datos para añadir un Despacho</p>
            <form  name="nuevo_despacho" method="post" action="maneja_despachos.php">

                <input type="hidden"
                       name="accion"
                       value="Insert">

                <label> Nombre:
                    <input type="text"
                           name="nombre"
                           size="30">
                </label>

                <label> Direcci&oacute;n:
                    <input type="text"
                           name="direccion"
                           size="30">
                </label>  

                <input type="submit"
                       value="Enviar">

            </form>
        </div>

        <div  id="borrar">

            <p>Ingresa el nombre del despacho a borrar<p>

            <form  name="borra_despacho" method="post" action="maneja_despachos.php">

                <input type="hidden"
                       name="accion"
                       value="Delete">

                <input type ="text"
                       name="nombre">

                <input type="submit"
                       value="Enviar">

            </form>
        </div>

    </body>
</html>


