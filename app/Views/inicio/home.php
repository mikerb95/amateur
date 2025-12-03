<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>
<link rel="stylesheet" href="<?= base_url('css/home.css') ?>">


<main class="home-main">
    <section class="hero">
        <div class="hero-image-container">
            
            <img src="<?= base_url('imagenes/wrestling.jpg') ?>" alt="Entrenamiento de MMA en Club Amateur" class="hero-img">
        </div>
        <div class="hero-content">
            <h1>¡Entrena tu Fuerza y Dominio!</h1>
            <p class="subtitle">Somos el centro de acondicionamiento de Artes Marciales Mixtas (MMA) donde transformamos el cuerpo y la mente.</p>
            <a href="<?= base_url('/inicio/planes') ?>" class="btn btn-hero">
                Ver Planes y Empezar Hoy
                <img src="<?= base_url('imagenes/cursor.svg') ?>" alt="Ir" class="btn-icon">
            </a>
        </div>
    </section>

    <section class="purpose">
        <h2>Más que un Gimnasio, una Disciplina.</h2>
        <div class="features-grid">
            
            <article class="feature-card">
                <img src="<?= base_url('imagenes/icono_guantes.svg') ?>" alt="Guantes de Boxeo" class="feature-icon">
                <h3>MMA Integral</h3>
                <p>Domina técnicas completas de grappling, striking y defensa personal. Desarrolla disciplina, resistencia y poder.</p>
            </article>

            <article class="feature-card">
                <img src="<?= base_url('imagenes/icono_pesa.svg') ?>" alt="Acondicionamiento Físico" class="feature-icon">
                <h3>Acondicionamiento Funcional</h3>
                <p>Entrenamientos de alta intensidad diseñados para mejorar tu rendimiento diario, resistencia cardiovascular y fuerza explosiva.</p>
            </article>

            <article class="feature-card">
                <img src="<?= base_url('imagenes/icono_medalla.svg') ?>" alt="Medalla" class="feature-icon">
                <h3>Coaches Certificados</h3>
                <p>Aprende de profesionales con experiencia en competencias y *coaching*. Atención personalizada para tu progreso.</p>
            </article>

        </div>
    </section>

    <section class="cta-banner">
        <div class="cta-text">
            <h2>¿Nuevo en las Artes Marciales?</h2>
            <p>¡Prueba tu primera clase con nosotros! Descubre nuestras instalaciones sin compromiso. Contáctanos para reservar tu cupo.</p>
        </div>
        <a href="<?= base_url('/inicio/contacto') ?>" class="btn btn-cta">
            Reservar Clase ¡YA!
        </a>
    </section>

</main>

<?php echo $this->endSection();?>