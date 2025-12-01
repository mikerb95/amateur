<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\ClaseModel;
use App\Models\ReservaModel;

class Usuario extends BaseController
{
    // =========================
    // 🏠 DASHBOARD USUARIO
    // =========================

     public function __construct()
    {
        // Sólo usuarios con rol 3
        if (!session('logueado') || session('id_rol') != 3) {
            redirect()->to('/login')->send();
            exit;
        }
    }
    public function dashboard_usuario()
    {
    if(!session()->has('id_usuario') || session('id_rol') != 3){
        return redirect()->to('/login');
    }

    // ⚙️ Obtener ID del usuario desde la sesión
    $idUsuario = session('id_usuario');

    // 📊 Cargar modelos
    $usuarioModel = new DatosUsuarioModel();
    $reservaModel = new ReservaModel();

    // 📌 Obtener datos del usuario y sus clases
    $usuario = $usuarioModel->find($idUsuario);
    $clases  = $reservaModel->getByUsuario($idUsuario);

    // 📦 Datos para la vista
    $data = [
        'usuario'       => $usuario,
        'clasesActivas' => count($clases),
    ];

    return view('usuarios/dashboard', $data);
    }


    // =========================
    // 📚 MIS CLASES
    // =========================
public function mis_clases()
{
    $reservaModel = new \App\Models\ReservaModel();
    $claseModel   = new \App\Models\ClaseModel();

    $idUsuario = session()->get('id_usuario');

    // Obtener reservas
    $reservas = $reservaModel->getByUsuario($idUsuario);

    // Construir lista con info completa
    $clases = [];

    foreach ($reservas as $reserva) {
        $claseData = $claseModel->getById($reserva['id_clases']);
        $claseData['id_reservas'] = $reserva['id_reservas']; // ⭐ NECESARIO PARA CANCELAR
        $clases[] = $claseData;
    }

    return view('usuarios/mis_clases', ['clases' => $clases]);
}


public function reservar()
{
    $claseModel = new ClaseModel();
    $clases = $claseModel->orderBy('dia_semana')->orderBy('hora_inicio')->findAll();
    // Calcular fecha próxima para cada clase
    foreach ($clases as &$clase) {
        $clase['fecha_clase'] = $this->getNextDate($clase['dia_semana']);
    }

    return view('usuarios/reservar', ['clases' => $clases]);
}

    // =========================
    // 👤 PERFIL DEL USUARIO
    // =========================
    public function perfil()
{
    $usuarioModel = new \App\Models\DatosUsuarioModel();

    // Obtener ID del usuario desde sesión
    $id_usuario = session()->get('id_usuario');

    if (!$id_usuario) {
        // Redirigir a login si no hay sesión
        return redirect()->to(base_url('login'));
    }

    // Obtener usuario desde BD
    $usuario = $usuarioModel->getById($id_usuario);

    if (!$usuario) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
    }

    return view('usuarios/perfil', ['usuario' => $usuario]);
}

