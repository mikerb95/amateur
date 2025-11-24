<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <h1 class="title">Usuarios Registrados</h1>

    <?php if (!empty($usuarios) && is_array($usuarios)): ?>
        <div>
            <a href="<?= base_url('admin/Crear_usuario'); ?>" class="btn-crear">Crear usuario</a>

            <!-- ⭐ BOTÓN GLOBAL -->
            <a href="<?= base_url('admin/pagos'); ?>" class="btn-pay">Pagos</a>

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

                            <td>
                                <?php if (!empty($usuario['estado_pago']) && $usuario['estado_pago'] == 'Pago Cancelado'): ?>
                                    <span style="color:green;font-weight:bold;">PAGÓ</span>
                                <?php else: ?>
                                    <span style="color:red;font-weight:bold;">NO PAGÓ</span>
                                <?php endif; ?>
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
