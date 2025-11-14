<!-- app/Views/templates/menu_usuario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
<header class="menu-usuario">
    <nav>
        <ul>
            <li><a href="<?= base_url('dashboard_usuario') ?>">Inicio</a></li>
            <li><a href="<?= base_url('mis_clases') ?>">Mis Clases</a></li>
            <li><a href="<?= base_url('reservar') ?>">Reservar</a></li>
            <li><a href="<?= base_url('perfil') ?>">Perfil</a></li>
            <li><a href="<?= base_url('logout') ?>" class="logout-btn">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>
