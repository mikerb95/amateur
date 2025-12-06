document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nombre  = document.getElementById('nombre').value.trim();
        const email   = document.getElementById('email').value.trim();
        const plan    = document.getElementById('plan').value;
        const mensaje = document.getElementById('mensaje').value.trim();

        if (!nombre || !email || !mensaje) {
            alert('Por favor completa nombre, correo y mensaje.');
            return;
        }

        const telefono = '573024221645';

        let texto = `Hola, soy ${nombre}.\n`;
        texto += `Mi correo es: ${email}.\n`;
        if (plan) {
            texto += `Estoy interesado en el plan: ${plan}.\n`;
        }
        texto += `Mensaje: ${mensaje}`;

        const url = `https://wa.me/${+573124990624}?text=${encodeURIComponent(texto)}`;

        window.open(url, '_blank');
    });
});
