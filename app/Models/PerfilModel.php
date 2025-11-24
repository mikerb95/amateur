<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model
{
    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';
    protected $allowedFields = [
        'nombre_usuario',
        'contraseña',
        'id_rol',
        'id_usuario'
    ];


 public function login($usuario, $password)
{
    $data = $this->where('nombre_usuario', $usuario)->first();

    if (!$data) {
        return false;
    }

    // Si la contraseña está en texto plano
    if ($data['contraseña'] === $password) {
        return $data;
    }

    // Si está en hash (usuarios normales)
    if (password_verify($password, $data['contraseña'])) {
        return $data;
    }

    return false;
}

}