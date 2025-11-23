<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Club Amateur - Cambiar contraseña</title>

  <link rel="stylesheet" href="<?= base_url('css/Create_L.css') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('imagenes/logo-academia.jpg') ?>" />
</head>

<body>

<div class="container">

    <div class="logo">
        <img src="<?= base_url('imagenes/logitoo.png') ?>" alt="Logo">
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
  <p><a href="<?= base_url('documentos/contrato.pdf') ?>" target="_blank" id="documento">📄 Reglas del Club</a></p>
  <p>Síguenos en nuestras redes:</p>
  <p>
    <a href="https://www.instagram.com/club__amateur/?utm_source=qr&igsh=MXRyb2M3cGpybXZreg%3D%3D#" target="_blank" class="redes">Instagram</a>
  </p>
</footer>

</div>

</body>
</html>
