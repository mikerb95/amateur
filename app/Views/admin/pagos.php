<?= $this->include('templates/menu_principal') ?>

<div class="main-content">

    <h1 class="title">Estado de Pagos</h1>


    <?php if (!isset($usuario) || $usuario == null): ?>

        <form action="<?= base_url('admin/pagos/buscar'); ?>" method="POST">
            <label>Buscar usuario por cédula:</label>
            <input type="text" name="cedula" required>
            <button type="submit">Buscar</button>
        </form>

    <?php else: ?>

        <form action="<?= base_url('admin/pagos/guardar'); ?>" method="POST">

            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

            <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?> <?= $usuario['apellido'] ?></p>
            <p><strong>Cédula:</strong> <?= $usuario['cedula'] ?></p>

            <label>Estado de pago:</label>
            <select name="estado">
                <option value="Pago Pendiente">Pago Pendiente</option>
                <option value="Pago Cancelado">Pago Cancelado</option>
            </select>


            <button type="submit">Guardar</button>

        </form>

    <?php endif; ?>

</div>

<?= $this->include('templates/footer') ?>
