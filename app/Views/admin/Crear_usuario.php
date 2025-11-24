<?= $this->include('templates/menu_principal') ?>

<div class="main-content fade-in">
    <h1 class="title">Crear Usuario</h1>

    <div class="form-container">
        <form action="<?= base_url('admin/guardar_usuario') ?>" method="POST" class="styled-form">
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ej. Juan" required>
            </div>
            <br>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" placeholder="Ej. Pérez" required>
            </div>
            <br>

            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" name="cedula" id="cedula" placeholder="Ej. 1234567890" required>
            </div>
            <br>

            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" name="correo" id="correo" placeholder="Ej. usuario@gmail.com">
            </div>
            <br>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" placeholder="Ej. 3001234567">
            </div>
            <br>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" placeholder="Ej. Calle 123 #45-67">
            </div>
            <br>

            <div class="form-group">
                <label for="genero">Género:</label>
                <select name="genero" id="genero" required>
                    <option value="">Seleccione...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <br>

            <div class="button-group">
                <button type="submit" class="btn-primary">➕ Registrar Usuario</button>
                <br>
                <a href="<?= base_url('admin/usuarios') ?>" class="btn-secondary">⬅ Volver</a>
            </div>


        </form>
    </div>
</div>

<?= $this->include('templates/footer') ?>
