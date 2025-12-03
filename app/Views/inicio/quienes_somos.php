<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>
<link rel="stylesheet" href="<?= base_url('css/quienes_somos.css') ?>">

<main class="quienes-main">
    
    <section id="quienes_somos" class="intro-section" data-aos="fade-up">
        <h1 class="page-title">Quiénes Somos</h1>
        
        <div class="intro-box">
            <p>Somos un Club de entrenamiento netamente dirigido, enfocado en salud. Utilizamos entrenamientos de contacto como Artes Marciales Mixtas y Fortalecimiento Muscular.</p>
            <p class="impact-text">Nos apasiona guiar y mejorar la calidad de vida de nuestros usuarios, logrando que mejoren su confianza, mentalidad, enfoque y físico que se requiere para hacer grandes personas y/o deportistas.</p>
        </div>

        <div class="mision-vision">
            <div class="mision quienes-bloque">
                <img src="<?= base_url('imagenes/mision.svg') ?>" alt="Misión" class="bloque-icon">
                <h3>Misión</h3>
                <p>Brindar formación integral y consciente a través del entrenamiento dirigido utilizando deportes de contacto como las artes marciales mixtas, y el entrenamiento de fuerza, logrando mantener la disciplina, constancia, enfoque y respeto por los demás.</p>
            </div>
            <div class="vision quienes-bloque">
                <img src="<?= base_url('imagenes/vision.svg') ?>" alt="Visión" class="bloque-icon">
                <h3>Visión</h3>
                <p>Ser uno de los mejores clubes de entrenamiento dirigido, ya sean en trabajos de salud como también los deportes de contacto como lo son las artes marciales mixtas, para así promover el ejercicio y deporte como herramienta de transformación personal y social.</p>
            </div>
        </div>
    </section>
    
    <section class="team-section">
        <h2>Nuestros Pilares</h2>
        <div class="team-grid">
            <article class="team-card">
                <img src="<?= base_url('imagenes/IMG2.png') ?>" alt="Coach 1" class="team-img">
                <h4>Entrenadores Certificados</h4>
                <p>Años de experiencia en competencias y coaching. Comprometidos con tu progreso y técnica segura.</p>
            </article>
            <article class="team-card">
                <img src="<?= base_url('imagenes/grupo2.jpg') ?>" alt="Disciplina" class="team-img">
                <h4>Disciplina y Respeto</h4>
                <p>Fomentamos un ambiente de camaradería donde la disciplina es la base para alcanzar cualquier meta.</p>
            </article>
            <article class="team-card">
                <img src="<?= base_url('imagenes/referencia_3.jpg') ?>" alt="Comunidad" class="team-img">
                <h4>Comunidad Amateur</h4>
                <p>Más que un gimnasio, somos una familia. Entrena con apoyo, motivación y compañerismo constante.</p>
            </article>
        </div>
    </section>

    <section class="slider-section">
        <h2>Conoce Nuestras Instalaciones</h2>
        <div class="slider-wrapper">
            <div class="slider-contenedor">
                <img src="<?= base_url('imagenes/referencia.jpg'); ?>" alt="Zona de Tatami" class="slider-img activa">
                <img src="<?= base_url('imagenes/referencia_3.jpg'); ?>" alt="Zona de Pesas" class="slider-img">
                <img src="<?= base_url('imagenes/grupo3.jpg'); ?>" alt="Zona de Saco" class="slider-img">
            </div>
        </div>
    </section>

</main>

<?php echo $this->endSection();?>


