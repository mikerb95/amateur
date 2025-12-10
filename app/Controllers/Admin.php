<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\PerfilModel;
use App\Models\ClaseModel;
use App\Models\PagoModel;
use App\Models\ReservaModel;
use App\Models\PlanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController
{
    // =========================
    // 🏠 DASHBOARD ADMIN
    // =========================
    public function __construct()
    {
        // PROTECCIÓN GLOBAL PARA TODO EL CONTROLADOR ADMIN
        if (!session('logueado') || !in_array(session('id_rol'), [1, 2])) {
            // si no está logueado o el rol NO es 1 ó 2 -> fuera
            redirect()->to('/login')->send();
            exit;
        }
    }
    public function usuarios()
{
    $usuarioModel = new DatosUsuarioModel();
    $perfilModel  = new PerfilModel();
    $planModel    = new PlanModel();
    $pagoModel    = new PagoModel();

    $usuarios = $usuarioModel->findAll();

    foreach ($usuarios as &$u) {
        // Perfil / rol
        $perfil = $perfilModel->where('id_usuario', $u['id_usuario'])->first();
        $u['rol'] = $perfil ? $perfil['id_rol'] : 'Sin perfil';

        // Plan asignado (por ahora tomas el primero)
        $plan = $planModel->first();
        $u['plan'] = $plan ? $plan['nombre'] : 'Sin plan asignado';

        // ✅ Estado del pago: usar SIEMPRE el ÚLTIMO pago del usuario
        $pago = $pagoModel->getPagoByUsuario($u['id_usuario']); // <-- usa el método del modelo

        $u['estado_pago'] = $pago ? $pago['estado'] : 'Pago Pendiente';
    }

    return view('admin/usuarios', ['usuarios' => $usuarios]);
}

public function dashboard_admin()
{
    return view('admin/dashboard_admin');
}


    // =========================
    // ✏️ FORMULARIO EDITAR USUARIO
    // =========================
    public function editar_usuario($id = null)
    {
        $usuarioModel = new DatosUsuarioModel();
        $perfilModel  = new PerfilModel();
        $planModel    = new PlanModel();
        $pagoModel    = new PagoModel();

        $usuario = $usuarioModel->find($id);
        if (!$usuario) {
            throw new PageNotFoundException("Usuario no encontrado");
        }

        $perfil = $perfilModel->where('id_usuario', $id)->first();
        $planes = $planModel->findAll();
        $pago = $pagoModel->where('id_usuario', $id)->first();

        return view('admin/editar_usuario', [
            'usuario' => $usuario,
            'perfil'  => $perfil,
            'planes'  => $planes,
            'pago'    => $pago
        ]);
    }

    // =========================
    // 💾 ACTUALIZAR USUARIO
    // =========================
    public function actualizar_usuario($id = null)
{
    $usuarioModel = new DatosUsuarioModel();
    $pagoModel    = new PagoModel();

    // 1️⃣ Buscar usuario
    $usuario = $usuarioModel->find($id);
    if (!$usuario) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Usuario no encontrado");
    }

    // 2️⃣ Datos personales del formulario
    $nombre   = $this->request->getPost('nombre');
    $apellido = $this->request->getPost('apellido');
    $estado   = $this->request->getPost('estado');

    // 3️⃣ Validaciones básicas (ya NO se valida cédula)
    if (empty($nombre) || empty($apellido) || empty($estado)) {
        return redirect()->back()->with('error', 'Nombre, apellido y estado son obligatorios.');
    }

    // 4️⃣ Validar estado del pago
    $estadosPermitidos = ['Pago Pendiente', 'Pago Cancelado'];
    if (!in_array($estado, $estadosPermitidos)) {
        return redirect()->back()->with('error', 'Estado de pago no válido.');
    }

    try {
        // 5️⃣ Actualizar datos del usuario (NO tocamos la cédula)
        $dataUsuario = [
            'nombre'   => $nombre,
            'apellido' => $apellido,
            // 'cedula' => $usuario['cedula']  // ← NI LA LEEMOS NI LA PONEMOS
        ];
        $usuarioModel->update($id, $dataUsuario);

        // 6️⃣ Actualizar o crear estado de pago
        $pagoExistente = $pagoModel->where('id_usuario', $id)->first();

        if ($pagoExistente) {
            $pagoModel->update($pagoExistente['id_pago'], ['estado' => $estado]);
        } else {
            $pagoModel->insert([
                'id_usuario' => $id,
                'estado'     => $estado
            ]);
        }

        // 7️⃣ Redirigir con mensaje de éxito
        return redirect()->to(base_url('admin/usuarios'))
            ->with('success', 'Usuario y estado de pago actualizados correctamente.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al actualizar: ' . $e->getMessage());
    }
}

    // =========================
    // 🗑️ ELIMINAR USUARIO
    // =========================
   public function eliminar_Usuario($idUsuario)
{
    // 1. Borrar pagos del usuario
    $this->db->table('pagos')->where('id_usuario', $idUsuario)->delete();

    // 2. Borrar reservas si existen
    $this->db->table('reservas')->where('id_usuario', $idUsuario)->delete();

    // 3. Borrar usuario
    return $this->db->table('datos_usuarios')->where('id_usuario', $idUsuario)->delete();
}

    // =========================
    // 📚 GESTIÓN DE CLASES
    // =========================
    public function clases()
{
    $claseModel = new ClaseModel();

    // Obtener día seleccionado desde GET
    $dia = $this->request->getGet('dia');

    if ($dia) {
        $clases = $claseModel->where('dia_semana', $dia)->findAll();
    } else {
        $clases = $claseModel->findAll();
    }

    return view('admin/clases', [
        'clases' => $clases,
        'diaSeleccionado' => $dia
    ]);
}

