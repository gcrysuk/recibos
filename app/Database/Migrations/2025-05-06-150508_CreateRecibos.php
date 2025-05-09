<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecibos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'titulo'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'archivo'     => ['type' => 'VARCHAR', 'constraint' => 255], // nombre del archivo
            'periodo'     => ['type' => 'VARCHAR', 'constraint' => 20],  // Ej: Marzo 2025
            'firmado'     => ['type' => 'BOOLEAN', 'default' => false],
            'fecha_firma' => ['type' => 'DATETIME', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('recibos');
    }

    public function down()
    {
        $this->forge->dropTable('recibos');
    }
}
