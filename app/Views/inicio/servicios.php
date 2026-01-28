<?php echo $this->extend('plantilla/layout');?>

<?php echo $this->section('css'); ?>
<link rel="stylesheet" href="<?= base_url('css/programas.css?v=99') ?>">
<?php echo $this->endSection(); ?>

<?php echo $this->section('contenido');?>

<section id="servicios" class="programas-section">
    <div class="container">
        <h2>Nuestros Servicios</h2>
        <p class="intro">
            Entrenamientos guiados según tus objetivos: mejorar tu condición, ganar fuerza o aprender combate.
            Aquí encontrarás nuestras 3 líneas principales:
        </p>

        <!-- 1) Entrenamiento físico integral -->
        <div class="programa-bloque">
            <div class="programa-img">
                <img src="<?= base_url('imagenes/IMG5.jpeg') ?>" alt="Entrenamiento físico integral">
            </div>
            <div class="programa-info">
                <h3>Entrenamiento físico integral</h3>
                <p>
                    Combina <b>acondicionamiento físico</b> y <b>entrenamiento funcional</b> para mejorar tu rendimiento general,
                    capacidad cardiovascular, movilidad y coordinación.
                </p>
                <p>Ideal si buscas:</p>
                <ul>
                    <li>Mejorar tu resistencia y energía diaria</li>
                    <li>Ganar movilidad, equilibrio y coordinación</li>
                    <li>Aumentar tu capacidad física con ejercicios dinámicos</li>
                    <li>Prevenir lesiones con movimientos naturales</li>
                    <li>Un entrenamiento adaptable a tu nivel</li>
                </ul>
            </div>
        </div>

        <!-- 2) Fuerza y composición corporal -->
        <div class="programa-bloque reverse">
            <div class="programa-img">
                <img src="<?= base_url('imagenes/fuerza.jpeg') ?>" alt="Fuerza y composición corporal">
            </div>
            <div class="programa-info"> 
                <h3>Fuerza y composición corporal</h3>
                <p>
                    Enfocado en <b>fuerza resistencia</b> y <b>tonicidad muscular</b>.
                    Trabajamos con rutinas estructuradas para fortalecer, definir y mejorar tu rendimiento muscular.
                </p>
                <p>Los beneficios incluyen:</p>
                <ul>
                    <li>Mejora de fuerza y resistencia muscular</li>
                    <li>Mayor tonicidad y definición</li>
                    <li>Mejor postura y estabilidad articular</li>
                    <li>Impulso del metabolismo y quema de grasa</li>
                    <li>Reducción del riesgo de lesiones</li>
                </ul>
            </div>
        </div>

        <!-- 3) Combate y alto rendimiento -->
        <div class="programa-bloque">
            <div class="programa-img">
                <img src="<?= base_url('imagenes/IMG4.jpeg') ?>" alt="Combate y alto rendimiento">
            </div>
            <div class="programa-info">
                <h3>Combate y alto rendimiento (MMA)</h3>
                <p>
                    Entrenamiento de <b>MMA</b> accesible para diferentes edades y niveles.
                    No necesitas competir: puedes entrenar para mejorar condición, técnica y autodefensa.
                </p>
                <p>Los beneficios del entrenamiento incluyen:</p>
                <ul>
                    <li>Mejora tu condición física y cardio</li>
                    <li>Desarrolla habilidades de autodefensa</li>
                    <li>Fomenta disciplina y autocontrol</li>
                    <li>Mejora coordinación, equilibrio y reflejos</li>
                    <li>Reduce estrés y mejora el enfoque</li>
                </ul>
            </div>
        </div>

    </div>
</section>

<?php echo $this->endSection();?>
