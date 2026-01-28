<?= $this->include('templates/menu_admin') ?> 

<!-- ✅ Logout FIXED (forzado inline) -->
<div style="position:fixed; top:85px; right:22px; z-index:99999;">
    <a href="<?= base_url('logout') ?>"
       title="Cerrar sesión"
       style="
            width:44px; height:44px;
            display:flex; align-items:center; justify-content:center;
            background:#7a1fc5; border-radius:999px;
            box-shadow:0 6px 16px rgba(0,0,0,0.18);
            text-decoration:none;
       ">
        <img src="<?= base_url('imagenes/logout.svg') ?>" alt=""
             style="width:18px; height:18px; display:block; filter:brightness(0) invert(1);">
    </a>
</div>

<section class="dashboard">
    <h1>Panel de Administración</h1>

    <div class="cards">
        <a href="<?= base_url('admin/usuarios') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/gimnasia.png') ?>" alt="Gestión de Usuarios" class="icon">
                <h3>Gestión de Usuarios</h3>
                <p>Administra los usuarios registrados y sus perfiles.</p>
            </article>
        </a>

        <a href="<?= base_url('admin/clases') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/pesa.png') ?>" alt="Gestión de Clases" class="icon">
                <h3>Gestión de Clases</h3>
                <p>Modifica horarios, controla cupos y gestiona asistencia.</p>
            </article>
        </a>

        <a href="<?= base_url('admin/reservas') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/reserva.png') ?>" alt="Gestión de Reservas" class="icon">
                <h3>Reservas</h3>
                <p>Consulta las reservas realizadas por los usuarios.</p>
            </article>
        </a>

        <a href="<?= base_url('admin/asignar_plan') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/paquetes 2.png') ?>" alt="Gestión de Planes" class="icon">
                <h3>Gestión de Planes</h3>
                <p>Busca usuarios por cédula y asigna, edita o elimina paquetes.</p>
            </article>
        </a>
    </div>
</section>

<?= $this->include('templates/footer') ?>
