<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Club Amateur - Cambiar contraseña</title>

  <link rel="stylesheet" href="<?= base_url('css/Create_L.css') ?>">
</head>

<body>
  <video autoplay muted id="video-fondo" preload="auto">
          </video>

<div class="container">

    <div class="logo">
        <a href="<?= base_url('/inicio') ?>">
          <img class="logo-encabezado" src="<?= base_url('imagenes/Logo blanco_Trans.png') ?>" alt="Logo Club Amateur">
        </a>
    </div>

    <div class="form-box">
      <h2>Restablecer Contraseña</h2>
      <p>Ingresa tu nueva contraseña.</p>

      <form action="<?= base_url('perfil/cambiar_contrasena') ?>" method="POST" class="styled-form">
        <input type="text" name="cedula" placeholder="Cédula de usuario" required>
        <input type="password" name="password" placeholder="Nueva contraseña" required>
        <input type="password" name="password_confirm" placeholder="Confirmar contraseña" required>

        <button type="submit" class="btn-register">Guardar cambios</button>
      </form>

      <div class="btn-cancel">
          <a href="<?= base_url('login') ?>">Cancelar</a>
      </div>
      <br>
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

<script src="olvidarcontrasena.js"></script>
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
