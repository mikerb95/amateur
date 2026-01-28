<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class PaqueteClasesModel extends Model
{
    protected $table      = 'paquetes_clases';
    protected $primaryKey = 'id_paquete';

    protected $allowedFields = [
        'id_usuario',
        'total_clases',
        'clases_restantes',
        'fecha_inicio',
        'fecha_vencimiento',
        'estado',
        'creado_por'
    ];

    public function getActivoConSaldo(int $idUsuario)
{
    // primero marca vencidos por fecha (recomendado)
    $this->marcarVencidosPorFecha($idUsuario);

    return $this->where('id_usuario', $idUsuario)
        ->where('estado', 'ACTIVO')
        ->where('clases_restantes >', 0)
        ->where('fecha_inicio <=', new RawSql('NOW()'))
        ->where('fecha_vencimiento >=', new RawSql('NOW()'))
        ->orderBy('fecha_vencimiento', 'ASC')
        ->first();
}

    public function getUltimoPaquete(int $idUsuario)
    {
        return $this->where('id_usuario', $idUsuario)
            ->orderBy('id_paquete', 'DESC')
            ->first();
    }

   public function consumirUnaClase(int $idPaquete): bool
{
    $this->db->query("
        UPDATE paquetes_clases
        SET clases_restantes = clases_restantes - 1
        WHERE id_paquete = ?
          AND estado = 'ACTIVO'
          AND clases_restantes > 0
    ", [$idPaquete]);

    if ($this->db->affectedRows() !== 1) {
        return false;
    }

    $this->db->query("
        UPDATE paquetes_clases
        SET estado = 'AGOTADO'
        WHERE id_paquete = ?
          AND clases_restantes <= 0
    ", [$idPaquete]);

    return true;
}


    public function devolverUnaClase(int $idPaquete): bool
{
    $this->db->query("
        UPDATE paquetes_clases
        SET clases_restantes = clases_restantes + 1
        WHERE id_paquete = ?
    ", [$idPaquete]);

    return $this->db->affectedRows() === 1;
}

public function getByUsuario(int $idUsuario)
{
    return $this->where('id_usuario', $idUsuario)
        ->orderBy('id_paquete', 'DESC')
        ->findAll();
}

public function desactivarOtrosActivos(int $idUsuario, int $exceptId = 0)
{
    $builder = $this->builder();
    $builder->set('estado', 'VENCIDO')
        ->where('id_usuario', $idUsuario)
        ->where('estado', 'ACTIVO');

    if ($exceptId > 0) {
        $builder->where('id_paquete !=', $exceptId);
    }

    return $builder->update();
}


public function marcarVencidosPorFecha(int $idUsuario): int
{
    $this->db->query("
        UPDATE paquetes_clases
        SET estado = 'VENCIDO'
        WHERE id_usuario = ?
          AND estado = 'ACTIVO'
          AND fecha_vencimiento < NOW()
    ", [$idUsuario]);

    return $this->db->affectedRows();
}

public function getActivo(int $idUsuario)
{
    return $this->where('id_usuario', $idUsuario)
        ->where('estado', 'ACTIVO')
        ->orderBy('id_paquete', 'DESC')
        ->first();
}



}
