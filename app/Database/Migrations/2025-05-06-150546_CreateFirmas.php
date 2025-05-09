<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFirmas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'recibo_id'  => ['type' => 'INT', 'unsigned' => true],
            'firmado_por' => ['type' => 'INT', 'unsigned' => true], // user_id del firmante
            'fecha'      => ['type' => 'DATETIME'],
            'metodo'     => ['type' => 'VARCHAR', 'constraint' => 50], // ej: "token", "firma digital"
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('recibo_id', 'recibos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('firmado_por', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('firmas');
    }

    public function down()
    {
        $this->forge->dropTable('firmas');
    }
}
