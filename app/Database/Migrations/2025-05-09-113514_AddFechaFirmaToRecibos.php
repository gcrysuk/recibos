<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFechaFirmaToRecibos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recibos', [
            'fecha_firma' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'firmado' // asegurate que 'firmado' exista
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('recibos', 'fecha_firma');
    }
}
