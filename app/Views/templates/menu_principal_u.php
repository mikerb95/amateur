<!-- app/Views/templates/menu_usuario.php -->
<?php 
    $uri = service('uri');
    $segment = $uri->getSegment(2); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>

<header class="icon-menu"> 
    <nav>
        <ul>

            <li>
                <a href="<?= base_url('usuarios') ?>" 
                   class="icon-link <?= ($segment == '' ? 'active' : '') ?>">
                    <img src="<?= base_url('imagenes/inicio.svg') ?>" alt="Inicio">
                    <span class="tooltip">Inicio</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('usuarios/mis_clases') ?>" 
                   class="icon-link <?= ($segment == 'mis_clases' ? 'active' : '') ?>">
                    <img src="<?= base_url('imagenes/boxeo.png') ?>" alt="Mis Clases">
                    <span class="tooltip">Mis Clases</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('usuarios/reservar') ?>" 
                   class="icon-link <?= ($segment == 'reservar' ? 'active' : '') ?>">
                    <img src="<?= base_url('imagenes/reserva.png') ?>" alt="Reservar">
                    <span class="tooltip">Reservar</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('usuarios/perfil') ?>" 
                   class="icon-link <?= ($segment == 'perfil' ? 'active' : '') ?>">
                    <img src="<?= base_url('imagenes/perfil.png') ?>" alt="Perfil">
                    <span class="tooltip">Perfil</span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('logout') ?>" class="icon-link logout-link">
                    <img src="<?= base_url('imagenes/logout.svg') ?>" alt="Salir">
                    <span class="tooltip">Cerrar sesión</span>
                </a>
            </li>

        </ul>
    </nav>
</header>

</body>
</html>
