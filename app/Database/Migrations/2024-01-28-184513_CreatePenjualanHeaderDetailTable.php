<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanHeaderDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'discount' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'subtotal' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('no_transaksi', 'penjualan_header', 'no_transaksi', 'RESTRICT', 'CASCADE');

        $this->forge->createTable('penjualan_header_detail');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_header_detail');
    }
}
