<?php

namespace App\Models;

use CodeIgniter\Model;

class ReciboModel extends Model
{
    protected $table            = 'recibos';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'usuario_id',
        'titulo',
        'archivo',
        'periodo',
        'firmado',
        'fecha_firma'
    ];

    protected $returnType       = 'array';

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
