<?php

namespace App\Models;

use CodeIgniter\Model;

class ReciboModel extends Model
{
    protected $table = 'recibos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id',
        'archivo',
        'fecha',
        'firma',
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true; // opcional, si usás created_at / updated_at
}
