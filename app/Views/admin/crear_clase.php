<?= $this->include('templates/menu_principal'); ?>

<div class="main-content">
    <h1 class="title">Crear Nueva Clase</h1>

    <form method="POST" action="<?= base_url('admin/guardar_clase'); ?>" class="form-container">
        <div class="form-row">
            <label for="nombre">Nombre de la Clase:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="form-row">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="3"></textarea>
        </div>

        <div class="form-row">
            <label for="dia_semana">Día de la Semana:</label>
            <select name="dia_semana" id="dia_semana" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
        </div>

        <div class="form-row">
            <label for="hora_inicio">Hora Inicio:</label>
            <input type="time" name="hora_inicio" id="hora_inicio" required>
        </div>

        <div class="form-row">
            <label for="hora_fin">Hora Fin:</label>
            <input type="time" name="hora_fin" id="hora_fin" required>
        </div>

        <div class="form-row">
            <label for="cupo_maximo">Cupo Máximo:</label>
            <input type="number" name="cupo_maximo" id="cupo_maximo" value="8" min="1" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-save">Crear Clase</button>
            <a href="<?= base_url('admin/clases'); ?>" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<?= $this->include('templates/footer'); ?>