

  const track = document.getElementById('carouselTrack');
  let position = 0;
  const cardWidth = 270; // ancho + márgenes
  const maxScroll = -(track.scrollWidth - track.clientWidth);

  function moveCarousel(direction) {
    position += direction * cardWidth;
    if (position > 0) position = 0;
    if (position < maxScroll) position = maxScroll;
    track.style.transform = `translateX(${position}px)`;
  }

  // Desplazamiento automático cada 3 segundos
  setInterval(() => {
    let newPosition = position - cardWidth;
    if (newPosition < maxScroll) {
      newPosition = 0; // reinicia al principio
    }
    position = newPosition;
    track.style.transform = `translateX(${position}px)`;
  }, 3000);
