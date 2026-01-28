<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\ClaseModel;
use App\Models\ReservaModel;
use App\Models\PaqueteClasesModel;

class Usuario extends BaseController
{
    // =========================
    // 🔐 PROTECCIÓN ROL USUARIO
    // =========================
    public function __construct()
    {
        // Sólo usuarios con rol 3
        if (!session('logueado') || session('id_rol') != 3) {
            redirect()->to('/login')->send();
            exit;
        }
    }

    // =========================
    // 🏠 DASHBOARD USUARIO
    // =========================
    public function dashboard_usuario()
    {
        if (!session()->has('id_usuario') || session('id_rol') != 3) {
            return redirect()->to('/login');
        }

        $idUsuario = (int) session('id_usuario');

        $usuarioModel = new DatosUsuarioModel();
        $reservaModel = new ReservaModel();

        $usuario = $usuarioModel->find($idUsuario);
        $clases  = $reservaModel->getByUsuario($idUsuario);

        $clasesActivas = $reservaModel->countActivasByUsuario($idUsuario);

        $data = [
                    'usuario'       => $usuario,
                    'clasesActivas' => $clasesActivas,
                ];

        return view('usuarios/dashboard', $data);
    }

    // =========================
    // 📚 MIS CLASES
    // =========================
    public function mis_clases()
    {
        $reservaModel = new ReservaModel();
        $claseModel   = new ClaseModel();

        $idUsuario = (int) session()->get('id_usuario');

        $reservas = $reservaModel->getActivasByUsuario($idUsuario);

        $clases = [];
        foreach ($reservas as $reserva) {
            $claseData = $claseModel->getById($reserva['id_clases']);

            if (!$claseData) {
                continue;
            }

            // Para la vista: id de reserva (cancelar) y estado/fecha si quieres mostrarlos
            $claseData['id_reservas']  = $reserva['id_reservas'];
            $claseData['estado']       = $reserva['estado'] ?? null;
            $claseData['fecha_clase']  = $reserva['fecha_clase'] ?? null;
            $claseData['hora_inicio']  = $reserva['hora_inicio'] ?? null;

            $clases[] = $claseData;
        }

        return view('usuarios/mis_clases', ['clases' => $clases]);
    }

