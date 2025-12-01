<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Club Amateur - Crea una cuenta</title>

  <link rel="stylesheet" href="<?= base_url('css/Create_L.css') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('imagenes/logo-academia.jpg') ?>" />
</head>

<body>
  <video autoplay muted id="video-fondo" preload="auto">
          </video>
          
  <div class="container">
  <div class="logo">
    <a href="<?= base_url('/inicio') ?>"><img class="logo-encabezado" src="<?= base_url('imagenes/Logo blanco_Trans.png') ?>" alt="Logo Club Amateur"  id="logo"></a>
  </div>

    <div class="form-box">
      <h2>Crea una cuenta</h2>
      <p>Es rápido y fácil.</p>

      <form action="<?= base_url('pagina/registrar') ?>" method="POST">
        

        <div class="name-fields">
          <input type="text" name="nombre" placeholder="Nombre" required>
          <input type="text" name="apellido" placeholder="Apellido" required>
        </div>

        <label class="label">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" required>

        <label class="label">Género</label>
        <div class="gender-fields">
          <label><input type="radio" name="genero" value="Mujer" required> Mujer</label>
          <label><input type="radio" name="genero" value="Hombre" required> Hombre</label>
          <label><input type="radio" name="genero" value="Personalizado" required> Personalizado</label>
        </div>

        <input type="text" name="cedula" placeholder="Cédula" required>
        <input type="text" name="telefono" placeholder="Número de celular" required>
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña nueva" required>

        <button type="submit" class="btn-register">Registrarte</button>

        <div class="login-link">
          <a href="<?= base_url('login') ?>">¿Ya tienes una cuenta?</a>
        </div>
      </form>

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

<script src="registrar.js"></script>
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
