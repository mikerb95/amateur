<?php
namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table      = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $allowedFields = [
        'id_usuario',
        'estado',
        'fecha_pago', // opcional, si quieres actualizarla manualmente
    ];

    protected $useTimestamps = false;

    // Obtener el ÚLTIMO pago por usuario
    public function getPagoByUsuario($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)
                    ->orderBy('id_pago', 'DESC') // <- importante
                    ->first();
    }

    // Actualizar estado de pago (sobre el último registro o crear uno nuevo)
    public function actualizarEstado($id_usuario, $estado)
    {
        $pago = $this->where('id_usuario', $id_usuario)
                     ->orderBy('id_pago', 'DESC')
                     ->first();
        
        $data = [
            'id_usuario' => $id_usuario,
            'estado'     => $estado,
            'fecha_pago' => date('Y-m-d H:i:s'), // para registrar cuándo se cambió
        ];

        if ($pago) {
            // Actualiza el último registro
            return $this->update($pago['id_pago'], $data);
        } else {
            // Crea uno nuevo si no tiene
            return $this->insert($data);
        }
    }
}
