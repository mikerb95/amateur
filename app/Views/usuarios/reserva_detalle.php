<?= $this->include('templates/menu_principal_u') ?>
<link rel="stylesheet" href="<?= base_url('css/reservas.css') ?>">

<div class="main-content">
    <div class="profile-info">

        <h1 class="title">Reserva realizada</h1>

        <div class="class-card">
            <h3><?= esc($clase['nombre']) ?></h3>

            <p class="coach">
                Entrenador: <?= esc($clase['id_rol']) ?> <!-- luego pondremos el nombre -->
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

            <button class="btn-reservar"
                    onclick="window.location='<?= base_url('usuarios/reservar') ?>'">
                Reservar otra clase
            </button>

            <button class="btn-reservar"
                    style="margin-left:10px; background:#555;"
                    onclick="window.location='<?= base_url('usuarios/mis_clases') ?>'">
                Ver mis clases
            </button>
        </div>

    </div>
</div>
