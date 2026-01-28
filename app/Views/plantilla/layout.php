<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->renderSection('titulo') ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="<?= base_url('css/estilos.css') ?>">
  <?= $this->renderSection('css') ?>

</head>

<body>
  <?php echo $this->include('plantilla/header') ?>

  <main>
    <?php echo $this->renderSection('contenido') ?>
  </main>

  <?php echo $this->include('plantilla/footer') ?>

  <script src="<?= base_url('js/main.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>AOS.init();</script>
</body>
</html>

