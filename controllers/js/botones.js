var botonDawn = document.getElementById('drop-down');
var botonU = document.getElementById('drop-up');
var menu_opciones = document.getElementById('opciones');
var barButton = document.getElementById('btn_mn');
var header = document.getElementById('header');
var hidenMEnu = document.getElementById('hidenmenu');


    botonDawn.addEventListener ('click', function () {
        botonDawn.style.display = 'none';
        menu_opciones.style.display = 'block';
    });
    
    botonU.addEventListener ('click', function () {
        menu_opciones.style.display = 'none';
        botonDawn.style.display = 'block';
    });

    barButton.addEventListener('click', function () {
        console.log('yes');
        header.classList.toggle('openMenu');
        hidenMEnu.classList.toggle('mostrar');
    });