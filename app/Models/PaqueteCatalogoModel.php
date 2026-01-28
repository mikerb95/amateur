<?php

namespace App\Models;

use CodeIgniter\Model;

class PaqueteCatalogoModel extends Model
{
    protected $table = 'paquetes_catalogo';
    protected $primaryKey = 'id_catalogo';
    protected $allowedFields = ['nombre','clases_mes','vigencia_dias','activo'];
}