    // =========================
// 📅 LISTA PARA RESERVAR
public function reservar()
{
    $claseModel   = new \App\Models\ClaseModel();
    $reservaModel = new \App\Models\ReservaModel();
    $paqueteModel = new \App\Models\PaqueteClasesModel();

    $idUsuario = (int) session()->get('id_usuario');

    // ✅ Día seleccionado (viene de ?dia=Jueves, etc.)
    $dia = trim((string) $this->request->getGet('dia'));

    if ($dia) {
        $clases = $claseModel->where('dia_semana', $dia)
            ->orderBy('hora_inicio', 'ASC')
            ->findAll();
    } else {
        $clases = $claseModel->orderBy('dia_semana', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->findAll();
    }

    foreach ($clases as &$clase) {
        $fechaClase = $this->getNextDate($clase['dia_semana']);
        $clase['fecha_clase'] = $fechaClase;

        // ✅ OPCIÓN 1: ocultar si es HOY y ya pasó la hora de inicio
        if ($fechaClase === date('Y-m-d')) {
            $horaInicioClase = strtotime($fechaClase . ' ' . $clase['hora_inicio']);
            $horaActual      = time();

            if ($horaInicioClase <= $horaActual) {
                $clase['oculta'] = true;   // la ocultaremos en la vista
                continue;                  // no calculamos ya_reservada
            }
        }

        // ✅ Solo si NO está oculta, verificamos si ya fue reservada
        $clase['ya_reservada'] = $reservaModel->existeReserva(
            $idUsuario,
            $clase['id_clases'],
            $fechaClase
        );
    }
    unset($clase); // buena práctica al usar referencias (&)

    // ✅ Paquete del usuario (activo con saldo)
    $paquete = $paqueteModel->getActivoConSaldo($idUsuario);

    // ✅ fallback: si no hay activo, mostrar el último (opcional)
    if (!$paquete) {
        $paquete = $paqueteModel->getUltimoPaquete($idUsuario);
    }

    // ✅ Totales
    $consumidas = 0;
    $restantes  = 0;
    $total      = 0;

    if ($paquete) {
        $total      = (int) $paquete['total_clases'];
        $restantes  = (int) $paquete['clases_restantes'];
        $consumidas = max(0, $total - $restantes);
    }

    return view('usuarios/reservar', [
        'clases'     => $clases,
        'paquete'    => $paquete,
        'total'      => $total,
        'restantes'  => $restantes,
        'consumidas' => $consumidas,
    ]);
}

    // =========================
    // 👤 PERFIL
    // =========================
    public function perfil()
    {
        $usuarioModel = new DatosUsuarioModel();

        $id_usuario = (int) session()->get('id_usuario');
        if (!$id_usuario) {
            return redirect()->to(base_url('login'));
        }

        // OJO: tu DatosUsuarioModel debe tener getById(), si no, usa find()
        $usuario = method_exists($usuarioModel, 'getById')
            ? $usuarioModel->getById($id_usuario)
            : $usuarioModel->find($id_usuario);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        return view('usuarios/perfil', ['usuario' => $usuario]);
    }

    // =========================
    // ✅ HACER RESERVA (con paquete)
    // =========================
    public function hacer_reserva($id_clase)
{
    $claseModel   = new ClaseModel();
    $reservaModel = new ReservaModel();
    $paqueteModel = new PaqueteClasesModel();

    $idUsuario = (int) session()->get('id_usuario');
    if (!$idUsuario) {
        return redirect()->to('/login');
    }

    // 1️⃣ Obtener la clase
    $clase = $claseModel->getById($id_clase);
    if (!$clase) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Clase no encontrada');
    }

    // 🚫 Verificar disponible
    if ((int)$clase['disponible'] === 0) {
        return redirect()
            ->to(base_url('usuarios/reservar'))
            ->with('mensaje', 'Esta clase no está disponible actualmente.');
    }

    // 2️⃣ Calcular la próxima fecha de la clase
    $fechaClase = $this->getNextDate($clase['dia_semana']);

    // 2.1️⃣ Bloquear si es HOY y ya pasó la hora (refuerzo)
    if ($fechaClase === date('Y-m-d')) {
        $horaInicioTs = strtotime($fechaClase . ' ' . $clase['hora_inicio']);
        if ($horaInicioTs <= time()) {
            return redirect()
                ->to(base_url('usuarios/reservar'))
                ->with('mensaje', 'No puedes reservar una clase que ya inició.');
        }
    }

    // 3️⃣ Buscar paquete activo con saldo
    $paquete = $paqueteModel->getActivoConSaldo($idUsuario);
    if (!$paquete) {
        return redirect()
            ->to(base_url('usuarios/reservar'))
            ->with('mensaje', 'No tienes clases disponibles. Contacta al administrador.');
    }

    // 4️⃣ Verificar si ya existe reserva para esa clase en esa fecha
    if ($reservaModel->existeReserva($idUsuario, $id_clase, $fechaClase)) {
        return redirect()
            ->to(base_url('usuarios/mis_clases'))
            ->with('mensaje', 'Ya tienes una reserva para esta clase en esa fecha.');
    }

    // 5️⃣ Validar cupos por fecha y hora (solo validación)
    $horaInicio = new \DateTime($clase['hora_inicio']);
    $horaFin    = new \DateTime($clase['hora_fin']);

    $tmp = clone $horaInicio;
    while ($tmp < $horaFin) {
        $hora = $tmp->format('H:i:s');
        $cupos = $reservaModel->countByHoraYFecha($hora, $fechaClase);

        if ($cupos >= 8) {
            return redirect()
                ->to(base_url('usuarios/mis_clases'))
                ->with('mensaje', "La clase no se puede reservar porque el bloque de las $hora ya está lleno.");
        }

        $tmp->modify('+1 hour');
    }

    // ✅ 6️⃣ Crear reserva + consumir + reducir cupo (UNA sola vez)
    $db = db_connect();
    $db->transStart();

    $reservaId = $reservaModel->crearReserva([
        'id_usuario'  => $idUsuario,
        'id_clases'   => $id_clase,
        'fecha_clase' => $fechaClase,
        'hora_inicio' => $clase['hora_inicio'],
        'estado'      => 'Pendiente',
        'id_paquete'  => $paquete['id_paquete'],
        // 'clase_devuelta' => 0, // si agregas este campo luego
    ]);

    if (!$reservaId) {
        $db->transRollback();
        return redirect()
            ->to(base_url('usuarios/reservar'))
            ->with('mensaje', 'No se pudo crear la reserva.');
    }

    $ok = $paqueteModel->consumirUnaClase((int)$paquete['id_paquete']);
    if (!$ok) {
        $db->transRollback();
        return redirect()
            ->to(base_url('usuarios/reservar'))
            ->with('mensaje', 'No se pudo consumir la clase (sin saldo).');
    }

    $claseModel->reducirCupo($id_clase);

    $db->transComplete();

    // 7️⃣ Mostrar confirmación
    $clase['fecha_clase'] = $fechaClase;

    return view('usuarios/reserva_detalle', [
        'clase'   => $clase,
        'usuario' => $idUsuario
    ]);
}

