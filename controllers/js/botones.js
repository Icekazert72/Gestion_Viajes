
var menu_opciones = document.getElementById('opciones');
var barButton = document.getElementById('btn_mn');
var header = document.getElementById('header');
var hidenMEnu = document.getElementById('hidenmenu');

    barButton.addEventListener('click', function () {
        console.log('yes');
        header.classList.toggle('openMenu');
        hidenMEnu.classList.toggle('mostrar');
    });