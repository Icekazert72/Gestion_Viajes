document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#formRegister form');
    const inputs = form.querySelectorAll('input');
    const overlay = document.getElementById('overlay-spinner');
    const resultado = document.getElementById('resultadoPassword');
    const clave = document.getElementById('claveGenerada');
    const title = document.querySelector('#titleText');

    // Expresiones regulares
    const patterns = {
        nombre: /^[a-zA-ZÀ-ÿ\s]{2,40}$/,
        apellidos: /^[a-zA-ZÀ-ÿ\s]{2,60}$/,
        edad: /^\d{1,3}$/,
        dni: /^[0-9]{7,9}[A-Za-z]?$/,
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        telefono: /^\+?[0-9]{6,15}$/
    };

    // Validación de campos
    function validateInput(input) {
        const value = input.value.trim();
        const field = input.name;
        const icon = input.parentElement.querySelector('.valid-icon');
        let isValid = true;

        if (field === 'imagen') {
            isValid = input.files.length > 0;
        } else if (patterns[field]) {
            isValid = patterns[field].test(value);
        }

        // Iconos de validación
        if (icon) {
            icon.classList.remove('fa-check-circle', 'fa-times-circle', 'text-success', 'text-danger');
            if (isValid) {
                icon.classList.add('fa-check-circle', 'text-success');
            } else {
                icon.classList.add('fa-times-circle', 'text-danger');
            }
        }

        return isValid;
    }

    // Eventos para cada input
    inputs.forEach(input => {
        input.addEventListener('input', () => validateInput(input));
        input.addEventListener('blur', () => validateInput(input));
    });

    // Evento al enviar el formulario
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let isValid = true;
        inputs.forEach(input => {
            if (!validateInput(input)) isValid = false;
        });

        if (!isValid) {
            showToast('Por favor corrige los campos antes de continuar.');
            return;
        }

        const btnEnviar = document.getElementById('regis');
        const btnSalir = document.getElementById('btnSalir');

        // Guardamos el contenido original del botón Registrar para restaurarlo luego
        const originalBtnContent = btnEnviar.innerHTML;

        // Mostrar spinner + texto "Registrando..." en el botón Registrar y deshabilitarlo
        btnEnviar.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registrando...`;
        btnEnviar.setAttribute('disabled', 'disabled');

        // Deshabilitar botón Cancelar mientras dura la operación
        btnSalir.setAttribute('disabled', 'disabled');

        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../models/login.php', true);

        xhr.onload = function () {
            btnEnviar.innerHTML = originalBtnContent;
            btnEnviar.removeAttribute('disabled');
            btnSalir.removeAttribute('disabled');

            console.log('Status:', xhr.status);
            console.log('Response:', xhr.responseText);

            if (xhr.status === 200) {
                const passwordGenerada = xhr.responseText.trim();

                form.reset();
                form.classList.add('d-none');
                clave.textContent = passwordGenerada;

                resultado.classList.remove('d-none');
                mostrarVentanaEmergente(passwordGenerada);
            } else {
                showToast('Error en el registro: ' + xhr.responseText);
            }
        };


        xhr.onerror = function () {
            // Restaurar botón Registrar y habilitarlo
            btnEnviar.innerHTML = originalBtnContent;
            btnEnviar.removeAttribute('disabled');

            // Habilitar botón Cancelar
            btnSalir.removeAttribute('disabled');

            showToast("No se pudo enviar la solicitud AJAX.");
        };

        xhr.send(formData);
    });



    // Vista previa de imagen
    const inputImagen = document.getElementById('imagen');
    const previewImg = document.getElementById('imagePreview');
    const placeholder = document.getElementById('imagePlaceholder');

    inputImagen.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            previewImg.style.display = 'none';
            placeholder.style.display = 'inline';
        }
    });

});

// Ventana emergente moderna
function mostrarVentanaEmergente(password) {
    const modal = document.createElement('div');
    modal.className = 'ventana-emergente';
    modal.innerHTML = `
        <div class="ventana-contenido animate__animated animate__fadeInDown">
            <p class="mensaje fw-semibold text-center mb-2">
                 <small style="color:black;">Haz una captura de pantalla de tu clave. La necesitarás para iniciar sesión.</small>
            </p>
            <div class="clave-box text-center mb-3">${password}</div>
            <button class="btn btn-success w-100" id="btnEntendido">Iniciar Sesión</button>
        </div>
    `;

    // Estilo del overlay
    Object.assign(modal.style, {
        position: 'fixed',
        top: '0',
        left: '0',
        right: '0',
        bottom: '0',
        backgroundColor: 'rgba(0,0,0,0.8)',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        zIndex: '9999',
        padding: '1rem'
    });

    document.body.appendChild(modal);

    // Estilos responsivos con JS
    const contenido = modal.querySelector('.ventana-contenido');
    Object.assign(contenido.style, {
        backgroundColor: '#fff',
        borderRadius: '1rem',
        padding: '2rem',
        maxWidth: '400px',
        width: '100%',
        boxShadow: '0 0 20px rgba(0,0,0,0.2)',
        textAlign: 'center',
        fontFamily: 'Arial, sans-serif'
    });

    const claveBox = modal.querySelector('.clave-box');
    Object.assign(claveBox.style, {
        fontSize: '1.75rem',
        fontWeight: 'bold',
        color: 'white',
        backgroundColor: '#000',
        borderRadius: '0.75rem',
        padding: '0.75rem',
        wordBreak: 'break-word'
    });

    // Botón cerrar
    document.getElementById('btnEntendido').addEventListener('click', () => {
        modal.remove();
        window.location.href = '../../views/login/index.php';
    });
}



document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#formLogin form');
    const titleText = document.getElementById('titleText');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Limpiar mensajes anteriores
        titleText.textContent = '';
        titleText.classList.remove('text-danger');

        const inputs = form.querySelectorAll('input[name="password"]');
        let password = '';
        inputs.forEach(input => {
            password += input.value.trim();
        });

        const username = form.querySelector('input[name="username"]').value.trim();

        // Validación rápida antes de enviar
        if (username === '' || password.length < 5) {
            titleText.textContent = 'Por favor, completa todos los campos.';
            titleText.classList.add('text-danger');
            return;
        }

        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../models/log_in.php', true);

        xhr.onload = function () {
            try {
                const response = JSON.parse(xhr.responseText.trim());

                if (xhr.status === 200 && response.status === 'success') {
                    if (response.tipo === 'usuario') {
                        window.location.href = '../../index.php'; // página del usuario
                    } else if (response.tipo === 'agencia') {
                        window.location.href = '../../views/admin/admin_agencias/index.php'; // página de agencia (ajusta ruta)
                    }
                } else {
                    titleText.textContent = response.message || 'Error en las credenciales.';
                    titleText.classList.add('text-danger');
                }
            } catch (error) {
                titleText.textContent = 'Error inesperado. Intenta más tarde.';
                titleText.classList.add('text-danger');
            }
        };


        xhr.onerror = function () {
            titleText.textContent = 'Error del servidor. Intenta más tarde.';
            titleText.classList.add('text-danger');
        };

        xhr.send(formData);
    });

    // Movimiento automático entre inputs del PIN
    const pinInputs = document.querySelectorAll('.pin-input');
    pinInputs.forEach((input, index) => {
        input.addEventListener('input', function () {
            if (input.value.length === 1 && index < pinInputs.length - 1) {
                pinInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && input.value === '' && index > 0) {
                pinInputs[index - 1].focus();
            }
        });
    });
});



function showToast(message, type = 'info', duration = 4000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.textContent = message;

    container.appendChild(toast);

    // Remover toast después de duración + animación
    setTimeout(() => {
        toast.style.animation = 'fadeout 0.5s forwards';
        toast.addEventListener('animationend', () => toast.remove());
    }, duration);
}
