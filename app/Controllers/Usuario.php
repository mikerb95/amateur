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
    public function dashboard_usuario()
    {
        $usuarioModel = new DatosUsuarioModel();
        $reservaModel = new ReservaModel();

        // Usuario temporal (hasta implementar login)
        $idUsuario = 1;
        $usuario = $usuarioModel->find($idUsuario);
        $clases = $reservaModel->getByUsuario($idUsuario);

        $data = [
            'usuario' => $usuario,
            'clasesActivas' => count($clases)
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

    $idUsuario = 1; // temporal

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




    // =========================
    // 🗓️ RESERVAR NUEVAS CLASES
    // =========================
    public function reservar()
    {
        $claseModel = new ClaseModel();
        $clases = $claseModel->getDisponibles();

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

    $idUsuario = 1; // temporal

    $clase = $claseModel->getById($id_clase);

    if (!$clase) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Clase no encontrada');
    }

    // 🛑 1. Verificar si ya existe reserva
    if ($reservaModel->existeReserva($idUsuario, $id_clase)) {
        // Ya existe: redirigimos con mensaje
        return redirect()
            ->to(base_url('usuarios/mis_clases'))
            ->with('mensaje', 'Ya tienes una reserva para esta clase.');
    }

    // ✅ 2. Crear reserva
    $reservaModel->crearReserva($idUsuario, $id_clase);

    // ✅ 3. Reducir cupo
    $claseModel->reducirCupo($id_clase);

    // ✅ 4. Mostrar confirmación
    return view('usuarios/reserva_detalle', [
        'clase'   => $clase,
        'usuario' => $idUsuario
    ]);
}

public function cancelar_reserva($idReserva)
{
    $reservaModel = new ReservaModel();
    $claseModel = new ClaseModel();

    // Usuario temporal
    $idUsuario = 1;

    // Buscar la reserva
    $reserva = $reservaModel->find($idReserva);

    if (!$reserva || $reserva['id_usuario'] != $idUsuario) {
        return redirect()
            ->to(base_url('usuarios/mis_clases'))
            ->with('mensaje', 'Reserva no encontrada.');
    }

    // Traer la clase asociada
    $idClase = $reserva['id_clases'];

    // 1. Eliminar reserva
    $reservaModel->delete($idReserva);

    // 2. Incrementar cupo
    $claseModel->incrementarCupo($idClase);

    return redirect()
        ->to(base_url('usuarios/mis_clases'))
        ->with('mensaje', 'Reserva cancelada correctamente.');
}




}
