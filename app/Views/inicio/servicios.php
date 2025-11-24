<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>

<section id="servicios" class="programas-section">
  <div class="container">
    <h2>Nuestros Programas</h2>
    <p class="intro">Manejamos entrenamientos dirigidos teniendo en cuenta las 
      necesidades de nuestros usuarios, ¡entre estos encontrarás!</p>

    <div class="programa-bloque" align="center">
      <div class="programa-img">
        <img src="<?= base_url('imagenes/boxeo1.jpg') ?>" alt="Fuerza y pesas">
      </div>
      <div class="programa-info">
        <h3>Trabajo de fuerza y pesas</h3>
        <p>Entrenamiento integral que combina ejercicios de fuerza, 
          resistencia y movilidad para mejorar el rendimiento físico general.</p>
        <p>Los beneficios incluyen:</p>
        <ul>
          <li>Mejora de la fuerza y resistencia muscular</li>
          <li>Incremento de la masa muscular</li>
          <li>Mejora de la salud ósea y articular</li>
          <li>Mejora del metabolismo y quema de grasa</li>
          <li>Reducción del riesgo de lesiones</li>
        </ul>
      </div>
    </div>

    <div class="programa-bloque reverse" align="center">
      <div class="programa-img">
        <img src="<?= base_url('imagenes/boxeofemenino.jpg') ?>" alt="MMA">
      </div>
      <div class="programa-info">
        <h3>MMA</h3>
        <p>Aunque muchas personas asocian el MMA con competencias de alto nivel como la UFC, el entrenamiento es accesible para
          personas de diferentes edades y niveles, y no necesariamente implica participar en peleas profesionales.</p>
        <p>Los beneficios del entrenamiento de MMA incluyen:</p>
          <ul>
            <li>Mejora tu condición física</li>
            <li>Desarrolla habilidades de autodefensa</li>
            <li>Fomenta la disciplina y el autocontrol</li>
            <li>Mejora coordinación, equilibrio y reflejos</li>
            <li>Reducción de estrés y mejora emocional</li>
          </ul>          
      </div>
    </div>

    <div class="programa-bloque" align="center">
      <div class="programa-img">
        <img src="<?= base_url('imagenes/acondicionamientofisico.jpg') ?>" alt="Trabajo funcional">
      </div>
      <div class="programa-info">
        <h3>Trabajo funcional</h3>
        <p>Entrenamiento que mejora la fuerza, equilibrio y flexibilidad a través de movimientos naturales.</p>
        <p>Los beneficios incluyen:</p>
        <ul>
          <li>Mejora de rendimiento deportivo</li>
          <li>Adaptable a todos los niveles</li>
          <li>Mejora de la movilidad y flexibilidad</li>
          <li>Reducción del riesgo de lesiones</li>
          <li>Mejora del equilibrio y coordinación</li>
        </ul>        
      </div>
    </div>
  </div>
</section>

  <?php echo $this->endSection();?>

