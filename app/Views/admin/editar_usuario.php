<?= $this->include('templates/menu_principal') ?>

<div class="main-content fade-in">
    <h1 class="title">Editar Usuario</h1>

    <div class="form-container">
        <form action="<?= base_url('admin/actualizar_usuario/' . $usuario['id']) ?>" method="POST" class="styled-form">
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?= esc($usuario['nombre']) ?>" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" value="<?= esc($usuario['apellido']) ?>" required>
            </div>

            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" value="<?= esc($usuario['cedula']) ?>">
            </div>

            <div class="button-group">
                <button type="submit" class="btn-primary">💾 Guardar Cambios</button>
                <a href="<?= base_url('admin/usuarios') ?>" class="btn-secondary">⬅ Volver</a>
            </div>
        </form>
    </div>
</div>

<?= $this->include('templates/footer') ?>
