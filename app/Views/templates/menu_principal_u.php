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

<header class="icon-menu"> 
    <nav>
        <ul>
            <li>
                <a href="<?= base_url('admin') ?>" class="icon-link">
                    <img src="<?= base_url('imagenes/inicio.svg') ?>" alt="Inicio">
                    <span class="tooltip">Inicio</span>
                </a>
            </li>
            
            <li>
                <a href="<?= base_url('admin/usuarios') ?>" class="icon-link">
                    <img src="<?= base_url('imagenes/gimnasia.png') ?>" alt="Usuarios">
                    <span class="tooltip">Usuarios</span>
                </a>
            </li>
            
            <li>
                <a href="<?= base_url('admin/clases') ?>" class="icon-link">
                    <img src="<?= base_url('imagenes/pesa.png') ?>" alt="Clases">
                    <span class="tooltip">Clases</span>
                </a>
            </li>
            
            <li>
                <a href="<?= base_url('admin/reservas') ?>" class="icon-link">
                    <img src="<?= base_url('imagenes/reserva.png') ?>" alt="Reservas">
                    <span class="tooltip">Reservas</span>
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