public function toggle_disponibilidad($id = null)
{
    $claseModel = new \App\Models\ClaseModel();

    $clase = $claseModel->find($id);
    if (!$clase) {
        return redirect()->to(base_url('admin/clases'))->with('error', 'Clase no encontrada.');
    }

    $nuevoEstado = $clase['disponible'] ? 0 : 1;
    $claseModel->update($id, ['disponible' => $nuevoEstado]);

    return redirect()->to(base_url('admin/clases'))->with('success', 'Estado actualizado correctamente.');
}




    public function actualizar_clase($id_clases)
    {
        $claseModel = new ClaseModel();

        $data = [
            'nombre_clase' => $this->request->getPost('nombre_clase'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'horario'      => $this->request->getPost('horario'),
            'instructor'   => $this->request->getPost('instructor')
        ];

        $claseModel->update($id_clases, $data);

        return redirect()->to(base_url('admin/clases'))
            ->with('success', 'Clase actualizada correctamente.');
    }

    public function eliminar_clase($id_clases)
    {
        $claseModel = new ClaseModel();
        $claseModel->delete($id_clases);

        return redirect()->to(base_url('admin/clases'))
            ->with('success', 'Clase eliminada correctamente.');
    }

    // =========================
// 🗓️ GESTIÓN DE RESERVAS
// =========================
public function reservas()
{
    $reservaModel = new ReservaModel();
    $reservas = $reservaModel->getAllWithDetails();

    // Convertir reservas a canceladas si el usuario YA PAGÓ
    foreach ($reservas as &$r) {
        if ($r['estado_pago'] == 'Pago Cancelado') {
            $r['estado'] = 'Cancelada'; // FORZAR CANCELADA
        }
    }

    return view('admin/reservas', ['reservas' => $reservas]);
}


public function editar_reserva($id_reserva)
{
    $reservaModel = new ReservaModel();
    $reserva = $reservaModel->find($id_reserva);

    if (!$reserva) {
        throw new PageNotFoundException("Reserva no encontrada");
    }

    return view('admin/editar_reserva', ['reserva' => $reserva]);
}

public function actualizar_reserva($id_reserva)
{
    $reservaModel = new ReservaModel();

    $data = [
        'estado' => $this->request->getPost('estado'),
        'fecha_reserva' => $this->request->getPost('fecha_reserva')
    ];

    $reservaModel->update($id_reserva, $data);

    return redirect()->to(base_url('admin/reservas'))
        ->with('success', 'Reserva actualizada correctamente.');
}

public function eliminar_reserva($id_reserva)
{
    $reservaModel = new ReservaModel();
    $reservaModel->delete($id_reserva);

    return redirect()->to(base_url('admin/reservas'))
        ->with('success', 'Reserva eliminada correctamente.');
}
    // =========================
    // ➕ CREAR NUEVA CLASE
    // =========================
    public function crear_clase()
{
    if ($this->request->getMethod() === 'POST') {
        $claseModel = new ClaseModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'dia_semana' => $this->request->getPost('dia_semana'),
            'hora_inicio' => $this->request->getPost('hora_inicio'),
            'hora_fin' => $this->request->getPost('hora_fin'),
            'cupo_maximo' => $this->request->getPost('cupo_maximo'),
            'cupo_disponible' => $this->request->getPost('cupo_maximo'),
            'disponible' => 1,
            'id_rol' => 1,      // ← Probamos con 1 primero
            'id_planes' => 1    // ← Probamos con 1 primero
        ];

        try {
            $claseModel->insert($data);
            return redirect()->to(base_url('admin/clases'))
                ->with('success', 'Clase creada correctamente.');
        } catch (\Exception $e) {
            // Si falla, mostramos el error exacto
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    return view('admin/crear_clase');
}
}
