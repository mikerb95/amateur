<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>
<link rel="stylesheet" href="<?= base_url('css/contacto.css') ?>">

<main class="contacto-main">
    <section id="contacto" class="contacto-section">
        <h1 class="page-title">Contáctanos</h1>
        <p class="intro">Estamos listos para guiarte en tu camino hacia la disciplina y el fitness. ¡Resuelve tus dudas o reserva tu clase de prueba!</p>

        <div class="contacto-wrapper">
            
            <div class="contacto-info-map">
                <div class="info-block">
                    <h2>Información Club Amateur</h2>
                    
                    <div class="detail-group">
                        <img src="<?= base_url('imagenes/location.svg') ?>" alt="Dirección" class="info-icon">
                        <p>Dirección: Ac. 153 # 96A - 10, Suba, Bogotá</p>
                    </div>
                    
                    <div class="detail-group">
                        <img src="<?= base_url('imagenes/telefono.svg') ?>" alt="Teléfono" class="info-icon">
                        <p>Teléfono: <a href="tel:3024221645">302 422 1645</a></p>
                    </div>
                    
                    <div class="detail-group">
                        <img src="<?= base_url('imagenes/email.svg') ?>" alt="Email" class="info-icon">
                        <p>Email: <a href="mailto:jhonnysuan_94@outlook.com">jhonnysuan_94@outlook.com</a></p>
                    </div>
                    
                    <div class="detail-group">
                        <img src="<?= base_url('imagenes/reloj.svg') ?>" alt="Horario" class="info-icon">
                        <p>Horario: Lunes a Viernes (5 AM - 9 PM)</p>
                    </div>
                </div>

                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps?q=Ac.+153+%23+96A+-+10,+Suba,+Bogotá&output=embed"
                        width="100%" height="300" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <div class="contacto-form-container">
                <h2>Envíanos un Mensaje</h2>
                <form id="contactForm" class="contact-form">
                    
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                    
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="plan">Plan o Asunto de Interés</label>
                    <select id="plan" name="plan">
                        <option value="" disabled selected>Selecciona un plan o asunto...</option>
                        <option value="consulta">Consulta General</option>
                        <option value="basico">PLAN INDIVIDUAL</option>
                        <option value="intermedio">PLAN PAREJA</option>
                        <option value="avanzado">PLAN 4 PERSONAS</option>
                    </select>

                    <label for="mensaje">Tu Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                    
                    <button type="submit" class="btn btn-submit">Enviar Mensaje</button>
                </form>
            </div>

        </div>
    </section>
    <script src="<?= base_url('js/contacto.js') ?>"></script>
</main>

<?php echo $this->endSection();?>