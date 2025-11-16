<?= $this->include('templates/menu_principal'); ?>

<div class="main-content">
    <h1 class="title">Gestión de Reservas</h1>

    <?php if (!empty($reservas)): ?>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Clase</th>
                        <th>Fecha de Reserva</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= esc($reserva['id']); ?></td>
                            <td><?= esc($reserva['usuario_nombre']); ?></td>
                            <td><?= esc($reserva['clase_nombre']); ?></td>
                            <td><?= esc($reserva['fecha_reserva']); ?></td>
                            <td><?= esc($reserva['estado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="no-data">No hay reservas registradas.</p>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer'); ?>
