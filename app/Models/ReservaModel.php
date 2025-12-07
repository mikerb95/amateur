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
        'fecha_reserva',
        'estado'
    ];

    // =========================
    // Crear una nueva reserva
    // =========================
    public function crearReserva($data)
    {
        return $this->insert($data);
    }

    // =========================
    // Obtener reservas por usuario
    // =========================
    public function getByUsuario($idUsuario)
    {
        return $this->where('id_usuario', $idUsuario)->findAll();
    }

    // =========================
    // Validar si ya existe reserva del usuario para esa clase
    // =========================
    public function existeReserva($idUsuario, $idClase)
    {
        return $this->where('id_usuario', $idUsuario)
                    ->where('id_clases', $idClase)
                    ->countAllResults() > 0;
    }

    // =========================
    // Obtener todas las reservas con info de usuario y clase
    // =========================
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

    // =========================
    // Contar reservas por hora (opcional, sin fecha)
    // =========================
    public function countByHora($horaInicio)
    {
        return $this->join('clases', 'clases.id_clases = reservas.id_clases')
                    ->where('clases.hora_inicio', $horaInicio)
                    ->countAllResults();
    }

    // =========================
    // Contar reservas por hora y por fecha
    // =========================
    public function countByHoraYFecha($hora, $fecha)
    {
        return $this->join('clases', 'clases.id_clases = reservas.id_clases')
                    ->where('clases.hora_inicio <=', $hora)
                    ->where('clases.hora_fin >', $hora)
                    ->where('reservas.fecha_reserva', $fecha)
                    ->countAllResults();
    }
public function getAllWithDetails()
{
    return $this->select('reservas.*, datos_usuarios.nombre AS usuario_nombre,
                          datos_usuarios.apellido AS usuario_apellido,
                          datos_usuarios.cedula,
                          clases.nombre AS clase_nombre,
                          pagos.estado AS estado_pago')
        ->join('datos_usuarios', 'datos_usuarios.id_usuario = reservas.id_usuario')
        ->join('clases', 'clases.id_clases = reservas.id_clases')
        ->join('pagos', 'pagos.id_usuario = reservas.id_usuario', 'left')
        ->findAll();
}

}
