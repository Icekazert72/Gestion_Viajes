  const botones = document.querySelectorAll('.boton-menu');
  const secciones = document.querySelectorAll('.seccion-contenido');
  const entradaBuscador = document.getElementById('entrada-buscador');
  let seccionActiva = 'restaurante';

  botones.forEach(boton => {
    boton.addEventListener('click', () => {
      botones.forEach(btn => btn.classList.remove('activo'));
      boton.classList.add('activo');

      const destino = boton.getAttribute('data-destino');
      secciones.forEach(seccion => {
        seccion.classList.toggle('activa', seccion.id === destino);
      });

      seccionActiva = destino;
      entradaBuscador.value = '';
      filtrarTarjetas('');
    });
  });

  entradaBuscador.addEventListener('input', () => {
    const texto = entradaBuscador.value.toLowerCase();
    filtrarTarjetas(texto);
  });

  function filtrarTarjetas(texto) {
    const cajas = document.querySelectorAll(`#${seccionActiva} .caja`);
    cajas.forEach(caja => {
      const titulo = caja.querySelector('h4').textContent.toLowerCase();
      caja.style.display = titulo.includes(texto) ? '' : 'none';
    });
  }

  // Modal
  const modal = document.getElementById('modal-info');
  const cerrarModal = document.getElementById('cerrar-modal');
  const modalTitulo = document.getElementById('modal-titulo');
  const modalDescripcion = document.getElementById('modal-descripcion');

  document.addEventListener('click', e => {
    if (e.target.classList.contains('btn-mas-info')) {
      const caja = e.target.closest('.caja');
      modalTitulo.textContent = caja.querySelector('h4').textContent;
      modalDescripcion.textContent = caja.getAttribute('data-detalle');
      modal.classList.add('activo');
    } else if (e.target === cerrarModal || e.target === modal) {
      modal.classList.remove('activo');
    }
  });