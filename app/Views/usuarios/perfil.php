<?= $this->include('templates/menu_principal_u') ?>
    <link rel="stylesheet" href="<?= base_url('css/perfil.css') ?>">


<div class="main-content">
    <div class="profile-info">
    <h1 class="title">Mi Perfil</h1>

    <?php if (!empty($usuario) && is_array($usuario)): ?>
 <table>
        <tr>
            <td class="label">Cedula:</td>
            <td><?= esc($usuario['cedula']) ?></td>
        </tr>
        <tr>
            <td class="label">Nombre:</td>
            <td> <?= esc($usuario['nombre']) ?></td>
        </tr>
        <tr>
            <td class="label">Apellido:</td>
            <td><?= esc($usuario['apellido']) ?></td>
        </tr>
        <tr>
            <td class="label">Correo:</td>
            <td><?= esc($usuario['correo']) ?></td>
        </tr>
        <tr>
            <td class="label">Teléfono:</td>
            <td><?= esc($usuario['telefono'])?></td>
        </tr>
        <tr>
            <td clas="label">Genero</td>
            <td><?= esc($usuario['genero']) ?></td>
        </tr>
    </table>
    <br>
    <div class="contenedor-del-boton">
    <a href="<?= base_url('usuarios/perfil/editar') ?>" class="btn-editar">
    Editar perfil
</a>
</div>
        
    </div>

    <?php else: ?>
        <p class="no-data">Usuario no encontrado.</p>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer') ?>
