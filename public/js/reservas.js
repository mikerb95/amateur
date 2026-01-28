document.addEventListener('DOMContentLoaded', function () {
  const dayButtons = document.querySelectorAll('.day');
  const classCards = document.querySelectorAll('.class-card');

  // ✅ Normaliza texto: minúsculas + trim + quitar dobles espacios
  function norm(str) {
    return (str || '')
      .toString()
      .trim()
      .toLowerCase()
      .replace(/\s+/g, ' ');
  }

  function mostrarClasesDelDia(dia) {
    const diaN = norm(dia);

    classCards.forEach(card => {
      const diaCard = norm(card.getAttribute('data-day'));
      card.style.display = (diaCard === diaN) ? 'flex' : 'none';
    });
  }

  // ✅ Días (normalizados)
  const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
  const hoy = dias[new Date().getDay()];

  // Quitar active inicial
  dayButtons.forEach(b => b.classList.remove('active'));

  // Marcar botón del día actual (comparación normalizada)
  dayButtons.forEach(boton => {
    const diaBoton = norm(boton.getAttribute('data-day'));
    if (diaBoton === norm(hoy)) {
      boton.classList.add('active');
    }
  });

  // Mostrar clases del día actual
  mostrarClasesDelDia(hoy);

  // Click para cambiar de día
  dayButtons.forEach(button => {
    button.addEventListener('click', function () {
      dayButtons.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const diaSeleccionado = this.getAttribute('data-day');
      mostrarClasesDelDia(diaSeleccionado);
    });
  });
});
