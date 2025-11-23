<?= $this->include('templates/menu_usuario') ?>

<section class="dashboard">
    <h2>Bienvenido</h2>

    <div class="cards">
        <div class="card">
            <img src="<?= base_url('imagenes/boxeo.png') ?>" alt="Clases Programadas" class="icon">
            <h3>Clases Programadas</h3>
            <p>Tienes <?= esc($clasesActivas ?? 0) ?> clases activas.</p>
            <a href="<?= base_url('usuarios/mis_clases') ?>" class="btn">Ver mis clases</a>
        </div>

        <div class="card">
            <img src="<?= base_url('imagenes/reserva1.png') ?>" alt="Reservar Nueva Clase" class="icon">
            <h3>Reservar Nueva Clase</h3>
            <p>Consulta los horarios disponibles y agenda tu próxima clase.</p>
            <a href="<?= base_url('usuarios/reservar') ?>" class="btn">Reservar</a>
        </div>

        <div class="card">
            <img src="<?= base_url('imagenes/perfil.png') ?>" alt="Perfil" class="icon">
            <h3>Perfil</h3>
            <p>Actualiza tus datos personales y de contacto.</p>
            <a href="<?= base_url('usuarios/perfil') ?>" class="btn">Ver Perfil</a>
        </div>
    </div>
</section>

<?= $this->include('templates/footer') ?>
