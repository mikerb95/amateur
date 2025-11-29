<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <h1 class="title">Usuarios Registrados</h1>

    <?php if (!empty($usuarios) && is_array($usuarios)): ?>
        <div>
           <a href="<?= base_url('admin/Crear_usuario'); ?>" class="btn-crear">Crear usuario</a>
           <a href="<?= base_url('pagos'); ?>" class="btn-crear">Pagos</a>
            <a href="<?= base_url('exportar/excel-pagos'); ?>" class="btn-crear">Exportar Excel</a>
           <br><br>
        </div>

        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cédula</th>
                        <th>Estado de pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuarios as $index => $usuario): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($usuario['nombre']) ?></td>
                            <td><?= esc($usuario['apellido']) ?></td>
                            <td><?= esc($usuario['cedula']) ?></td>

                            <!-- 📌 ESTADO DE PAGO CORREGIDO -->
                            <td>
                                <?php 
                                $estadoPago = $usuario['estado_pago'] ?? 'Pago Pendiente';
                                if ($estadoPago == 'Pago Cancelado'): ?>
                                    <span style="color:green;font-weight:bold;">PAGÓ</span>
                                <?php else: ?>
                                    <span style="color:red;font-weight:bold;">NO PAGÓ</span>
                                <?php endif; ?>
                                
                                <!-- Mostrar el estado real para debug -->
                                <br><small style="color:#666;">(<?= $estadoPago ?>)</small>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('admin/editar_usuario/'.$usuario['id_usuario']); ?>" class="btn-edit">Editar</a>
                                    <a href="<?= base_url('admin/eliminar_usuario/'.$usuario['id_usuario']); ?>" 
                                       class="btn-delete"
                                       onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                       Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <p class="no-data">No hay usuarios registrados.</p>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer') ?>
