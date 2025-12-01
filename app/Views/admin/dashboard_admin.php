<?= $this->include('templates/menu_admin') ?>

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

        <a href="<?= base_url('logout') ?>" class="card-link">
            <article class="card logout-card">
                <img src="<?= base_url('imagenes/logout.svg') ?>" alt="Cerrar sesión" class="icon"> 
                <h3>Cerrar Sesión</h3>
                <p>Finaliza la sesión actual de forma segura.</p>
                </article>
        </a>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
    </div>
</section>

<?= $this->include('templates/footer') ?>

