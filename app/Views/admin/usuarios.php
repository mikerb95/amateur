<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <div class="page-header">
        <h1 class="title">Gestión de Usuarios</h1>
        <div class="header-actions">
            <a href="<?= base_url('admin/Crear_usuario'); ?>" class="btn-crear"><img src="<?= base_url('imagenes/adduser.svg') ?>" alt="G_usuarios" class="iconheader"> Crear Usuario</a>
            <a href="<?= base_url('pagos'); ?>" class="btn-crear"><img src="<?= base_url('imagenes/pay.svg') ?>" alt="G_usuarios" class="iconheader"> Gestión de Pagos</a>
            <a href="<?= base_url('exportar/excel-pagos'); ?>" class="btn-crear"><img src="<?= base_url('imagenes/export.svg') ?>" alt="G_usuarios" class="iconheader"> Exportar Excel</a>
        </div>
    </div>

    <!-- ======== ESTADÍSTICAS DE USUARIOS ======== -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/usuarios.svg') ?>" alt="G_usuarios" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count($usuarios) ?></h3>
                <p>Total Usuarios</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/OK.svg') ?>" alt="G_usuarios" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count(array_filter($usuarios, function($u) { return ($u['estado_pago'] ?? 'Pago Pendiente') == 'Pago Cancelado'; })) ?></h3>
                <p>Al Día en Pagos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/pendiente.svg') ?>" alt="G_usuarios" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count(array_filter($usuarios, function($u) { return ($u['estado_pago'] ?? 'Pago Pendiente') == 'Pago Pendiente'; })) ?></h3>
                <p>Pendientes de Pago</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/administrador.svg') ?>" alt="G_usuarios" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count(array_filter($usuarios, function($u) { return ($u['rol'] ?? 3) == 1; })) ?></h3>
                <p>Administradores</p>
            </div>
        </div>
    </div>

    <?php if (!empty($usuarios) && is_array($usuarios)): ?>
        <div class="table-improved-container">
            <table class="styled-table improved-table">
                <thead>
                    <tr>
                        <th><img src="<?= base_url('imagenes/number.svg') ?>" alt="G_usuarios" class="iconnn"></th>
                        <th>Usuario</th>
                        <th>Información</th>
                        <th>Rol</th>
                        <th>Estado de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $index => $usuario): 
                        $estadoPago = $usuario['estado_pago'] ?? 'Pago Pendiente';
                        $rol = $usuario['rol'] ?? 3;
                        $plan = $usuario['plan'] ?? 'Sin plan';
                    ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td>
                                <div class="user-info">
                                    <strong><?= esc($usuario['nombre'] . ' ' . $usuario['apellido']) ?></strong>
                                    <br>
                                    <small class="text-muted">Cédula: <?= esc($usuario['cedula']) ?></small>
                                </div>
                            </td>
                            <td>
                                <div class="user-details">
                                    <?php if (isset($usuario['correo'])): ?>
                                        <div class="detail-item">
                                            <span class="detail-label"><img src="<?= base_url('imagenes/email.svg') ?>" alt="G_usuarios" class="detallesuser"></span>
                                            <span class="detail-value"><?= esc($usuario['correo']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($usuario['telefono'])): ?>
                                        <div class="detail-item">
                                            <span class="detail-label"><img src="<?= base_url('imagenes/telefono.svg') ?>" alt="G_usuarios" class="detallesuser"></span>
                                            <span class="detail-value"><?= esc($usuario['telefono']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="detail-item">
                                        <span class="detail-label"><img src="<?= base_url('imagenes/planuser.svg') ?>" alt="G_usuarios" class="detallesuser"></span>
                                        <span class="detail-value"><?= esc($plan) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="rol-badge rol-<?= $rol ?>">
                                    <?= $rol == 1 ? 'Administrador' : ($rol == 2 ? 'Instructor' : 'Usuario') ?>
                                </span>
                            </td>
                            <td>
                                <div class="pago-info">
                                    <span class="estado-pago <?= $estadoPago == 'Pago Cancelado' ? 'pagado' : 'pendiente' ?>">
                                        <?= $estadoPago == 'Pago Cancelado' ? '✅ PAGADO' : '❌ PENDIENTE' ?>
                                    </span>
                                    <br>
                                    <small class="text-muted"><?= $estadoPago ?></small>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('admin/editar_usuario/'.$usuario['id_usuario']); ?>" 
                                       class="btn-action btn-edit" title="Editar usuario">
                                       <img src="<?= base_url('imagenes/editarlogo.svg') ?>" alt="G_usuarios" class="detallesuser"> Editar
                                    </a>
                                    <a href="<?= base_url('admin/eliminar_usuario/'.$usuario['id_usuario']); ?>" 
                                       class="btn-action btn-delete" 
                                       onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                                       title="Eliminar usuario">
                                        <img src="<?= base_url('imagenes/delete.svg') ?>" alt="G_usuarios" class="detallesuser"> Eliminar
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
            <div class="no-data-icon"><img src="<?= base_url('imagenes/usuarios.svg') ?>" alt="G_usuarios" class="detallesuser"></div>
            <h3>No hay usuarios registrados</h3>
            <p>Comienza creando el primer usuario del sistema</p>
            <a href="<?= base_url('admin/Crear_usuario'); ?>" class="btn-crear">
               <img src="<?= base_url('imagenes/adduser.svg') ?>" alt="G_usuarios" class="detallesuser"> Crear Primer Usuario
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Incluir el CSS específico para usuarios -->
<link rel="stylesheet" href="<?= base_url('css/admin-usuarios.css') ?>">

<?= $this->include('templates/footer') ?>