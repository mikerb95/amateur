<?= $this->include('templates/menu_principal'); ?>

<div class="main-content">
    <div class="page-header">
        <h1 class="title">Gestión de Reservas</h1>
        <div class="header-actions">
            <a href="<?= base_url('admin/clases') ?>" class="btn-crear">
                ← Volver a Clases
            </a>
        </div>
    </div>

    <!-- ======== ESTADÍSTICAS DE RESERVAS ======== -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-info">
                <h3><?= count($reservas) ?></h3>
                <p>Total Reservas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <h3><?= count(array_filter($reservas, function($r) { return $r['estado'] == 'Confirmada'; })) ?></h3>
                <p>Confirmadas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <h3><?= count(array_filter($reservas, function($r) { return $r['estado'] == 'Pendiente'; })) ?></h3>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-info">
                <h3><?= count(array_filter($reservas, function($r) { return $r['estado'] == 'Cancelada'; })) ?></h3>
                <p>Canceladas</p>
            </div>
        </div>
    </div>

    <?php if (!empty($reservas)): ?>
        <div class="table-improved-container">
            <table class="styled-table improved-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Clase</th>
                        <th>Fecha Reserva</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td class="text-center"><?= esc($reserva['id']) ?></td>
                            <td>
                                <div class="user-info">
                                    <strong><?= esc($reserva['usuario_nombre']) ?></strong>
                                    <?php if (isset($reserva['usuario_apellido'])): ?>
                                        <br><small><?= esc($reserva['usuario_apellido']) ?></small>
                                    <?php endif; ?>
                                    <?php if (isset($reserva['cedula'])): ?>
                                        <br><small class="text-muted">Cédula: <?= esc($reserva['cedula']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <strong><?= esc($reserva['clase_nombre']) ?></strong>
                            </td>
                            <td>
                                <div class="fecha-info">
                                    <?= date('d/m/Y', strtotime($reserva['fecha_reserva'])) ?>
                                    <br>
                                    <small class="text-muted">
                                        <?= date('H:i', strtotime($reserva['fecha_reserva'])) ?>
                                    </small>
                                </div>
                            </td>
                            <td>
                                <span class="estado-reserva <?= strtolower($reserva['estado']) ?>">
                                    <?= esc($reserva['estado']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('admin/editar_reserva/' . $reserva['id']) ?>" 
                                       class="btn-action btn-edit" title="Editar reserva">
                                        ✏️
                                    </a>
                                    <a href="<?= base_url('admin/eliminar_reserva/' . $reserva['id']) ?>" 
                                       class="btn-action btn-delete" 
                                       onclick="return confirm('¿Eliminar esta reserva?')"
                                       title="Eliminar reserva">
                                        🗑️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="no-data-improved">
            <div class="no-data-icon">📋</div>
            <h3>No hay reservas registradas</h3>
            <p>Todavía no se han realizado reservas en el sistema</p>
        </div>
    <?php endif; ?>
</div>

<!-- Incluir el CSS de reservas -->
<link rel="stylesheet" href="<?= base_url('css/admin-reservas.css') ?>">

<?= $this->include('templates/footer'); ?>