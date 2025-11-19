<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservaModel extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id_reservas';

    protected $allowedFields = [
        'id_usuario',
        'id_clases',
        'fecha_reserva'
    ];

    // Crear una nueva reserva
    public function crearReserva($idUsuario, $idClase)
    {
        return $this->insert([
            'id_usuario' => $idUsuario,
            'id_clases'  => $idClase
        ]);
    }

    // Obtener reservas por usuario
    public function getByUsuario($idUsuario)
    {
        return $this->where('id_usuario', $idUsuario)->findAll();
    }

    public function existeReserva($idUsuario, $idClase)
    {
        return $this->where('id_usuario', $idUsuario)
                ->where('id_clases', $idClase)
                ->countAllResults() > 0;
    }


}
