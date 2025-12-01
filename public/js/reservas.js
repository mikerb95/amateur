document.addEventListener('DOMContentLoaded', function () {
    const dayButtons = document.querySelectorAll('.day');
    const classCards = document.querySelectorAll('.class-card');

    // Función que muestra solo las tarjetas de un día
    function mostrarClasesDelDia(dia) {
        classCards.forEach(card => {
            const diaCard = card.getAttribute('data-day'); // ej: 'martes'

            if (diaCard === dia) {
                card.style.display = 'flex';   // se muestra
            } else {
                card.style.display = 'none';   // se oculta
            }
        });
    }

    // 🔹 Días en minúsculas para que coincidan con data-day
    const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    const hoy = dias[new Date().getDay()];   // ej: 'martes'

    // Quitar cualquier 'active' inicial
    dayButtons.forEach(b => b.classList.remove('active'));

    // Marcar como activo el botón del día actual
    dayButtons.forEach(boton => {
        const diaBoton = boton.getAttribute('data-day');
        if (diaBoton === hoy) {
            boton.classList.add('active');
        }
    });

    // Mostrar solo las clases del día actual
    mostrarClasesDelDia(hoy);

    // Eventos de click para cambiar de día
    dayButtons.forEach(button => {
        button.addEventListener('click', function () {
            // 1. Cambiar el botón activo
            dayButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // 2. Leer el data-day del botón clicado
            const diaSeleccionado = this.getAttribute('data-day');

            // 3. Mostrar solo las clases de ese día
            mostrarClasesDelDia(diaSeleccionado);
        });
    });
});
