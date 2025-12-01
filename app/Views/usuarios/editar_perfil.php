<?= $this->include('templates/menu_principal_u') ?>

<link rel="stylesheet" href="<?= base_url('css/perfil.css') ?>"> <!-- o el que uses -->

<div class="main-content">
    <div class="profile-info">
        <h1 class="title">Editar Perfil</h1>

        <?php if (session()->get('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('usuarios/perfil/actualizar') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Cedula solo lectura -->
            <div class="form-row">
                <label>Cédula:</label>
                <input type="text" value="<?= esc($usuario['cedula']) ?>" disabled>
            </div>

            <div class="form-row">
                <label>Nombre:</label>
                <input type="text" name="nombre"
                       value="<?= old('nombre', $usuario['nombre']) ?>">
            </div>

            <div class="form-row">
                <label>Apellido:</label>
                <input type="text" name="apellido"
                       value="<?= old('apellido', $usuario['apellido']) ?>">
            </div>

            <div class="form-row">
                <label>Correo:</label>
                <input type="email" name="correo"
                       value="<?= old('correo', $usuario['correo']) ?>">
            </div>

            <div class="form-row">
                <label>Teléfono:</label>
                <input type="text" name="telefono"
                       value="<?= old('telefono', $usuario['telefono']) ?>">
            </div>

            <div class="form-row">
                <label>Género:</label>
                <select name="genero">
                    <option value="">Seleccione...</option>
                    <option value="Masculino" <?= old('genero', $usuario['genero']) == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                    <option value="Femenino"  <?= old('genero', $usuario['genero']) == 'Femenino'  ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro"      <?= old('genero', $usuario['genero']) == 'Otro'      ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <button type="submit" class="btn-guardar">
                Guardar cambios
            </button>

            <a href="<?= base_url('usuarios/perfil') ?>" class="btn-cancelar">
                Cancelar
            </a>
        </form>
    </div>
</div>
