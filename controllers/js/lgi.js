
const Direciones = [
    "Malabo", "Bata", "Ebebiyin", "Evinayong", "Luba", "Mongomo",
    "Niefang", "Mbini", "Annobón", "Kogo", "Aconibe",
    "Bata", "Cogo", "Evinayong", "Luba", "Mongomo", "Niefang", "Oyala",
    "Rebola", "Aconibe", "Bata", "Cogo", "Evinayong", "Luba","Malalbo II",
    "Avenida Assan I", "Avenida Assan II", "Buena Esperanza I", "Buena Esperanza II",
    ""
];

function setDirecciones(inputId, selecionId) {

    const input = document.getElementById(inputId);
    const caja_Sugerencias = document.getElementById(selecionId);

    input.addEventListener('input', () => {
        const valores = input.value.toLowerCase();
        caja_Sugerencias.innerHTML = ''; // Limpiar las sugerencias anteriores

        if (valores.length === 0) return; // Si no hay valor, no mostrar sugerencias

        const sugerencias = Direciones.filter(dir => dir.toLowerCase().includes(valores));

        sugerencias.forEach(dir => {
            const sugerencia = document.createElement('div');
            sugerencia.textContent = dir;
            sugerencia.addEventListener('click', () => {
                input.value = dir; // Asignar el valor seleccionado al input
                caja_Sugerencias.innerHTML = ''; // Limpiar las sugerencias
            });
            caja_Sugerencias.appendChild(sugerencia); // Añadir la sugerencia al contenedor
        })

    });

    document.addEventListener('click', (e) => {
        if (!caja_Sugerencias.contains(e.target) && e.target !== input) {
            caja_Sugerencias.innerHTML = ''; // Limpiar las sugerencias si se hace clic fuera
        }
        if (e.target === input) {
            caja_Sugerencias.innerHTML = ''; // Limpiar las sugerencias si se hace clic en el input
        }
    });


}

document.getElementById('idiomas').addEventListener('change', function () {
    const  lenguajes = this.value;

    const dir = {
        es: './index.php',
        fr: './views/Fr/index.php',
        en: './views/Eng/index.php'
    }

    window.location.href = dir[lenguajes]; // Redirigir a la página correspondiente según el idioma seleccionado
    // window.location.href = `./view/${lenguajes}/index.php`; // Redirigir a la página correspondiente según el idioma seleccionado    

});


setDirecciones('input_de', 'deSugerencia');
setDirecciones('input_a', 'aSugerencia');