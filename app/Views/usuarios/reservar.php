<?= $this->include('templates/menu_principal_u') ?>
<link rel="stylesheet" href="<?= base_url('css/reservas.css') ?>">
<script src="<?= base_url('js/reservas.js') ?>"></script>



<div class="main-content">
    <div class="profile-info">
    <h1 class="title">Reservar Nueva Clase</h1>

<div class="days-nav">
    <button class="day active" data-day="lunes">Lunes</button>
    <button class="day" data-day="martes">Martes</button>
    <button class="day" data-day="miércoles">Miércoles</button>
    <button class="day" data-day="jueves">Jueves</button>
    <button class="day" data-day="viernes">Viernes</button>
    <button class="day" data-day="sábado">Sábado</button>
</div>
<div class="class-cards">

    <?php if (!empty($clases)) : ?>
        <?php foreach ($clases as $clase) : ?>

            <div class="class-card" data-day="<?= strtolower(esc($clase['dia_semana'])) ?>">
                <h3><?= esc($clase['nombre']) ?></h3>

                <p class="coach">
                    Entrenador: <?= esc($clase['id_rol']) ?>
                </p>

                <p class="time">
                    <?= esc($clase['dia_semana']) ?> -
                    <?= date('d-m-Y', strtotime($clase['fecha_clase'])) ?> /
                    <?= date('h:i A', strtotime($clase['hora_inicio'])) ?> –
                    <?= date('h:i A', strtotime($clase['hora_fin'])) ?>
                </p>


                <p class="room">
                    Sala: <?= esc($clase['id_planes']) ?>
                </p>

                <form action="<?= base_url('usuarios/hacer_reserva/' . $clase['id_clases']) ?>" method="post">
                    <button class="btn-reservar">Reservar</button>
                </form>

            </div>

        <?php endforeach; ?>
    <?php else : ?>

        <p>No hay clases disponibles actualmente.</p>

    <?php endif; ?>

</div>
</div>
</div>


