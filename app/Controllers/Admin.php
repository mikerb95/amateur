<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\PerfilModel;
use App\Models\ClaseModel;
use App\Models\ReservaModel;
use App\Models\PlanModel;
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

        $usuarios = $usuarioModel->findAll();

        foreach ($usuarios as &$u) {

            // obtener usuario en tabla perfil (rol, usuario, contraseña)
            $perfil = $perfilModel->where('id_usuario', $u['id_usuario'])->first();
            $u['rol'] = $perfil ? $perfil['id_rol'] : 'Sin perfil';

            // obtener plan
            $plan = $planModel->where('id_planes', $u['id_usuario'])->first();
            $u['plan'] = $plan ? $plan['nombre'] : 'Sin plan asignado';
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
        $perfilModel  = new PerfilModel();

        // datos personales
        $dataUsuario = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'cedula'    => $this->request->getPost('cedula'),
            'correo'    => $this->request->getPost('correo'),
            'telefono'  => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'genero'    => $this->request->getPost('genero'),
        ];

        // credenciales
        $dataPerfil = [
            'id_rol' => $this->request->getPost('id_rol')
        ];

        $usuarioModel->update($id, $dataUsuario);

        $perfil = $perfilModel->where('id_usuario', $id)->first();
        if ($perfil) {
            $perfilModel->update($perfil['id_perfil'], $dataPerfil);
        }

        return redirect()->to(base_url('admin/usuarios'))
                         ->with('mensaje', 'Usuario actualizado correctamente');
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
        // Lógica para editar una clase
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
        $reservas = $reservaModel->getAll();  // lo corregiremos cuando envíes el modelo

        return view('admin/reservas', ['reservas' => $reservas]);
    }
}
