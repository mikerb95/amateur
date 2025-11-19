<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <h1 class="title">Editar Usuario</h1>

    <div class="form-container">

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('admin/actualizar_usuario/' . $usuario['id_usuario']); ?>" method="post">

            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

            <div class="form-row">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" 
                       value="<?= esc($usuario['nombre']) ?>" required>
            </div>

            <div class="form-row">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" 
                       value="<?= esc($usuario['apellido']) ?>" required>
            </div>

            <div class="form-row">
                <label for="cedula">Cédula:</label>
                <input type="number" id="cedula" name="cedula" 
                       value="<?= esc($usuario['cedula']) ?>" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-save">Guardar Cambios</button>
                <a href="<?= base_url('admin/usuarios'); ?>" class="btn-cancel">Cancelar</a>
            </div>

        </form>

    </div>
</div>

<?= $this->include('templates/footer') ?>