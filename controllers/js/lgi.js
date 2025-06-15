

const Direcciones = [
  // Región Insular
  "Malabo", "Luba", "Rebola", "Baney", "Riaba", "Moka", "Pico Basile",
  "Sipu", "Balacha", "Basupu", "Basacato del Oeste", "Basacato del Este",
  "Buena Esperanza I", "Buena Esperanza II",
  "Avenida Assan I", "Avenida Assan II",
  "Malabo II", "Ela Nguema", "Sampaka",

  // Annobón
  "San Antonio de Palé", "Annobón",

  // Región Continental
  "Bata", "Mbini", "Kogo", "Cogo", "Machinda",
  "Acurenam", "Evinayong", "Nzeng-Ayong", "Bicurga", "Ncue",
  "Mongomo", "Nsok-Nsomo", "Anisok", "Oveng", "Etembue", "Mengomeyen",
  "Ebebiyin", "Mikomeseng", "Nsang", "Bitica", "Nsok-Esono",
  "Niefang", "Oyala", "Ciudad de la Paz", "Ngolo", "Endem", "Akurenam",
  "Aconibe", "Esono", "Envom", "Bicurga",

  // Otros lugares reconocidos
  "Bicurga", "Nsok-Esono", "Nsok-Mbeng", "Bikurga", "Akoga",
  "Campo Yaunde", "Ngonamanga", "Afokang", "Ncoho", "Bitica",
  "Nkumekie", "Ebuluji", "Ebang", "Nsomo", "Ncolombong",
  "Nsang", "Mendumu", "Eyang", "Nkué", "Nsué",
  "Nsangayong", "Envom", "Akonibe", "Abong", "Niefang"
];

function setDirecciones(inputId, selecionId) {

    const input = document.getElementById(inputId);
    const caja_Sugerencias = document.getElementById(selecionId);

    input.addEventListener('input', () => {
        const valores = input.value.toLowerCase();
        caja_Sugerencias.innerHTML = ''; // Limpiar las sugerencias anteriores

        if (valores.length === 0) return; // Si no hay valor, no mostrar sugerencias

        const sugerencias = Direcciones.filter(dir => dir.toLowerCase().includes(valores));

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