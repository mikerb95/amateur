<?= $this->include('templates/menu_principal'); ?>

<div class="main-content">
    <h1 class="title">Gestión de Clases</h1>

    <?php if (!empty($clases)): ?>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Día</th>
                        <th>Hora</th>
                        <th>Cupo Máximo</th>
                        <th>Cupos Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clases as $clase): ?>
                        <tr>
                           <td><?= esc($clase['id_clases']); ?></td>
                            <td><?= esc($clase['nombre']); ?></td>
                            <td><?= esc($clase['dia_semana']); ?></td>
                            <td><?= esc($clase['hora_inicio']) . ' - ' . esc($clase['hora_fin']); ?></td>
                            <td><?= esc($clase['cupo_maximo']); ?></td>
                            <td><?= esc($clase['cupo_disponible']); ?></td>
                            <td>
                            <div class="action-buttons">
                            <a href="<?= base_url('admin/editar_clase/'.$clase['id_clases']); ?>" class="btn-edit">Editar</a>
                            <a href="<?= base_url('admin/eliminar_clase/'.$clase['id_clases']); ?>"
                            class="btn-delete"
                            onclick="return confirm('¿Seguro que deseas eliminar esta clase?')">
                            Eliminar
                            </a>
                            </td>
                            </div>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="no-data">No hay clases registradas.</p>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer'); ?>
