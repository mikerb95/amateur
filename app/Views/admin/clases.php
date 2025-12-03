<?= $this->include('templates/menu_principal'); ?>

<div class="main-content">
    <div class="page-header">
        <h1 class="title">Gestión de Clases</h1>
        <a href="<?= base_url('admin/crear_clase'); ?>" class="btn-crear">
            <img src="<?= base_url('imagenes/adduser.svg') ?>" alt="G_usuarios" class="iconheader"> Crear Nueva Clase
        </a>
    </div>

    <!-- ======== PANEL DE FILTROS ======== -->
    <div class="filters-panel">
        <form method="GET" action="<?= base_url('admin/clases'); ?>" class="filters-form">
            <div class="filters-grid">
                <!-- Filtro por día -->
                <div class="filter-group">
                    <label for="dia">Filtrar por día:</label>
                    <select name="dia" id="dia" onchange="this.form.submit()" class="filter-select">
                        <option value="">Todos los días</option>
                        <option value="Lunes" <?= ($diaSeleccionado == 'Lunes' ? 'selected' : '') ?>>Lunes</option>
                        <option value="Martes" <?= ($diaSeleccionado == 'Martes' ? 'selected' : '') ?>>Martes</option>
                        <option value="Miércoles" <?= ($diaSeleccionado == 'Miércoles' ? 'selected' : '') ?>>Miércoles</option>
                        <option value="Jueves" <?= ($diaSeleccionado == 'Jueves' ? 'selected' : '') ?>>Jueves</option>
                        <option value="Viernes" <?= ($diaSeleccionado == 'Viernes' ? 'selected' : '') ?>>Viernes</option>
                        <option value="Sábado" <?= ($diaSeleccionado == 'Sábado' ? 'selected' : '') ?>>Sábado</option>
                        <option value="Domingo" <?= ($diaSeleccionado == 'Domingo' ? 'selected' : '') ?>>Domingo</option>
                    </select>
                </div>

                <!-- Botón de aplicar filtro (para móviles) -->
                <div class="filter-group">
                    <button type="submit" class="btn-apply">Aplicar Filtro</button>
                </div>
            </div>
        </form>
    </div>

    <!-- ======== ESTADÍSTICAS RÁPIDAS CORREGIDAS ======== -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/planuser.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count($clases) ?></h3>
                <p>Total Clases</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/si.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count(array_filter($clases, function($c) { return $c['disponible'] == 1; })) ?></h3>
                <p>Activas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/no.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count(array_filter($clases, function($c) { return $c['disponible'] == 0; })) ?></h3>
                <p>Inactivas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><img src="<?= base_url('imagenes/usuarios.svg') ?>" alt="G_clases" class="iconos"></div>
            <div class="stat-info">
                <h3><?= count(array_filter($clases, function($c) { return $c['cupo_disponible'] < $c['cupo_maximo']; })) ?></h3>
                <p>Con Reservas</p>
            </div>
        </div>
    </div>

    <!-- ======== TABLA MEJORADA ======== -->
    <?php if (!empty($clases)): ?>
        <div class="table-improved-container">
            <table class="styled-table improved-table">
                <thead>
                    <tr>
                        <th><img src="<?= base_url('imagenes/number.svg') ?>" alt="G_usuarios" class="iconnn"></th>
                        <th>Nombre</th>
                        <th>Día</th>
                        <th>Horario</th>
                        <th>Cupos</th>
                        <th>Ocupación</th>
                        <th>Estado</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clases as $clase): 
                        $porcentajeOcupacion = $clase['cupo_maximo'] > 0 ? 
                            (($clase['cupo_maximo'] - $clase['cupo_disponible']) / $clase['cupo_maximo']) * 100 : 0;
                    ?>
                        <tr>
                            <td class="text-center"><?= esc($clase['id_clases']) ?></td>
                            <td>
                                <div class="clase-info">
                                    <strong><?= esc($clase['nombre']) ?></strong>
                                    <?php if (!empty($clase['descripcion'])): ?>
                                        <small class="clase-desc"><?= esc($clase['descripcion']) ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="dia-badge"><?= esc($clase['dia_semana']) ?></span>
                            </td>
                            <td>
                                <div class="horario-info">
                                    <span class="hora"><?= date('H:i', strtotime($clase['hora_inicio'])) ?></span>
                                    <span class="separador">-</span>
                                    <span class="hora"><?= date('H:i', strtotime($clase['hora_fin'])) ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="cupo-info">
                                    <div class="cupo-text">
                                        <?= $clase['cupo_disponible'] ?> / <?= $clase['cupo_maximo'] ?>
                                    </div>
                                    <div class="cupo-bar">
                                        <div class="cupo-progress" style="width: <?= $porcentajeOcupacion ?>%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="ocupacion-badge <?= $porcentajeOcupacion >= 80 ? 'lleno' : ($porcentajeOcupacion >= 50 ? 'medio' : 'vacio') ?>">
                                    <?= number_format($porcentajeOcupacion, 0) ?>%
                                </span>
                            </td>
                            <td>
                                <div class="estado-container">
                                    <a href="<?= base_url('admin/toggle_disponibilidad/' . $clase['id_clases']) ?>"
                                       class="estado-badge <?= $clase['disponible'] ? 'disponible' : 'no-disponible' ?>"
                                       onclick="return confirm('¿<?= $clase['disponible'] ? 'Deshabilitar' : 'Habilitar' ?> esta clase?')">
                                        <span class="estado-icon">
                                            <?= $clase['disponible'] ? '✅' : '❌' ?>
                                        </span>
                                        <?= $clase['disponible'] ? 'Disponible' : 'No disponible' ?>
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
            <div class="no-data-icon"><img src="<?= base_url('imagenes/clasess.svg') ?>" alt="G_clases" class="detallesuser"></div>
            <h3>No hay clases registradas</h3>
            <p>Comienza creando tu primera clase</p>
            <a href="<?= base_url('admin/crear_clase'); ?>" class="btn-crear">
               <img src="<?= base_url('imagenes/adduser.svg') ?>" alt="G_clases" class="detallesuser"> Crear Primera Clase
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Incluir el CSS separado -->
<link rel="stylesheet" href="<?= base_url('css/admin-clases.css') ?>">

<?= $this->include('templates/footer'); ?>