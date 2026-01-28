<link rel="stylesheet" href="<?= base_url('css/login.css') ?>">

<body>
  <video autoplay muted id="video-fondo" preload="auto">
          </video>

<div class="container">
  <div class="logo">
    <a href="<?= base_url('/inicio') ?>"><img class="logo-encabezado" src="<?= base_url('imagenes/logo amateur.png') ?>" alt="Logo Club Amateur"  id="logo"></a>
  </div>

  <div class="inicio">
    <h1 id="Sesion">Iniciar Sesión</h1>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <form class="formulario" method="post" action="<?= base_url('login/acceder') ?>">

      <?= csrf_field() ?>

      <label for="username">Usuario:</label>
      <input type="text" id="username" name="username" placeholder="Ej: pepito perez" required>

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" placeholder="Ej: pepito11" required>

      <button type="submit" class="btn">Iniciar Sesión</button>

      <a class="olv-cont" href="<?= base_url('pagina/olvidarContr') ?>">¿Olvidaste tu contraseña?</a>
      <p class="divider">_____________________________________</p>

      <a class="btn" href="<?= site_url('pagina/registrar') ?>">Crear cuenta nueva</a>
    </form>
  </div>
</div>

<footer class="footer">
  <p>&copy; 2025 Club Amateur. Todos los derechos reservados.</p>
  <p><a href="<?= base_url('documentos/contrato.pdf') ?>" target="_blank" id="documento">
      <img class="reglasimg" src="<?= base_url('imagenes/Reglas.svg') ?>" alt="rules"> Reglas del Club</a></p>
  <p>Síguenos en nuestras redes:</p>
  <p>
    <a href="https://www.instagram.com/club__amateur/?utm_source=qr&igsh=MXRyb2M3cGpybXZreg%3D%3D#" target="_blank" class="redes">
        <img class="instagramimg" src="<?= base_url('imagenes/instagram.svg') ?>" alt="ig"> Instagram</a>
  </p>
</footer>

<script src="login.js"></script>
      <script>
          document.addEventListener('DOMContentLoaded', () => {
              const video = document.getElementById('video-fondo');
              
              const videoList = [
                  '<?= base_url('videos/entrenando.mp4') ?>',
                  '<?= base_url('videos/entrenando1.mp4') ?>',
                  '<?= base_url('videos/entrenando2.mp4') ?>' 
              ];

              let currentVideo = 0;

              function playNextVideo() {
                  currentVideo = (currentVideo + 1) % videoList.length;
                  
                  video.src = videoList[currentVideo];
                  
                  video.load();
                  video.play().catch(error => {
                      console.warn("Autoplay falló (común en navegadores móviles), esperando interacción.", error);
                  });
              }

              video.src = videoList[currentVideo];
              video.load();
              video.play().catch(error => {
                  console.warn("Autoplay inicial falló.", error);
              });

              video.addEventListener('ended', playNextVideo);
          });
      </script>
</body>
