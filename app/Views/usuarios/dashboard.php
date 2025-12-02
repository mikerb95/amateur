<?= $this->include('templates/menu_usuario') ?>

</body>
</html>
<section class="dashboard">
    <h1>Bienvenido</h1>

    <div class="cards">
        
        <a href="<?= base_url('usuarios/mis_clases') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/boxeo.png') ?>" alt="Mis Clases" class="icon">
                <h3>Clases Programadas</h3>
                <p>Tienes <?= esc($clasesActivas ?? 0) ?> clases activas.</p>
            </article>
        </a>

        <a href="<?= base_url('usuarios/reservar') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/reserva1.png') ?>" alt="Mis Reservas" class="icon">
                <h3>Reservar Nueva Clase</h3>
                <p>Consulta los horarios disponibles y agenda tu próxima clase.</p>
            </article>
        </a>

        <a href="<?= base_url('usuarios/perfil') ?>" class="card-link">
            <article class="card">
                <img src="<?= base_url('imagenes/perfil.png') ?>" alt="Gestión de Reservas" class="icon">
                <h3>Perfil</h3>
                <p>Actualiza tus datos personales y de contacto.</p>
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
