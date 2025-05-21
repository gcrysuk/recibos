<?php

namespace App\Models;

use CodeIgniter\Model;

class FirmaModel extends Model
{
    protected $table            = 'firmas';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'recibo_id',
        'firmante_id',
        'fecha'
    ];

    protected $returnType       = 'array';
    public    $useTimestamps    = false;
}
