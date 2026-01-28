<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    protected $table      = 'planes';
    protected $primaryKey = 'id_planes';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'total_clases',
        'duracion_dias',
        'estado',
        'created_at',
        'updated_at'
    ];

    // ✅ timestamps (porque tu tabla sí tiene created_at y updated_at)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ✅ Validaciones (opcional, útil si haces CRUD de planes)
    protected $validationRules = [
        'nombre'        => 'required|min_length[3]|max_length[100]',
        'precio'        => 'required|decimal',
        'total_clases'  => 'required|is_natural',
        'duracion_dias' => 'required|is_natural_no_zero',
        'estado'        => 'permit_empty|in_list[ACTIVO,INACTIVO]'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del plan es obligatorio.',
            'min_length' => 'Debe tener mínimo 3 caracteres.',
            'max_length' => 'Máximo 100 caracteres.'
        ],
        'precio' => [
            'required' => 'El precio es obligatorio.',
            'decimal'  => 'El precio debe ser un número válido.'
        ],
        'total_clases' => [
            'required'   => 'Debes indicar cuántas clases incluye.',
            'is_natural' => 'Debe ser un número válido.'
        ],
        'duracion_dias' => [
            'required'          => 'Debes indicar la duración del plan.',
            'is_natural_no_zero'=> 'Debe ser mayor a 0.'
        ],
        'estado' => [
            'in_list' => 'El estado debe ser ACTIVO o INACTIVO.'
        ]
    ];
}
