<?php

namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\PagoModel;

class Pagos extends BaseController
{
    public function index()
    {
        return view('admin/pagos', [
            'usuario' => null,
            'pago'    => null
        ]);
    }

    public function buscar()
{
    $cedula = $this->request->getPost('cedula');

    $usuarioModel = new DatosUsuarioModel();
    $pagoModel    = new PagoModel();

    $usuario = $usuarioModel->where('cedula', $cedula)->first();

    if (!$usuario) {
        return redirect()->back()->with('mensaje', 'No existe un usuario con esa cédula.');
    }

    // Traer SIEMPRE el último pago del usuario
    $pago = $pagoModel->getPagoByUsuario($usuario['id_usuario']);

    return view('admin/pagos', [
        'usuario' => $usuario,
        'pago'    => $pago
    ]);
}

    public function guardar()
{
    $pagoModel = new PagoModel();

    $idUsuario = $this->request->getPost('id_usuario');
    $estado    = $this->request->getPost('estado'); // "Pago Pendiente" o "Pago Cancelado"

    if (!$idUsuario || !$estado) {
        return redirect()->back()->with('mensaje', 'Faltan datos para actualizar el pago.');
    }

    // Usa el método del modelo que actualiza o crea
    $pagoModel->actualizarEstado($idUsuario, $estado);

    return redirect()->to(base_url('admin/usuarios'))
    ->with('success', 'Estado de pago actualizado correctamente.');

}
}