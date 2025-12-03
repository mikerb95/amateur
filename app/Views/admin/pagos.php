<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <div class="page-header">
        <h1 class="title">Gestión de Pagos</h1>
        <a href="<?= base_url('admin/usuarios') ?>" class="btn-back">
            <img src="<?= base_url('imagenes/back.svg') ?>" alt="G_pagos" class="back"> Volver a Usuarios
        </a>
    </div>

    <!-- ======== ESTADÍSTICAS RÁPIDAS ======== -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/usuarios.svg') ?>" alt="G_usuarios" class="iconos"></div>
            <div class="stat-info">
                <h3 id="total-usuarios">-</h3>
                <p>Total Usuarios</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/si.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3 id="pagos-cancelados">-</h3>
                <p>Al Día en Pagos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/no.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3 id="pagos-pendientes">-</h3>
                <p>Pendientes de Pago</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/estadistica.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3 id="porcentaje-pagos">-</h3>
                <p>% de Cumplimiento</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- ======== BÚSQUEDA DE USUARIO ======== -->
        <div class="card-section">
            <div class="card-header">
                <h3>🔍 Buscar Usuario</h3>
                <p>Busca un usuario por cédula para gestionar su estado de pago</p>
            </div>

            <?php if (!isset($usuario) || $usuario == null): ?>
                <form action="<?= base_url('pagos/buscar'); ?>" method="POST" class="search-form">
                    <div class="form-group">
                        <label for="cedula" class="form-label">
                            <span class="label-icon">🆔</span>
                            Cédula del Usuario *
                        </label>
                        <input type="text" name="cedula" id="cedula" class="form-input" 
                               placeholder="Ej: 1234567890" required>
                        <div class="form-hint">Ingresa el número de cédula del usuario</div>
                    </div>
                    <button type="submit" class="btn-submit">
                        <span class="btn-icon">🔍</span>
                        Buscar Usuario
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <!-- ======== GESTIÓN DE PAGOS ======== -->
        <?php if (isset($usuario) && $usuario != null): ?>
            <div class="card-section">
                <div class="card-header">
                    <h3>💰 Gestión de Pago</h3>
                    <p>Actualiza el estado de pago del usuario seleccionado</p>
                </div>

                <form action="<?= base_url('pagos/guardar'); ?>" method="POST" class="payment-form">
                    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

                    <!-- Información del Usuario -->
                    <div class="user-info-card">
                        <div class="user-avatar">
                            <?= strtoupper(substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1)) ?>
                        </div>
                        <div class="user-details">
                            <h4><?= esc($usuario['nombre'] . ' ' . $usuario['apellido']) ?></h4>
                            <div class="user-meta">
                                <span class="meta-item">
                                    <strong>🆔 Cédula:</strong> <?= esc($usuario['cedula']) ?>
                                </span>
                                <?php if (isset($usuario['correo'])): ?>
                                    <span class="meta-item">
                                        <strong>📧 Email:</strong> <?= esc($usuario['correo']) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (isset($usuario['telefono'])): ?>
                                    <span class="meta-item">
                                        <strong>📞 Teléfono:</strong> <?= esc($usuario['telefono']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de Pago -->
                    <div class="form-group">
                        <label for="estado" class="form-label">
                            <span class="label-icon">💳</span>
                            Estado de Pago *
                        </label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="Pago Pendiente" <?= isset($pago) && $pago['estado'] == 'Pago Pendiente' ? 'selected' : '' ?>>
                                ❌ Pago Pendiente
                            </option>
                            <option value="Pago Cancelado" <?= isset($pago) && $pago['estado'] == 'Pago Cancelado' ? 'selected' : '' ?>>
                                ✅ Pago Cancelado
                            </option>
                        </select>
                        <div class="form-hint">Selecciona el estado actual del pago del usuario</div>
                    </div>

                    <!-- Resumen del Estado -->
                    <div class="payment-summary">
                        <div class="summary-item <?= (isset($pago) && $pago['estado'] == 'Pago Cancelado') ? 'paid' : 'pending' ?>">
                            <div class="summary-icon">
                                <?= (isset($pago) && $pago['estado'] == 'Pago Cancelado') ? '✅' : '❌' ?>
                            </div>
                            <div class="summary-content">
                                <strong>Estado Actual:</strong>
                                <span><?= isset($pago) ? $pago['estado'] : 'Pago Pendiente' ?></span>
                            </div>
                        </div>
                        <?php if (isset($pago) && isset($pago['fecha_pago'])): ?>
                            <div class="summary-item">
                                <div class="summary-icon">📅</div>
                                <div class="summary-content">
                                    <strong>Última Actualización:</strong>
                                    <span><?= date('d/m/Y H:i', strtotime($pago['fecha_pago'])) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <span class="btn-icon">💾</span>
                            Guardar Estado de Pago
                        </button>
                        <a href="<?= base_url('pagos') ?>" class="btn-cancel">
                            <span class="btn-icon">↶</span>
                            Buscar Otro Usuario
                        </a>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- ======== INFORMACIÓN ADICIONAL ======== -->
        <div class="card-section">
            <div class="card-header">
                <h3>📋 Información de Pagos</h3>
                <p>Gestión y seguimiento de estados de pago</p>
            </div>
            
            <div class="info-cards">
                <div class="info-card">
                    <div class="info-icon">ℹ️</div>
                    <div class="info-content">
                        <h4>Estados de Pago</h4>
                        <ul>
                            <li><strong>Pago Cancelado:</strong> Usuario al día con sus pagos</li>
                            <li><strong>Pago Pendiente:</strong> Usuario con pagos pendientes</li>
                        </ul>
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">💡</div>
                    <div class="info-content">
                        <h4>Recomendaciones</h4>
                        <ul>
                            <li>Verifica la cédula antes de actualizar</li>
                            <li>Actualiza estados regularmente</li>
                            <li>Consulta reportes en "Exportar Excel"</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir el CSS específico para pagos -->
<link rel="stylesheet" href="<?= base_url('css/admin-pagos.css') ?>">

<script>
// Estadísticas simples (puedes reemplazar con datos reales del servidor)
document.addEventListener('DOMContentLoaded', function() {
    // Estos son datos de ejemplo - deberías obtenerlos de tu backend
    document.getElementById('total-usuarios').textContent = '47';
    document.getElementById('pagos-cancelados').textContent = '35';
    document.getElementById('pagos-pendientes').textContent = '12';
    document.getElementById('porcentaje-pagos').textContent = '75%';
});
</script>

<?= $this->include('templates/footer') ?>
