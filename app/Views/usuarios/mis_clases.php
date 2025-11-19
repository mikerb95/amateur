<?= $this->include('templates/menu_principal_u') ?>
<link rel="stylesheet" href="<?= base_url('css/reservas.css') ?>">

<div class="main-content">
    <div class="profile-info">

        <h1 class="title">Mis Clases Reservadas</h1>
        <?php if (!empty($clases)) : ?>

            <?php foreach ($clases as $clase) : ?>

                <div class="class-card">
                    <h3><?= esc($clase['nombre']) ?></h3>

                    <p class="coach">
                        Entrenador: <?= esc($clase['id_rol']) ?>
                    </p>

                    <p class="time">
                        <?= esc($clase['dia_semana']) ?> /
                        <?= date('h:i A', strtotime($clase['hora_inicio'])) ?> –
                        <?= date('h:i A', strtotime($clase['hora_fin'])) ?>
                    </p>

                    <p class="room">
                        Sala: <?= esc($clase['id_planes']) ?>
                    </p>
                    <form action="<?= base_url('usuarios/cancelar_reserva/' . $clase['id_reservas']) ?>" method="post">
                        <button class="btn-reservar" 
                            style="background:#b30000; margin-top:10px;">
                            Cancelar Reserva
                        </button>
                    </form>
                </div>

            <?php endforeach; ?>

                    <?php if (session()->getFlashdata('mensaje')) : ?>
    <p style="color:#b00; font-weight:bold;">
        <?= session()->getFlashdata('mensaje') ?>
    </p>
<?php endif; ?>

        <?php else : ?>
            <p>No tienes clases reservadas aún.</p>
        <?php endif; ?>

    </div>
</div>
