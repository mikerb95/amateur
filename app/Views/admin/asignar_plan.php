<?= $this->include('templates/menu_principal') ?>

<!-- ✅ CSS externo -->
<link rel="stylesheet" href="<?= base_url('css/asignar_plan.css') ?>">

<section class="dashboard">
  <div class="asignar-wrap">

    <h1 class="asignar-title">Asignar plan por cédula</h1>

        <!-- BOTÓN VOLVER -->
    <div style="margin-bottom:20px; display:flex; justify-content:flex-start;">
      <a href="<?= base_url('admin/dashboard_admin') ?>" class="btn btn-volver">
        ⬅ Volver al menú principal
      </a>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
      <div class="msg"><?= esc(session()->getFlashdata('mensaje')) ?></div>
    <?php endif; ?>

    <!-- BUSCADOR -->
    <div class="card-box">
      <form action="<?= base_url('admin/asignar_plan/buscar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
          <div class="field">
            <label for="cedula">Cédula</label>
            <input id="cedula" type="text" name="cedula" required class="cedula-buscador">
          </div>

          <button type="submit" class="btn btn-buscar">Buscar</button>
        </div>
      </form>
    </div>

    <?php if (!empty($usuario)): ?>

      <!-- USUARIO -->
      <div class="card-box">
        <h3 style="margin:0 0 10px;color:#3b006a;">Usuario encontrado</h3>

        <div class="grid-info">
          <div class="kv"><b>ID</b><?= esc($usuario['id_usuario']) ?></div>
          <div class="kv"><b>Cédula</b><?= esc($usuario['cedula']) ?></div>
          <div class="kv"><b>Nombre</b><?= esc($usuario['nombre'].' '.$usuario['apellido']) ?></div>
          <div class="kv"><b>Correo</b><?= esc($usuario['correo']) ?></div>
        </div>
      </div>

      <!-- PAQUETE ACTUAL -->
      <?php if (!empty($paqueteActual)): ?>
        <div class="card-box">
          <h3 style="margin:0 0 10px;color:#3b006a;">Paquete actual</h3>

          <div class="grid-info">
            <div class="kv"><b>Estado</b><?= esc($paqueteActual['estado']) ?></div>
            <div class="kv"><b>Clases restantes</b><?= esc($paqueteActual['clases_restantes']) ?> / <?= esc($paqueteActual['total_clases']) ?></div>
            <div class="kv"><b>Inicio</b><?= esc($paqueteActual['fecha_inicio']) ?></div>
            <div class="kv"><b>Vence</b><?= esc($paqueteActual['fecha_vencimiento']) ?></div>
          </div>

          <?php if (!empty($bloqueado)): ?>
            <div class="msg" style="margin-top:12px;">
              ⚠️ Este usuario ya tiene un paquete <b>ACTIVO</b>, vigente y con saldo.
              No se puede asignar otro.
            </div>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="card-box">
          <p style="margin:0;">Este usuario no tiene paquetes aún.</p>
        </div>
      <?php endif; ?>

      <!-- PLANES -->
      <div class="card-box">
        <h3 style="margin:0 0 10px;color:#3b006a;">Selecciona un plan</h3>

        <?php if (empty($planes)): ?>
          <p>No hay planes activos.</p>
        <?php else: ?>
          <form action="<?= base_url('admin/asignar_plan/asignar') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="id_usuario" value="<?= esc($usuario['id_usuario']) ?>">

            <div class="row">
              <div class="field">
                <label for="id_plan">Plan</label>
                <select id="id_plan" name="id_plan" required>
                  <?php foreach ($planes as $p): ?>
                    <option value="<?= esc($p['id_planes']) ?>">
                      <?= esc($p['nombre']) ?>
                      — <?= (int)$p['total_clases'] ?> clases
                      — $ <?= number_format((float)$p['precio'], 0, ',', '.') ?> 
                      — <?= (int)$p['duracion_dias'] ?> días
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div style="margin-top:14px; display:flex; justify-content:center;">
              <button
                type="submit"
                class="btn btn-asignar"
                <?= !empty($bloqueado) ? 'disabled' : '' ?>
                title="<?= !empty($bloqueado) ? 'Usuario con paquete activo vigente' : 'Asignar plan' ?>"
              >
                Asignar plan
              </button>
            </div>

          </form>
        <?php endif; ?>
      </div>

    <?php endif; ?>

  </div>
</section>

<?= $this->include('templates/footer') ?>
