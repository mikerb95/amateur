<?= $this->include('templates/menu_principal') ?>

<div class="main-content">
    <h1 class="title">Reservas</h1>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Cédula</th>
                    <th>Clase</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($reservas as $reserva): ?>

                    <?php
                        // Si el pago está cancelado cambiar estado
                        if (isset($reserva['estado_pago']) && $reserva['estado_pago'] === 'Pago Cancelado') {
                            $reserva['estado'] = 'Cancelada';
                        }

                        // Formatear fecha
                        $fecha = isset($reserva['fecha_reserva'])
                            ? date("Y-m-d", strtotime($reserva['fecha_reserva']))
                            : '—';

                        // Clase visual para filas canceladas
                        $row_class = ($reserva['estado'] === 'Cancelada') ? 'row-cancelada' : '';
                    ?>

                    <tr class="<?= $row_class ?>">
                        <td><?= $reserva['id_reservas'] ?></td>

                        <td><?= $reserva['usuario_nombre'] . ' ' . $reserva['usuario_apellido'] ?></td>

                        <td><?= $reserva['cedula'] ?></td>

                        <td><?= $reserva['clase_nombre'] ?></td>

                        <td><?= $fecha ?></td>

                        <td>
                            <?php if ($reserva['estado'] === 'Cancelada'): ?>
                                <!-- CANCELADA (VERDE) -->
                                <span class="badge cancelado">
                                    <svg viewBox="0 0 24 24" class="icon">
                                        <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    CANCELADA
                                </span>

                            <?php elseif ($reserva['estado'] === 'Pendiente'): ?>
                                <!-- PENDIENTE (ROJO) -->
                                <span class="badge pendiente">
                                    <svg viewBox="0 0 24 24" class="icon">
                                        <path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 
                                        6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 
                                        17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                    PENDIENTE
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('templates/footer') ?>
