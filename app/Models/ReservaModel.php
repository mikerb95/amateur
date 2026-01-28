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
    'fecha_reserva',   // cuándo reservó (timestamp)
    'fecha_clase',     // NUEVO: fecha real de la clase
    'hora_inicio',     // NUEVO: hora real (congelada)
    'estado',
    'cancelada_en',    // NUEVO
    'id_paquete',      // NUEVO
    'clase_devuelta'
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
   public function existeReserva($idUsuario, $idClase, $fechaClase)
{
    return $this->where('id_usuario', $idUsuario)
                ->where('id_clases', $idClase)
                ->where('fecha_clase', $fechaClase)
                ->whereNotIn('estado', ['Cancelada']) // si canceló a tiempo, que pueda reservar de nuevo
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
 public function countByHoraYFecha($hora, $fechaClase)
{
    return $this->join('clases', 'clases.id_clases = reservas.id_clases')
                ->where('reservas.fecha_clase', $fechaClase)
                ->where('clases.hora_inicio <=', $hora)
                ->where('clases.hora_fin >', $hora)
                ->whereIn('reservas.estado', ['Pendiente','Confirmada','Completada']) // canceladas no ocupan cupo
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

    // Si ya fue consumida o completada, no se puede cancelar
    if (in_array($reserva['estado'], ['Consumida','Completada'], true)) {
        return redirect()->to(base_url('usuarios/mis_clases'))
                         ->with('mensaje', 'No puedes cancelar una clase ya realizada.');
    }

    // Calcular fecha y hora real de la clase
    $dtClase = new \DateTime($reserva['fecha_clase'] . ' ' . $reserva['hora_inicio']);
    $now     = new \DateTime();

    // Límite de cancelación (1 hora antes)
    $limite = (clone $dtClase)->modify('-1 hour');

    // Determinar estado según regla
    $nuevoEstado = ($now > $limite) ? 'Cancelada_Tarde' : 'Cancelada';

    // Actualizar reserva (NO borrar)
    $reservaModel->update($idReserva, [
        'estado'       => $nuevoEstado,
        'cancelada_en' => date('Y-m-d H:i:s'),
    ]);

    // Liberar cupo solo si la clase aún no empieza
    if ($now < $dtClase) {
        $claseModel->incrementarCupo($reserva['id_clases']);
    }

    return redirect()->to(base_url('usuarios/mis_clases'))
        ->with('mensaje',
            $nuevoEstado === 'Cancelada'
            ? 'Reserva cancelada correctamente.'
            : 'Cancelaste tarde: esta clase contará como usada.'
        );
}

public function getActivasByUsuario($idUsuario)
{
    return $this->where('id_usuario', $idUsuario)
        ->whereIn('estado', ['Pendiente','Confirmada']) // ✅ SOLO ACTIVAS
        ->orderBy('fecha_clase', 'ASC')
        ->orderBy('hora_inicio', 'ASC')
        ->findAll();
}


public function countActivasByUsuario($idUsuario)
{
    return $this->where('id_usuario', $idUsuario)
        ->whereIn('estado', ['Pendiente','Confirmada']) // ✅ SOLO activas
        ->countAllResults();
}


}
