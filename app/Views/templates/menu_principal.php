<!-- app/Views/templates/menu_admin.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    
<div class="menu-principal">
    <ul>
        <li><a href="<?= base_url('admin') ?>">Inicio</a></li>
        <li><a href="<?= base_url('admin/usuarios') ?>">Usuarios</a></li>
        <li><a href="<?= base_url('admin/clases') ?>">Clases</a></li>
        <li><a href="<?= base_url('admin/reservas') ?>">Reservas</a></li>
        <li><a href="<?= base_url('logout') ?>">Cerrar sesión</a></li>
    </ul>
</div>

    
</body>
</html>