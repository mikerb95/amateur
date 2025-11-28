<?php

namespace App\Models;

use CodeIgniter\Model;

class ClaseModel extends Model
{
    protected $table = 'clases';
    protected $primaryKey = 'id_clases';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'cupo_maximo',
        'cupo_disponible',
        'disponible',
        'id_rol',
        'id_planes'
    ];

    protected $useTimestamps = false;

    // =========================
    // Obtener todas las clases
    // =========================
    public function getAll()
    {
        return $this->findAll();
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    // =========================
    // Clases con cupos disponibles
    // =========================
   public function getDisponibles()
{
    $clases = $this->where('disponible', 1)                 // ✔️ Solo clases activas
                   ->where('cupo_disponible >', 0)          // ✔️ Con cupos
                   ->orderBy('dia_semana', 'ASC')
                   ->orderBy('hora_inicio', 'ASC')
                   ->findAll();

    foreach ($clases as &$clase) {
        $clase['dia'] = $clase['dia_semana'];
        $clase['hora'] = $clase['hora_inicio'];
        $clase['cupos'] = $clase['cupo_disponible'];
    }

    return $clases;
}


    // =========================
    // Reducir cupo global (opcional)
    // =========================
    public function reducirCupo($id)
    {
        $clase = $this->find($id);
        if ($clase && $clase['cupo_disponible'] > 0) {
            $clase['cupo_disponible']--;
            return $this->update($id, $clase);
        }
        return false;
    }

    // =========================
    // Incrementar cupo global (opcional)
    // =========================
    public function incrementarCupo($id)
    {
        $clase = $this->find($id);
        if ($clase && $clase['cupo_disponible'] < $clase['cupo_maximo']) {
            $clase['cupo_disponible']++;
            return $this->update($id, $clase);
        }
        return false;
    }

    // =========================
    // Nueva función: validar cupos por fecha
    // =========================
    public function tieneCupo($idClase, $fecha, $reservaModel)
    {
        $clase = $this->find($idClase);
        if (!$clase) return false;

        // Contar reservas para la fecha
        $reservasEnFecha = $reservaModel->where('id_clases', $idClase)
                                        ->where('fecha_reserva', $fecha)
                                        ->countAllResults();

        return $reservasEnFecha < $clase['cupo_maximo'];
    }
}
