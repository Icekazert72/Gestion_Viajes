document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formRegistroUsuario');
    const campos = formulario.querySelectorAll('.campo-validacion');
    const animacion = document.getElementById('envioAnimacion');

    campos.forEach(campo => {
        campo.addEventListener('input', () => validarCampo(campo));
        campo.addEventListener('blur', () => validarCampo(campo));
    });

    function validarCampo(campo) {
        const icono = campo.parentElement.querySelector('.icono-validacion i');
        if (campo.checkValidity()) {
            icono.classList.remove('fa-circle', 'text-danger');
            icono.classList.add('fa-check-circle', 'text-success');
        } else {
            icono.classList.remove('fa-check-circle', 'text-success');
            icono.classList.add('fa-times-circle', 'text-danger');
        }
    }

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        let valido = true;
        campos.forEach(campo => {
            if (!campo.checkValidity()) {
                validarCampo(campo);
                valido = false;
            }
        });

        if (!valido) return;

        const formData = new FormData(formulario);

        // Generar contraseña automática (5 dígitos numéricos aleatorios)
        const pass = String(Math.floor(Math.random() * 100000)).padStart(5, '0');
        formData.append('password_generada', pass);

        // Mostrar animación
        animacion.style.display = 'flex';

        // Simular envío con animación (3 segundos)
        setTimeout(() => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../models/usuarios_submin.php', true);

            xhr.onload = () => {
                animacion.style.display = 'none'; // Ocultar animación

                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    formulario.reset();
                    document.querySelectorAll('.icono-validacion i').forEach(icono => {
                        icono.className = 'fas fa-circle';
                    });
                } else {
                    alert("Error al enviar formulario.");
                }
            };

            xhr.send(formData);
        }, 3000);
    });
});