<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>

<section id="planes" class="center">
  <h2>Planes y Horarios</h2>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-start; gap: 40px; margin-top: 24px; text-align: center;">
    <div style="flex: 1 1 320px; min-width: 280px; max-width: 400px; margin: 0 auto;">
  <p>Conoce nuestros planes individuales, para pareja o grupal de maximo 4 personas! Están diseñados para ayudarte en tiempo y
        economía, elije el mejor que se adapte a tus necesidades y objetivos.</p>
  <p>Los planes incluyen:</p>
      <ul style="display: block; text-align: left; font-size: 1.1em; margin-bottom: 24px; text-align: center;">
        <ul><strong>PLAN BASICO:</strong> 12 clases al mes </ul>
          <li>Entrenamientos regulares de MMA, boxeo y acondicionamiento.</li>
          <li>Ideal para quienes se inician en artes marciales mixtas.</li>
        <ul><strong>PLAN INTERMEDIO:</strong> 16 clases al mes</ul>
         <li>Mayor intensidad y perfeccionamiento técnico.</li>
         <li>Seguimiento básico de tu progreso físico.</li>
        <ul><strong>PLAN AVANZADO:</strong> 20 clases al mes </ul>
          <li>Entrenamiento completo con técnicas avanzadas.</li>
          <li>Sparring supervisado y preparación para torneos.</li>
      </ul>  
  </div>

  <div class="imagen-zoom-container" style="max-width:420px;margin:0 auto;">
    <img src="<?= base_url('imagenes/horarios3.jpeg') ?>" alt="Horarios" class="imagen-zoomable">
  </div>
</div>

</section>

<div id="overlay" class="overlay">
  <img id="imagen-ampliada" src="" alt="Imagen ampliada">
</div>

  <?php echo $this->endSection();?>

