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

    public function getAll()
{
    return $this->select('
            reservas.id_reservas      AS id,
            datos_usuarios.nombre     AS usuario_nombre,
            clases.nombre             AS clase_nombre,
            reservas.fecha_reserva    AS fecha_reserva,
            "Activa"                  AS estado
        ')
        ->join('datos_usuarios', 'datos_usuarios.id_usuario = reservas.id_usuario')
        ->join('clases', 'clases.id_clases = reservas.id_clases')
        ->findAll();
}


}