public function hacer_reserva($id_clase)
{
    $claseModel   = new ClaseModel();
    $reservaModel = new ReservaModel();

    $idUsuario = session()->get('id_usuario');
    if (!$idUsuario) {
        return redirect()->to('/login');
    }

    // 1️⃣ Obtener la clase
    $clase = $claseModel->getById($id_clase);

    if (!$clase) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Clase no encontrada');
    }

    // 🚫 1.1 Verificar si está disponible
    if ($clase['disponible'] == 0) {
        return redirect()
            ->to(base_url('usuarios/reservar'))
            ->with('mensaje', 'Esta clase no está disponible actualmente.');
    }

    // 2️⃣ Verificar si ya existe reserva del usuario
    if ($reservaModel->existeReserva($idUsuario, $id_clase)) {
        return redirect()
            ->to(base_url('usuarios/mis_clases'))
            ->with('mensaje', 'Ya tienes una reserva para esta clase.');
    }

    // 3️⃣ Calcular la próxima fecha de la clase
    $fechaClase = $this->getNextDate($clase['dia_semana']);

    // 4️⃣ Calcular horas de duración
    $horaInicio = new \DateTime($clase['hora_inicio']);
    $horaFin    = new \DateTime($clase['hora_fin']);

    $horasOcupadas = [];
    $tmp = clone $horaInicio;
    while ($tmp < $horaFin) {
        $horasOcupadas[] = $tmp->format('H:i:s');
        $tmp->modify('+1 hour');
    }

    // 5️⃣ Validar cupos por fecha y hora
    foreach ($horasOcupadas as $hora) {
        $cupos = $reservaModel->countByHoraYFecha($hora, $fechaClase);

        if ($cupos >= 8) {
            return redirect()
                ->to(base_url('usuarios/mis_clases'))
                ->with('mensaje', "La clase no se puede reservar porque el bloque de las $hora ya está lleno.");
        }
    }

    // 6️⃣ Registrar reserva
    $reservaModel->crearReserva([
        'id_usuario'     => $idUsuario,
        'id_clases'      => $id_clase,
        'fecha_reserva'  => $fechaClase
    ]);

    // 7️⃣ Reducir cupo disponible
    $claseModel->reducirCupo($id_clase);

    // 8️⃣ Agregar fecha a la clase
    $clase['fecha_clase'] = $fechaClase;

    // 9️⃣ Mostrar confirmación
    return view('usuarios/reserva_detalle', [
        'clase'   => $clase,
        'usuario' => $idUsuario
    ]);
}


    // ========================
    // Función privada para obtener próxima fecha del día de la semana
    // ========================
    private function getNextDate($dayName)
    {
        $days = ['domingo'=>0,'lunes'=>1,'martes'=>2,'miércoles'=>3,'jueves'=>4,'viernes'=>5,'sábado'=>6];

        $today = date('Y-m-d');
        $todayDayNum = date('w'); // 0=domingo, 1=lunes, ...
        $targetDayNum = $days[strtolower($dayName)];

        $daysToAdd = ($targetDayNum - $todayDayNum + 7) % 7;
        if ($daysToAdd == 0) $daysToAdd = 7; // siguiente semana si es hoy

        return date('Y-m-d', strtotime("+$daysToAdd days"));
    }


public function cancelar_reserva($idReserva)
{
    $reservaModel = new ReservaModel();
    $claseModel   = new ClaseModel();

    $idUsuario = session()->get('id_usuario');


    $reserva = $reservaModel->find($idReserva);

    if (!$reserva || $reserva['id_usuario'] != $idUsuario) {
        return redirect()->to(base_url('usuarios/mis_clases'))
                         ->with('mensaje', 'Reserva no encontrada.');
    }

    $idClase = $reserva['id_clases'];

    // ✅ Solo eliminar la reserva, no la clase
    $reservaModel->delete($idReserva);

    // ✅ Incrementar cupo disponible
    $claseModel->incrementarCupo($idClase);

    return redirect()->to(base_url('usuarios/mis_clases'))
                     ->with('mensaje', 'Reserva cancelada correctamente.');
}

public function editarPerfil()
    {
        $idUsuario = session()->get('id_usuario'); // lo que guardaste al hacer login

        $usuarioModel = new DatosUsuarioModel();
        $usuario = $usuarioModel->find($idUsuario);

        if (!$usuario) {
            // Por si acaso no encuentra nada
            return redirect()->to('usuarios/perfil')
                             ->with('error', 'No se encontró la información del usuario');
        }

        return view('usuarios/editar_perfil', ['usuario' => $usuario]);
    }

    public function actualizarPerfil()
    {
        $idUsuario = session()->get('id_usuario');
        $usuarioModel = new DatosUsuarioModel();

        // 1. Validar datos
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

        // 2. Construir arreglo SOLO con los campos editables (SIN cédula)
        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'correo'   => $this->request->getPost('correo'),
            'telefono' => $this->request->getPost('telefono'),
            'genero'   => $this->request->getPost('genero'),
        ];

        // 3. Actualizar en BD
        $usuarioModel->update($idUsuario, $data);

        // 4. Volver a la vista de perfil
        return redirect()->to('usuarios/perfil')
            ->with('mensaje', 'Perfil actualizado correctamente.');
    }



}
