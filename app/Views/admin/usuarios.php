<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <h1 class="title">Usuarios Registrados</h1>

    <?php if (!empty($usuarios) && is_array($usuarios)): ?>
        <div>
<<<<<<< HEAD
            <a href="<?= base_url('admin/Crear_usuario'); ?>" class="btn-crear">Crear usuario</a>

            <!-- ⭐ BOTÓN GLOBAL -->
            <a href="<?= base_url('admin/pagos'); ?>" class="btn-pay">Pagos</a>

            <br><br>
        </div>

=======
           <a href="<?= base_url('admin/Crear_usuario'); ?>" class="btn-crear">Crear usuario</a>
           <br>
           <br>

        </div>
>>>>>>> a7c1e799351753b12fd724bfb3f5dfa116854a64
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cédula</th>
<<<<<<< HEAD
                        <th>Estado de pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

=======
                        <th>Acciones</th>
                    </tr>
                </thead>
>>>>>>> a7c1e799351753b12fd724bfb3f5dfa116854a64
                <tbody>
                    <?php foreach ($usuarios as $index => $usuario): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($usuario['nombre']) ?></td>
                            <td><?= esc($usuario['apellido']) ?></td>
                            <td><?= esc($usuario['cedula']) ?></td>
<<<<<<< HEAD

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

=======
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('admin/editar_usuario/'.$usuario['id_usuario']); ?>" method="POST" class="btn-edit">Editar</a>
>>>>>>> a7c1e799351753b12fd724bfb3f5dfa116854a64
                                    <a href="<?= base_url('admin/eliminar_usuario/'.$usuario['id_usuario']); ?>" 
                                       class="btn-delete"
                                       onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                       Eliminar
                                    </a>
                                </div>
                            </td>
<<<<<<< HEAD

=======
>>>>>>> a7c1e799351753b12fd724bfb3f5dfa116854a64
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<<<<<<< HEAD

=======
>>>>>>> a7c1e799351753b12fd724bfb3f5dfa116854a64
    <?php else: ?>
        <p class="no-data">No hay usuarios registrados.</p>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer') ?>
