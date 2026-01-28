<?= $this->include('templates/menu_principal_u') ?>
<link rel="stylesheet" href="<?= base_url('css/reservas.css') ?>">

<?php if (session()->getFlashdata('mensaje')): ?>
  <div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
    <?= session()->getFlashdata('mensaje') ?>
  </div>
<?php endif; ?>

<?php
  // ✅ Si no hay paquete o no hay saldo, no debería poder reservar
  $sinSaldo = empty($paquete) || (int)$restantes <= 0;
?>

<div class="main-content">
  <div class="profile-info">
    <h1 class="title">Reservar Nueva Clase</h1>

    <!-- ✅ Resumen del paquete -->
    <div style="margin: 15px 0; padding: 14px; border-radius: 12px; border: 1px solid #eee; background: #fff;">
      <h3 style="margin:0 0 8px 0;">📦 Tus clases del mes</h3>

      <?php if (empty($paquete)): ?>
        <p style="margin:0; color:#b00020;">No tienes un paquete activo con clases disponibles.</p>
      <?php else: ?>
        <div style="display:flex; gap:18px; flex-wrap:wrap;">
          <p style="margin:0;"><strong>Asignadas:</strong> <?= esc($total) ?></p>
          <p style="margin:0;"><strong>Consumidas:</strong> <?= esc($consumidas) ?></p>
          <p style="margin:0;"><strong>Restantes:</strong> <?= esc($restantes) ?></p>
          <p style="margin:0;"><strong>Vence:</strong> <?= esc($paquete['fecha_vencimiento']) ?></p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Tabs -->
    <div class="days-nav">
        <button type="button" class="day active" data-day="lunes">Lunes</button>
        <button type="button" class="day" data-day="martes">Martes</button>
        <button type="button" class="day" data-day="miércoles">Miércoles</button>
        <button type="button" class="day" data-day="jueves">Jueves</button>
        <button type="button" class="day" data-day="viernes">Viernes</button>
        <button type="button" class="day" data-day="sábado">Sábado</button>
    </div>

    <?php if (!empty($clases)) : ?>
      <?php foreach ($clases as $clase) : ?>

        <?php
          // ✅ OPCIÓN 1: si el controller marcó la clase como oculta, no la mostramos
          if (!empty($clase['oculta'])) {
              continue;
          }

          // ✅ Evitar errores si ya_reservada no viene (por seguridad)
          $yaReservada = !empty($clase['ya_reservada']);
        ?>

        <div class="class-card <?= ((int)$clase['disponible'] == 0 ? 'card-disabled' : '') ?>"
             data-day="<?= strtolower(trim(esc($clase['dia_semana']))) ?>">

          <h3><?= esc($clase['nombre']) ?></h3>

          <p class="coach">Entrenador: <?= esc($clase['id_rol']) ?></p>

          <p class="time">
            <?= esc($clase['dia_semana']) ?> -
            <?= date('d-m-Y', strtotime($clase['fecha_clase'])) ?> /
            <?= date('h:i A', strtotime($clase['hora_inicio'])) ?> –
            <?= date('h:i A', strtotime($clase['hora_fin'])) ?>
          </p>

          <p class="room">Sala: <?= esc($clase['id_planes']) ?></p>

          <p class="cupos">
            Cupos disponibles: <?= esc($clase['cupo_disponible']) ?> / <?= esc($clase['cupo_maximo']) ?>
          </p>

          <?php if ((int)$clase['disponible'] === 0): ?>
            <div class="no-disponible">❌ Clase no disponible</div>
          <?php endif; ?>

          <form action="<?= base_url('usuarios/hacer_reserva/' . $clase['id_clases']) ?>" method="post">
            <button
              type="submit"
              class="btn-reservar"
              <?php if ((int)$clase['disponible'] === 0 || $sinSaldo || $yaReservada): ?>
                disabled style="background:#999;cursor:not-allowed;"
              <?php endif; ?>
            >
              <?php if ($sinSaldo): ?>
                Sin clases disponibles
              <?php elseif ($yaReservada): ?>
                Ya reservada
              <?php else: ?>
                Reservar
              <?php endif; ?>
            </button>
          </form>

        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div style="text-align: center; padding: 40px;">
        <p style="font-size: 16px; color: #666;">
          <strong>⚠️ No hay clases disponibles actualmente.</strong>
        </p>
        <p style="color: #999; margin-top: 10px;">
          Todas las clases están deshabilitadas o no tienen cupos disponibles. Por favor, intenta más tarde.
        </p>
      </div>
    <?php endif; ?>

  </div>
</div>

<script src="<?= base_url('js/reservas.js') ?>"></script>
</body>
