<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    protected $table = 'planes';
    protected $primaryKey = 'id_planes';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'total_clases'
    ];

    protected $useTimestamps = false;
}
