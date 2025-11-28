<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table      = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $allowedFields = [
        'id_usuario',
        'estado'
    ];

    protected $useTimestamps = false;

    // Obtener pago por usuario
    public function getPagoByUsuario($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->first();
    }

    // Actualizar estado de pago
    public function actualizarEstado($id_usuario, $estado)
    {
        $pago = $this->where('id_usuario', $id_usuario)->first();
        
        if ($pago) {
            return $this->update($pago['id_pago'], ['estado' => $estado]);
        } else {
            return $this->insert([
                'id_usuario' => $id_usuario,
                'estado' => $estado
            ]);
        }
    }
}