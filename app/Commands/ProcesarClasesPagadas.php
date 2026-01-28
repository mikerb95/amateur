<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\I18n\Time;

class ProcesarClasesPagadas extends BaseCommand
{
    protected $group       = 'Amateur';
    protected $name        = 'amateur:procesar-clases';
    protected $description = 'Vence paquetes por fecha y consume reservas pasadas (regla 1 hora).';

    public function run(array $params)
    {
        // Hora Colombia
        $now = Time::now('America/Bogota')->toDateTimeString();

        $db = \Config\Database::connect();

        // 1) Vencer paquetes (mensual)
        $db->query("
            UPDATE paquetes_clases
            SET estado = 'VENCIDO', clases_restantes = 0
            WHERE estado = 'ACTIVO'
              AND fecha_vencimiento < ?
        ", [$now]);

        // 2) Reservas que ya pasaron y no han sido consumidas
        $reservas = $db->query("
            SELECT r.id_reservas, r.id_paquete, r.estado, r.fecha_clase, r.hora_inicio
            FROM reservas r
            LEFT JOIN consumo_clases cc ON cc.id_reservas = r.id_reservas
            WHERE cc.id_reservas IS NULL
              AND r.id_paquete IS NOT NULL
              AND r.fecha_clase IS NOT NULL
              AND r.hora_inicio IS NOT NULL
              AND TIMESTAMP(r.fecha_clase, r.hora_inicio) <= ?
              AND r.estado IN ('Pendiente','Confirmada','Completada','Cancelada_Tarde')
        ", [$now])->getResultArray();

        $consumidas = 0;
        $saltadas   = 0;

        foreach ($reservas as $r) {
            $idReserva  = (int) $r['id_reservas'];
            $idPaquete  = (int) $r['id_paquete'];
            $estado     = $r['estado'];

            $motivo = ($estado === 'Completada') ? 'ASISTIO' : 'NO_CANCELO_A_TIEMPO';

            $db->transStart();

            // Insert consumo (si corre dos veces, IGNORE evita error por UNIQUE)
            $db->query("
                INSERT IGNORE INTO consumo_clases (id_reservas, id_paquete, motivo, descontado_en)
                VALUES (?, ?, ?, ?)
            ", [$idReserva, $idPaquete, $motivo, $now]);

            // Restar del paquete si está activo y con saldo
            $db->query("
                UPDATE paquetes_clases
                SET clases_restantes = clases_restantes - 1
                WHERE id_paquete = ?
                  AND estado = 'ACTIVO'
                  AND clases_restantes > 0
            ", [$idPaquete]);

            // Si llegó a 0, marcar agotado
            $db->query("
                UPDATE paquetes_clases
                SET estado = 'AGOTADO', clases_restantes = 0
                WHERE id_paquete = ?
                  AND clases_restantes <= 0
                  AND estado = 'ACTIVO'
            ", [$idPaquete]);

            // Marcar reserva como consumida
            $db->query("
                UPDATE reservas
                SET estado = 'Consumida'
                WHERE id_reservas = ?
            ", [$idReserva]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                $saltadas++;
                continue;
            }

            $consumidas++;
        }

        CLI::write("Fecha/Hora ejecución (Bogotá): $now");
        CLI::write("Reservas consumidas: $consumidas");
        CLI::write("Reservas saltadas (error): $saltadas");
        CLI::write("OK");
    }
}