    // =========================
    // ❌ CANCELAR RESERVA (regla 1 hora)
    // =========================
    public function cancelar_reserva($idReserva)
{
    $reservaModel = new ReservaModel();
    $claseModel   = new ClaseModel();
    $paqueteModel = new PaqueteClasesModel();

    $idUsuario = (int) session()->get('id_usuario');

    $reserva = $reservaModel->find($idReserva);
    if (!$reserva || (int)$reserva['id_usuario'] !== $idUsuario) {
        return redirect()->to(base_url('usuarios/mis_clases'))
            ->with('mensaje', 'Reserva no encontrada.');
    }

    if (in_array($reserva['estado'], ['Consumida','Completada'], true)) {
        return redirect()->to(base_url('usuarios/mis_clases'))
            ->with('mensaje', 'No puedes cancelar una clase ya realizada.');
    }

    $dtClase = new \DateTime($reserva['fecha_clase'] . ' ' . $reserva['hora_inicio']);
    $now     = new \DateTime();
    $limite  = (clone $dtClase)->modify('-1 hour');

    $nuevoEstado = ($now > $limite) ? 'Cancelada_Tarde' : 'Cancelada';

    $db = db_connect();
    $db->transStart();

    $reservaModel->update($idReserva, [
        'estado'       => $nuevoEstado,
        'cancelada_en' => date('Y-m-d H:i:s'),
    ]);

    // ✅ Devolver clase SOLO si canceló a tiempo y NO se ha devuelto antes
    if ($nuevoEstado === 'Cancelada' && (int)($reserva['clase_devuelta'] ?? 0) === 0) {
        $paqueteModel->devolverUnaClase((int)$reserva['id_paquete']);
        $reservaModel->update($idReserva, ['clase_devuelta' => 1]);
    }

    // Liberar cupo si aún no ha empezado
    if ($now < $dtClase) {
        $claseModel->incrementarCupo((int)$reserva['id_clases']);
    }

    $db->transComplete();

    return redirect()->to(base_url('usuarios/mis_clases'))
        ->with('mensaje',
            $nuevoEstado === 'Cancelada'
                ? 'Reserva cancelada correctamente.'
                : 'Cancelaste tarde: esta clase contará como usada.'
        );
}


    // =========================
    // ✏️ EDITAR PERFIL
    // =========================
    public function editarPerfil()
    {
        $idUsuario = (int) session()->get('id_usuario');

        $usuarioModel = new DatosUsuarioModel();
        $usuario = $usuarioModel->find($idUsuario);

        if (!$usuario) {
            return redirect()->to('usuarios/perfil')
                             ->with('error', 'No se encontró la información del usuario');
        }

        return view('usuarios/editar_perfil', ['usuario' => $usuario]);
    }

    public function actualizarPerfil()
    {
        $idUsuario = (int) session()->get('id_usuario');
        $usuarioModel = new DatosUsuarioModel();

        $valid = $this->validate([
            'nombre'   => 'required|min_length[2]|max_length[50]',
            'apellido' => 'required|min_length[2]|max_length[50]',
            'correo'   => 'required|valid_email|max_length[100]',
            'telefono' => 'permit_empty|max_length[20]',
            'genero'   => 'permit_empty|in_list[Masculino,Femenino,Otro]',
        ]);

        if (!$valid) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'correo'   => $this->request->getPost('correo'),
            'telefono' => $this->request->getPost('telefono'),
            'genero'   => $this->request->getPost('genero'),
        ];

        $usuarioModel->update($idUsuario, $data);

        return redirect()->to('usuarios/perfil')
            ->with('mensaje', 'Perfil actualizado correctamente.');
    }

    private function getNextDate($dayName)
{
    $days = [
        'domingo'    => 0,
        'lunes'      => 1,
        'martes'     => 2,
        'miércoles'  => 3,
        'miercoles'  => 3,
        'jueves'     => 4,
        'viernes'    => 5,
        'sábado'     => 6,
        'sabado'     => 6,
    ];

    $key = strtolower(trim($dayName));
    if (!isset($days[$key])) {
        return date('Y-m-d'); // fallback
    }

    $todayDayNum  = (int) date('w'); // 0=domingo
    $targetDayNum = (int) $days[$key];

    $daysToAdd = ($targetDayNum - $todayDayNum + 7) % 7; // ✅ 0 significa HOY

    return date('Y-m-d', strtotime("+$daysToAdd days"));
}

    public function mi_paquete()
{
    $idUsuario = session()->get('id_usuario');

    $paqueteModel = new \App\Models\PaqueteClasesModel();
    $reservaModel = new \App\Models\ReservaModel();

    // Paquete activo
    $paquete = $paqueteModel->where('id_usuario', $idUsuario)
                            ->where('estado', 'ACTIVO')
                            ->first();

    // Reservas del usuario
    $reservas = $reservaModel->where('id_usuario', $idUsuario)
                             ->orderBy('fecha_clase', 'DESC')
                             ->findAll();

    return view('usuarios/mi_paquete', [
        'paquete'  => $paquete,
        'reservas' => $reservas
    ]);
}

}
