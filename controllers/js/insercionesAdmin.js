document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formNuevaAgencia');
    const campos = document.querySelectorAll('.campo-validacion');
    const btnNuevaAgencia = document.getElementById('btnNuevaAgencia');
    const btnCancelar = document.getElementById('cancelar-agencia');

    // Validación en tiempo real
    campos.forEach(campo => {
        campo.addEventListener('input', () => validarCampo(campo));
    });

    function validarCampo(campo) {
        const icono = campo.parentElement.querySelector('.icono-validacion i');
        if (campo.value.trim() === "") {
            icono.className = 'fas fa-circle text-muted'; // estado inicial
            return;
        }
        if (campo.checkValidity()) {
            icono.className = 'fas fa-check text-success';
        } else {
            icono.className = 'fas fa-times text-danger';
        }
    }

    // Envío del formulario
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('Funciona');
       

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../Proyecto_0.1/models/general_agencias.php', true);

        xhr.onload = function () {

            if (xhr.status >= 400) {
                alert("Error del servidor: " + xhr.status);
                console.log(xhr.responseText);
                console.error("Respuesta HTTP:", xhr.responseText);
                return;
            }

            try {
                const respuesta = JSON.parse(xhr.responseText);
                if (respuesta.success) {
                    
                    alert(respuesta.message);
                    form.reset();
                    form.classList.remove('was-validated');

                    // Reiniciar iconos de validación
                    document.querySelectorAll('.icono-validacion i').forEach(icono => {
                        icono.className = 'fas fa-circle text-muted';
                    });

                    // Mostrar tabla, ocultar formulario
                    document.getElementById('formNuevaAgencia').classList.add('d-none');
                    document.getElementById('tablaAgencias').classList.remove('d-none');
                } else {
                    alert("Error: " + respuesta.message);
                    console.log(xhr.responseText);

                }
            } catch (e) {
                alert("Error inesperado en el servidor.");
                console.error("Excepción:", e, "Respuesta:", xhr.responseText);
                console.log(xhr.responseText);
            }
        };

        xhr.onerror = function () {
            alert("Error de red al enviar el formulario.");
            console.log(xhr.responseText);
            console.log(xhr.responseText);
        };

        xhr.send(formData);
    });

    // Mostrar formulario
    btnNuevaAgencia.addEventListener('click', () => {
        document.getElementById('tablaAgencias').classList.add('d-none');
        document.getElementById('formNuevaAgencia').classList.remove('d-none');
    });

    // Cancelar botón
    btnCancelar.addEventListener('click', () => {
        document.getElementById('tablaAgencias').classList.remove('d-none');
        document.getElementById('formNuevaAgencia').classList.add('d-none');
    });
});
