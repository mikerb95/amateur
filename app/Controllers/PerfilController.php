<?php

namespace App\Controllers;

use App\Models\PerfilModel;
use App\Models\DatosUsuarioModel;
use CodeIgniter\Controller;

class PerfilController extends Controller
{
    public function cambiar_contrasena()
    {
        $perfilModel = new PerfilModel();
        $datosUsuarioModel = new DatosUsuarioModel();

        // 1️⃣ Capturar datos del formulario
        $cedula = $this->request->getPost('cedula');
        $pass1 = $this->request->getPost('password');
        $pass2 = $this->request->getPost('password_confirm');

        // 2️⃣ Validar que coincidan
        if ($pass1 !== $pass2) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        // 3️⃣ Buscar usuario por CÉDULA en datos_usuarios
        $datosUsuario = $datosUsuarioModel->where('cedula', $cedula)->first();

        if (!$datosUsuario) {
            return redirect()->back()->with('error', 'La cédula no corresponde a ningún usuario.');
        }

        // 4️⃣ Obtener id_usuario para buscar su perfil
        $idUsuario = $datosUsuario['id_usuario'];

        $perfil = $perfilModel->where('id_usuario', $idUsuario)->first();

        if (!$perfil) {
            return redirect()->back()->with('error', 'No se encontró el perfil del usuario.');
        }

        // 5️⃣ Crear hash seguro de la nueva contraseña
        $nuevoHash = password_hash($pass1, PASSWORD_DEFAULT);

        // 6️⃣ Actualizar la contraseña en la tabla perfil
        $perfilModel->update($perfil['id_perfil'], [
            'contraseña' => $nuevoHash
        ]);

        // 7️⃣ Redirigir con éxito
        return redirect()->to(base_url('login'))->with('success', 'Contraseña actualizada correctamente.');
    }
}
