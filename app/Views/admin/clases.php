<?= $this->include('templates/menu_principal'); ?>

<div class="main-content">
    <h1 class="title">Gestión de Clases</h1>

    <form method="GET" action="<?= base_url('admin/clases'); ?>" style="margin-bottom: 20px;">
    <label for="dia">Filtrar por día:</label>
    <select name="dia" onchange="this.form.submit()">
        <option value="">Todos</option>
        <option value="Lunes" <?= ($diaSeleccionado == 'Lunes' ? 'selected' : '') ?>>Lunes</option>
        <option value="Martes" <?= ($diaSeleccionado == 'Martes' ? 'selected' : '') ?>>Martes</option>
        <option value="Miércoles" <?= ($diaSeleccionado == 'Miércoles' ? 'selected' : '') ?>>Miércoles</option>
        <option value="Jueves" <?= ($diaSeleccionado == 'Jueves' ? 'selected' : '') ?>>Jueves</option>
        <option value="Viernes" <?= ($diaSeleccionado == 'Viernes' ? 'selected' : '') ?>>Viernes</option>
        <option value="Sábado" <?= ($diaSeleccionado == 'Sábado' ? 'selected' : '') ?>>Sábado</option>
        <option value="Domingo" <?= ($diaSeleccionado == 'Domingo' ? 'selected' : '') ?>>Domingo</option>
    </select>
</form>


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
                        <th>Disponibilidad</th>
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
                                    <a href="<?= base_url('admin/toggle_disponibilidad/' . $clase['id_clases']); ?>"
                                       class="btn-disponibilidad"
                                       style="padding:6px 12px; border-radius:6px; color:white; text-decoration:none;
                                              background-color: <?= $clase['disponible'] ? '#28a745' : '#dc3545' ?>;">
                                        <?= $clase['disponible'] ? 'Disponible' : 'No disponible' ?>
                                    </a>
                                </div>
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
