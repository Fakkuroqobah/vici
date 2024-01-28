<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterBarangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'nama_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('kode_barang');
        $this->forge->createTable('master_barang');
    }

    public function down()
    {
        $this->forge->dropTable('master_barang');
    }
}
