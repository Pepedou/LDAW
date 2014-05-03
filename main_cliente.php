<?php
session_start();
if (!session_is_registered(myusername)) {
    header("Location: index.html");
}
include_once './Clases/Cliente.php';
include_once './Clases/AbogadosCasos.php';
include_once './Clases/AbogadosClientes.php';

$nombreUsuario = $_COOKIE['usuario'];
$miUsuario = new Cliente();
$aux = new AbogadosClientes(); //abogados de ese cliente
/* Cargar cliente */
$exito = $miUsuario->cargarDeBD("email", $nombreUsuario);

$aux->guardarDatos(array(
    "id_Cliente" => $miUsuario->atributos['id']
));
/* Cargar abogados que atienden al cliente */
$abogados = $aux->cargarAbogados();
/* Cargar casos correspondientes al cliente */
$casos = $miUsuario->cargarCasos();
$debug = Debug::getInstance();
?>
<html>

    <head data-gwd-animation-mode="proMode">
        <title>Vistas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="generator" content="Google Web Designer 1.0.5.0416">     
        
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="js/main_cliente.js" ></script>
        <style>
            html, body {
                width: 100%;
                height: 100%;
                margin: 0px;
            }
            body {
                background-color: transparent;
                -webkit-transform: perspective(1400px) matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
                -webkit-transform-style: preserve-3d;
            }
            .gwd-div-4mle {
                position: absolute;
                padding-bottom: 0px;
                border-width: 5px;
                border-style: solid;
                width: 15%;
                height: 100%;
                -webkit-transform-origin: 123.5573041836px 332.9652085745px 0px;
                -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
                left: 0px;
                top: 15%;
            }
            .gwd-div-rjvq {
                position: absolute;
                padding-left: 0px;
                padding-right: 0px;
                width: 100%;
                border-width: 5px;
                border-style: solid;
                height: 15%;
                -webkit-transform-origin: 763.5px 63.5px 0px;
                -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
                left: 2.308468411516742px;
                top: 1.3845697482792474px;
            }
            .gwd-div-7t0n {
                position: absolute;
                width: 100%;
                height: 100%;
                border-width: 5px;
                border-style: solid;
                -webkit-transform-origin: 665.4132070832px 333.9941162866px 0px;
                -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
                left: 15%;
                top: 15%;
            }
            .gwd-div-2osj {
                position: absolute;
                width: 9.0049894351px;
                height: 7.9903655519px;
                left: 1153.7560452847px;
                top: 573.9116278742px;
            }
            .gwd-div-mxuu {
                position: absolute;
                width: 15%;
                height: 15%;
                left: 1px;
                top: 0px;
            }
            .gwd-img-zvzd {
                position: absolute;
                width: 15%;
                height: 15%;
                -webkit-transform-origin: 114px 58px 0px;
                -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
                left: 0px;
                top: 0px;
            }
            .gwd-div-lim3 {
                position: relative;
                width: auto;
                -webkit-transform: matrix3d(0.9999550804, 0.0094782472, 0, 0, -0.0094782472, 0.9999550804, 0, 0, 0, 0, 1, 0, 0.1706084496, 0.0008085528, 0, 1);
                -webkit-transform-style: preserve-3d;
                height: 30px;
                top: 20px;
                left: 5px;
            }
            .gwd-div-xrkl {
                font-family:'Times New Roman';
                color: rgb(0, 0, 0);
                position: relative;
                width: auto;
                height: auto;
                left: 0px;
                top: 0px;
                text-align: center;
            }
            .gwd-div-bx6z {
                text-align: center;
            }
            .gwd-span-xmh2 {
                font-family:'Courier New';
                font-size: 30px;
            }
        </style>
    </head>

    <body>
        <div class="gwd-div-4mle" id="leftnav">
            <div class="gwd-div-lim3" id="menu_entry1">
                <div class="gwd-div-bx6z"><span class="gwd-span-xmh2">Casos</span>

                </div>
            </div><br>
            <div class="gwd-div-lim3" id="menu_entry2">
                <div class="gwd-div-bx6z"><span class="gwd-span-xmh2">Abogados</span>

                </div>
            </div><br>
            <div class="gwd-div-lim3" id="menu_entry3">
                <div class="gwd-div-bx6z"><span class="gwd-span-xmh2">Cuenta</span>

                </div>
            </div><br>           
        </div>
        <img class="gwd-img-zvzd" id="img_logo">
        <div class="gwd-div-7t0n" id="main">


            <table id="abogados" class="tablesorter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <?php
                foreach ($abogados as $abogado) {
                    print "<td>" . $abogado->atributos['nombre'] . "</td>";
                    print "<td>" . $abogado->atributos['email'] . "</td>";
                }
                ?>
                <tbody>
            </table>

            <table id="casos" class="tablesorter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <?php
                foreach ($casos as $caso) {
                    print "<tr>";
                    print "<td>" . $caso->atributos['nombre'] . "</td>";
                    print "<td>" . $caso->atributos['status'] . "</td>";
                    print "</tr>";
                }
                ?>
                <tbody>
            </table>


        </div>
        <div class="gwd-div-rjvq" id="header">
            <h2>Bienvenido <?php
                if ($exito)
                    echo $miUsuario->atributos['nombre'];
                else
                    echo "Usuario(a)";
                ?></h2>
        </div>
        <div class="gwd-div-2osj"></div>
        <div class="gwd-div-mxuu" id="div_logo"></div>
    </body>

</html>