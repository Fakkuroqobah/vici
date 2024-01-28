<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePromoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_promo' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_promo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('kode_promo');
        $this->forge->createTable('promo');
    }

    public function down()
    {
        $this->forge->dropTable('promo');
    }
}
