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
  <div class="container">
    <h1 class="logo">
      <img src="<?= base_url('imagenes/logitoo.png') ?>"/> Amateur Time Club
    </h1>

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
  </div>
</body>
</html>
