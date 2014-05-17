<script>
   $(document).ready(function verificar() {
alert("ready");
    $("#forma_verificar").validate({

    rules: {
    nombre: "required",
            contrasena: {
            required: true,
                    minlength: 5
            },
            contrasena_conf: {
            required: true,
                    minlength: 5,
                    equalTo: "#contrasena"
            },
            email: {
            required: true,
                    email: true
            },
        apellidoP: "required",
        apellidoM: "required"
    },
            messages: {
            nombre: "Nombre Necesario",
                    contrasena: {
                    required: "Por favor ingrese contrasena",
                            minlength: "Contrasena debe contar con más de 5 caracteres"
                    },
                    contrasena_conf: {
                    required: "Confirmar Contraseña",
                            minlength: "Contrasena debe contar con más de 5 caracteres",
                            equalTo: "Confirmación de contrasena incorrecta"
                    },
                    email: "Ingresar Correo Valido",
                    apellidoP: "Campo Necesario",
                    apellidoM: "Campo Necesario"                    

            }


    });

});
</script>