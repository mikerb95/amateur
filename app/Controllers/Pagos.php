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
        $pagoModel = new PagoModel();

        $usuario = $usuarioModel->where('cedula', $cedula)->first();

        if (!$usuario) {
            return redirect()->back()->with('mensaje', 'No existe un usuario con esa cédula.');
        }

        $pago = $pagoModel->where('id_usuario', $usuario['id_usuario'])->first();

        return view('admin/pagos', [
            'usuario' => $usuario,
<<<<<<< HEAD
            'pago' => $pago
=======
            'pago'    => $pago
>>>>>>> ced6962d8cb9bb40c7590e20f325025340b661cb
        ]);
    }

    public function guardar()
    {
        $pagoModel = new PagoModel();

        $data = [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'estado'     => $this->request->getPost('estado')
        ];

<<<<<<< HEAD
=======
        // Insertar o actualizar automáticamente
>>>>>>> ced6962d8cb9bb40c7590e20f325025340b661cb
        $pagoModel->save($data);

        return redirect()->to(base_url('admin/usuarios'));
    }
}
