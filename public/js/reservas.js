    document.addEventListener('DOMContentLoaded', function () {
    const dayButtons = document.querySelectorAll('.day');
    const classCards = document.querySelectorAll('.class-card');

    // Función que muestra solo las tarjetas de un día
    function mostrarClasesDelDia(dia) {
        classCards.forEach(card => {
            const diaCard = card.getAttribute('data-day');

            if (diaCard === dia) {
                card.style.display = 'flex';   // se muestra (flex porque dentro usamos flex-direction: column)
            } else {
                card.style.display = 'none';   // se oculta
            }
        });
    }

    // Al cargar la página, mostramos solo las de Lunes (lun)
    mostrarClasesDelDia('Lunes');

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
