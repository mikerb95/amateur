<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\PerfilModel;
use App\Models\ClaseModel;
use App\Models\PagoModel;
use App\Models\ReservaModel;
use App\Models\PlanModel;
use App\Models\PagoModel;
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
    public function dashboard_admin()
    {
        if (!session()->has('id_usuario') || session('id_rol') != 1) {
            return redirect()->to('/login');
        }

        // 📊 Cargar modelos
        $usuarioModel = new DatosUsuarioModel();
        $claseModel = new ClaseModel();
        $reservaModel = new ReservaModel();

        // 📈 Datos para el dashboard
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

        // obtener plan asignado (CORREGIR si es necesario)
        $plan = $planModel->first(); // Solo toma el primer plan disponible
        $u['plan'] = $plan ? $plan['nombre'] : 'Sin plan asignado';

        // estado del pago - CORREGIDO
        $pago = $pagoModel->where('id_usuario', $u['id_usuario'])->first();
        $u['estado_pago'] = $pago ? $pago['estado'] : 'Pago Pendiente';
        
        // DEBUG: Verificar los datos
        // echo "Usuario: {$u['nombre']} - Estado: {$u['estado_pago']}<br>";
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
        $pagoModel = new PagoModel();

        // 1️⃣ Buscar usuario
        $usuario = $usuarioModel->find($id);
        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Usuario no encontrado");
        }

        // 2️⃣ Datos personales del formulario
        $nombre   = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $cedula   = $this->request->getPost('cedula');
        $estado   = $this->request->getPost('estado');

        // 3️⃣ Validaciones básicas
        if (empty($nombre) || empty($apellido) || empty($cedula) || empty($estado)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // 4️⃣ Validar que la cédula no esté repetida
        $usuarioExistente = $usuarioModel->where('cedula', $cedula)
            ->where('id_usuario !=', $id)
            ->first();
        if ($usuarioExistente) {
            return redirect()->back()->with('error', 'La cédula ya está registrada en otro usuario.');
        }

<<<<<<< HEAD
        $dataUsuario = [
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'cedula'   => $cedula
        ];
        $usuarioModel->update($id, $dataUsuario);

        return redirect()->to(base_url('admin/usuarios'))
                         ->with('mensaje', 'Usuario actualizado correctamente.');
    }

=======
        // 5️⃣ Validar estado del pago
        $estadosPermitidos = ['Pago Pendiente', 'Pago Cancelado'];
        if (!in_array($estado, $estadosPermitidos)) {
            return redirect()->back()->with('error', 'Estado de pago no válido.');
        }

        try {
            // 6️⃣ Actualizar datos del usuario
            $dataUsuario = [
                'nombre'   => $nombre,
                'apellido' => $apellido,
                'cedula'   => $cedula
            ];
            $usuarioModel->update($id, $dataUsuario);

            // 7️⃣ Actualizar o crear estado de pago
            $pagoExistente = $pagoModel->where('id_usuario', $id)->first();

            if ($pagoExistente) {
                // Actualizar pago existente
                $pagoModel->update($pagoExistente['id_pago'], ['estado' => $estado]);
            } else {
                // Crear nuevo registro de pago
                $pagoModel->insert([
                    'id_usuario' => $id,
                    'estado' => $estado
                ]);
            }

            // 8️⃣ Redirigir con mensaje de éxito
            return redirect()->to(base_url('admin/usuarios'))
                ->with('success', 'Usuario y estado de pago actualizados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    // =========================
    // 🗑️ ELIMINAR USUARIO
    // =========================
    public function eliminar_usuario($id = null)
    {
        $usuarioModel = new DatosUsuarioModel();
        $pagoModel = new PagoModel();
        $perfilModel = new PerfilModel();

        try {
            // Eliminar registros relacionados primero
            $pagoModel->where('id_usuario', $id)->delete();
            $perfilModel->where('id_usuario', $id)->delete();

            // Eliminar usuario
            $usuarioModel->delete($id);

            return redirect()->to(base_url('admin/usuarios'))
                ->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar usuario: ' . $e->getMessage());
        }
    }

>>>>>>> ced6962d8cb9bb40c7590e20f325025340b661cb
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
<<<<<<< HEAD
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
=======
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
    
    // Usar el método corregido que incluye los joins
    $reservas = $reservaModel->getAllWithDetails();

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
>>>>>>> ced6962d8cb9bb40c7590e20f325025340b661cb
}
