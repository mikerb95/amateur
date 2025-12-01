<?php echo $this->extend('plantilla/layout');?>
<?php echo $this->section('contenido');?>

<section id="quienes_somos" class="centrado" data-aos="fade-up">
  <h2>Quiénes Somos</h2>
  <p>Somos un Club de entrenamiento netamente dirigido, enfocado en salud. Utilizamos entrenamientos de contacto como Artes Marciales Mixtas y Fortalecimiento Muscular. Nos apasiona guiar y mejorar la calidad de vida de nuestros usuarios, logrando que mejoren su confianza, mentalidad, enfoque y físico que se requiere para hacer grandes personas y/o deportistas</p>
  <div class="mision-vision">
    <div class="mision quienes-bloque">
      <h3>Misión</h3>
      <p>Brindar formación integral y consciente a través del entrenamiento dirigido utilizando deportes de contacto como las artes marciales mixtas, y el entrenamiento de fuerza, logrando mantener la disciplina, constancia, enfoque y respeto por los demás.</p>
    </div>
    <div class="vision quienes-bloque">
      <h3>Visión</h3>
      <p>Ser uno de los mejores clubes de entrenamiento dirigido, ya sean en trabajos de salud como tambien los deportes de contacto como lo son las artes marciales mixtas, para asi promover el ejercicio y deporte como herramienta de transformacion personal y social.</p>
    </div>
  </div>
<div class="slider-wrapper">
  <div class="slider-contenedor">
    <img src="<?= base_url('imagenes/referencia1.jpg'); ?>" alt="Referencia 1" class="slider-img activa">
    <img src="<?= base_url('imagenes/bjj.jpg'); ?>" alt="Referencia 2" class="slider-img">
    <img src="<?= base_url('imagenes/referencia3.jpg'); ?>" alt="Referencia 3" class="slider-img">
  </div>
</div>
</section>

  <?php echo $this->endSection();?>



