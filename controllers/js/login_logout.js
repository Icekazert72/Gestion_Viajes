const inputs = document.querySelectorAll('.pin-input');

inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
        if (input.value.length > 0 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && input.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

const inputImagen = document.getElementById('imagen');
const preview = document.getElementById('imagePreview');

inputImagen.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.addEventListener('load', function () {
            preview.innerHTML = `<img src="${this.result}" alt="Imagen seleccionada">`;
        });

        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = `<p>Vista previa de la imagen</p>`;
    }
});