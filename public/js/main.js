document.addEventListener('DOMContentLoaded', function () {
  // Zoom overlay para imagen de planes (si está presente)
  const imagenes = document.querySelectorAll('.imagen-zoomable');
  const overlay = document.getElementById('overlay');
  const imagenAmpliada = document.getElementById('imagen-ampliada');

  if (imagenes && overlay && imagenAmpliada) {
    imagenes.forEach(img => {
      img.addEventListener('click', () => {
        imagenAmpliada.src = img.src;
        overlay.style.display = 'flex';
      });
    });
    overlay.addEventListener('click', (e) => {
      if (e.target !== imagenAmpliada) {
        overlay.style.display = 'none';
        imagenAmpliada.src = '';
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".slider-img");
  let current = 0;

  function cambiarSlide() {
    slides[current].classList.remove("activa");
    current = (current + 1) % slides.length;
    slides[current].classList.add("activa");
  }

  setInterval(cambiarSlide, 4000); // cambia cada 4 segundos
});

// Menú hamburguesa - Versión mejorada
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM Cargado'); // Para verificar que se ejecuta
  
  const menuToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('nav');
  
  console.log('Menu Toggle:', menuToggle); // Debug
  console.log('Nav:', nav); // Debug
  
  if (menuToggle && nav) {
    menuToggle.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Click en menú'); // Debug
      
      nav.classList.toggle('active');
      
      // Cambiar el icono
      if (nav.classList.contains('active')) {
        this.textContent = '✕';
        console.log('Menú abierto');
      } else {
        this.textContent = '☰';
        console.log('Menú cerrado');
      }
    });
  } else {
    console.error('No se encontraron los elementos del menú');
  }
});