<style>
    
    #form_entidad label.error {
color:red;
}
#form_entidad input.error {
border:1px solid red;
}

    
    
</style>


<script>
    function verificar() {

        $("#forma_entidad").validate({
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
                apellidoM: "required",
                telefono: {
                    required: true,
                    number: true
                },
                calle: "required",
                no_exterior: "required",
                no_interior: "required",
                colonia: "required",
                ciudad: "required",
                id_Estado: "required",
                id_Municipio: "required",
                cp: {
                    required: true,
                    number: true,
                    maxlength:5
                },
                cantidad:{
                    required: true,
                    number: true
                }
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
                apellidoM: "Campo Necesario",
                telefono: {
                    required: "Campo Necesario",
                    number: "Teléfono Numérico"
                },
                calle: "Campo Necesario",
                no_exterior: "Campo Necesario",
                no_interior: "Campo Necesario",
                colonia: "Campo Necesario",
                ciudad: "Campo Necesario",
                id_Estado: "Campo Necesario",
                id_Municipio: "Campo Necesario",
                cp: {
                    required: "Campo Necesario",
                    number: "Campo Numérico",
                    maxlength: "El CP no puede exceder 5 valores"
                },
                cantidad: {
                    required: "Campo Necesario",
                    number: "Monto Numérico"
                }

            }


        });

    }
</script>