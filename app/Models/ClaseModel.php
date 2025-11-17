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
    public function getAll($id_clases)
    {
        return $this->findAll($id_clases);
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    // Cupos
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
