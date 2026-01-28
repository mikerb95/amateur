<h2>📦 Mi paquete de clases</h2>

<?php if (!$paquete): ?>
    <p style="color:red;">No tienes un paquete activo.</p>
<?php else: ?>

<ul>
    <li><strong>Total clases:</strong> <?= esc($paquete['total_clases']) ?></li>
    <li><strong>Clases restantes:</strong> <?= esc($paquete['clases_restantes']) ?></li>
    <li><strong>Estado:</strong> <?= esc($paquete['estado']) ?></li>
    <li><strong>Vence el:</strong> <?= esc($paquete['fecha_vencimiento']) ?></li>
</ul>

<?php endif; ?>

<hr>

<h3>📅 Mis reservas</h3>

<?php if (empty($reservas)): ?>
    <p>No tienes reservas.</p>
<?php else: ?>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Clase</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
        <th>Paquete</th>
    </tr>

    <?php foreach ($reservas as $r): ?>
    <tr>
        <td><?= $r['id_reservas'] ?></td>
        <td><?= $r['id_clases'] ?></td>
        <td><?= $r['fecha_clase'] ?></td>
        <td><?= $r['hora_inicio'] ?></td>
        <td><?= $r['estado'] ?></td>
        <td><?= $r['id_paquete'] ?? '—' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
