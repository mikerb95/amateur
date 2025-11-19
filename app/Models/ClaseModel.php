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
        'id_rol',
        'id_planes'
    ];

    protected $useTimestamps = false;

    // Obtener todas
    public function getAll()
    {
        return $this->findAll();
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    // =========================
    // 🟢 NUEVO: Obtener clases con cupos disponibles
    // =========================
    public function getDisponibles()
    {
        $clases = $this->where('cupo_disponible >', 0)
                       ->orderBy('dia_semana', 'ASC')
                        ->orderBy('hora_inicio', 'ASC') // ordenar por hora
                       ->findAll();

        // Transformar para la vista
        foreach ($clases as &$clase) {
            $clase['dia'] = $clase['dia_semana'];
            $clase['hora'] = $clase['hora_inicio'];
            $clase['cupos'] = $clase['cupo_disponible'];
        }

        return $clases;
    }

    // =========================
    // Cupos
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

    public function incrementarCupo($id)
    {
        $clase = $this->find($id);
        if ($clase && $clase['cupo_disponible'] < $clase['cupo_maximo']) {
            $clase['cupo_disponible']++;
            return $this->update($id, $clase);
        }
        return false;
    }
}