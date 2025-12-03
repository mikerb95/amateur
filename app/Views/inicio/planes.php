<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>
<link rel="stylesheet" href="<?= base_url('css/planes.css') ?>">

<main class="planes-main">
    <section id="planes" class="planes-section">
        <div class="planes-header">
            <h1 class="page-title">Planes y Tarifas Club Amateur 2025</h1>
            <p class="intro">Elige el plan que mejor se adapte a tus objetivos, ya sea individual, para pareja o en grupo. ¡Encuentra el valor que se ajusta a tus metas y economía!</p>
        </div>
        
        <div class="pricing-grid">
            
            <article class="plan-card">
                <header class="plan-header">
                    <h2 class="plan-title">PLAN INDIVIDUAL</h2>
                    <p class="plan-price">$200.000 / 20 Clases</p>
                    <p class="plan-focus">Máxima flexibilidad y enfoque personal</p>
                </header>
                <div class="plan-features">
                    <ul>
                        <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> PRUEBA 1 DÍA: $25.000</li>
                        <li><img src="<?= base_url('imagenes/no.svg') ?>" alt="Check" class="feature-icon"> 12 Clases por $120.000</li>
                        <li><img src="<?= base_url('imagenes/no.svg') ?>" alt="Check" class="feature-icon"> 16 Clases por $160.000</li>
                        <li><img src="<?= base_url('imagenes/no.svg') ?>" alt="Check" class="feature-icon"> 20 Clases por $200.000</li>
                    </ul>
                </div>
                <a href="<?= base_url('/inicio/contacto') ?>" class="btn btn-plan-select">¡PRUEBA YA!</a>
            </article>

            <article class="plan-card">
                <header class="plan-header">
                    <h2 class="plan-title">PLAN PAREJA</h2>
                    <p class="plan-price">$360.000 / 20 Clases</p>
                    <p class="plan-focus">Entrena con tu compañero(a) y ahorra</p>
                </header>
                <div class="plan-features">
                    <ul>
                         <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> PRUEBA 1 DÍA: $40.000</li>
                        <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> 12 Clases por $210.000</li>
                        <li><img src="<?= base_url('imagenes/no.svg') ?>" alt="Check" class="feature-icon"> 16 Clases por $288.000</li>
                        <li><img src="<?= base_url('imagenes/no.svg') ?>" alt="Check" class="feature-icon"> 20 Clases por $360.000</li>
                    </ul>
                </div>
                <a href="<?= base_url('/inicio/contacto') ?>" class="btn btn-plan-select">¡COMPRA YA!</a>
            </article>
            
            <article class="plan-card">
                <header class="plan-header">
                    <h2 class="plan-title">PLAN 4 PERSONAS</h2>
                    <p class="plan-price">$640.000 / 20 Clases</p>
                    <p class="plan-focus">Máximo ahorro para el entrenamiento en grupo</p>
                </header>
                <div class="plan-features">
                    <ul>
                        <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> PRUEBA 1 DÍA: $60.000</li>
                        <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> 12 Clases por $400.000</li>
                        <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> 16 Clases por $540.000</li>
                        <li><img src="<?= base_url('imagenes/si.svg') ?>" alt="Check" class="feature-icon"> 20 Clases por $640.000</li>
                    </ul>
                </div>
                <a href="<?= base_url('/inicio/contacto') ?>" class="btn btn-plan-select">¡COMPRA YA!</a>
            </article>

        </div>
        
        <div class="horarios-section">
            <h2 class="section-subtitle">Horarios y Disponibilidad</h2>
            <div class="horarios-wrapper">
                <div class="imagen-zoom-container">
                    <img src="<?= base_url('imagenes/horarios3.jpeg') ?>" alt="Horarios de Clase" class="imagen-zoomable">
                </div>
            </div>
            <p class="horarios-note">Haz clic en la imagen para ampliar el detalle de horarios.</p>
        </div>
        
    </section>

    <div id="overlay" class="overlay">
        <img id="imagen-ampliada" src="" alt="Imagen ampliada">
    </div>

</main>
<?php echo $this->endSection();?>
