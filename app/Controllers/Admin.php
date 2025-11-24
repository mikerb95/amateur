<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\PerfilModel;
use App\Models\ClaseModel;
use App\Models\ReservaModel;
use App\Models\PlanModel;
use App\Models\PagoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController
{
    // =========================
    // 🏠 DASHBOARD ADMIN
    // =========================
    public function dashboard_admin()
    {
        $usuarioModel = new DatosUsuarioModel();
        $claseModel = new ClaseModel();
        $reservaModel = new ReservaModel();

        $data = [
            'usuarios' => $usuarioModel->countAll(),
            'clases'   => $claseModel->countAll(),
            'reservas' => $reservaModel->countAll(),
        ];

        return view('admin/dashboard_admin', $data);
    }

    // =========================
    // 👥 LISTA DE USUARIOS
    // =========================
    public function usuarios()
    {
        $usuarioModel = new DatosUsuarioModel();
        $perfilModel  = new PerfilModel();
        $planModel    = new PlanModel();
        $pagoModel    = new PagoModel();

        $usuarios = $usuarioModel->findAll();

        foreach ($usuarios as &$u) {
            // obtener usuario en tabla perfil (rol, usuario, contraseña)
            $perfil = $perfilModel->where('id_usuario', $u['id_usuario'])->first();
            $u['rol'] = $perfil ? $perfil['id_rol'] : 'Sin perfil';

            // obtener plan
            $plan = $planModel->where('id_planes', $u['id_usuario'])->first();
            $u['plan'] = $plan ? $plan['nombre'] : 'Sin plan asignado';

            // obtener estado del pago
            $pago = $pagoModel->where('id_usuario', $u['id_usuario'])
                              ->orderBy('id_pago', 'DESC')
                              ->first();
            $u['estado_pago'] = $pago ? $pago['estado'] : 'pendiente';
        }

        return view('admin/usuarios', ['usuarios' => $usuarios]);
    }

    // =========================
    // ✏️ FORMULARIO EDITAR USUARIO
    // =========================
    public function editar_usuario($id = null)
    {
        $usuarioModel = new DatosUsuarioModel();
        $perfilModel  = new PerfilModel();
        $planModel    = new PlanModel();

        $usuario = $usuarioModel->find($id);
        if (!$usuario) {
            throw new PageNotFoundException("Usuario no encontrado");
        }

        $perfil = $perfilModel->where('id_usuario', $id)->first();
        $planes = $planModel->findAll();

        return view('admin/editar_usuario', [
            'usuario' => $usuario,
            'perfil'  => $perfil,
            'planes'  => $planes
        ]);
    }

    // =========================
    // 💾 ACTUALIZAR USUARIO
    // =========================
    public function actualizar_usuario($id = null)
    {
        $usuarioModel = new DatosUsuarioModel();

        $usuario = $usuarioModel->find($id);
        if (!$usuario) {
            throw new PageNotFoundException("Usuario no encontrado");
        }

        $nombre   = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $cedula   = $this->request->getPost('cedula');

        if (empty($nombre) || empty($apellido) || empty($cedula)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        $usuarioExistente = $usuarioModel->where('cedula', $cedula)
                                         ->where('id_usuario !=', $id)
                                         ->first();
        if ($usuarioExistente) {
            return redirect()->back()->with('error', 'La cédula ya está registrada en otro usuario.');
        }

        $dataUsuario = [
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'cedula'   => $cedula
        ];
        $usuarioModel->update($id, $dataUsuario);

        return redirect()->to(base_url('admin/usuarios'))
                         ->with('mensaje', 'Usuario actualizado correctamente.');
    }

    // =========================
    // 📚 GESTIÓN DE CLASES
    // =========================
    public function clases()
    {
        $claseModel = new ClaseModel();
        $clases = $claseModel->findAll();
        return view('admin/clases', ['clases' => $clases]);
    }

    public function editar_clase($id_clases)
    {
        $claseModel = new ClaseModel();
        $clase = $claseModel->find($id_clases);
        if (!$clase) {
            throw new PageNotFoundException("Clase no encontrada");
        }
        return view('admin/editar_clase', ['clase' => $clase]);
    }

    // =========================
    // 🗓️ GESTIÓN DE RESERVAS
    // =========================
    public function reservas()
    {
        $reservaModel = new ReservaModel();
        $reservas = $reservaModel->getAll(); // actualizar según tu modelo
        return view('admin/reservas', ['reservas' => $reservas]);
    }

    // =========================
    // 💰 GESTIÓN DE PAGOS
    // =========================
    public function pagos_usuarios()
    {
        $usuarioModel = new DatosUsuarioModel();
        $perfilModel  = new PerfilModel();
        $planModel    = new PlanModel();
        $pagoModel    = new PagoModel();

        $usuarios = $usuarioModel->findAll();

        foreach ($usuarios as &$u) {
            $perfil = $perfilModel->where('id_usuario', $u['id_usuario'])->first();
            $u['rol'] = $perfil ? $perfil['id_rol'] : 'Sin perfil';

            $plan = $planModel->where('id_planes', $u['id_usuario'])->first();
            $u['plan'] = $plan ? $plan['nombre'] : 'Sin plan asignado';

            $pago = $pagoModel->where('id_usuario', $u['id_usuario'])->first();
            $u['estado_pago'] = $pago ? $pago['estado'] : 'No registrado';
        }

        return view('admin/usuarios', ['usuarios' => $usuarios]);
    }
}
