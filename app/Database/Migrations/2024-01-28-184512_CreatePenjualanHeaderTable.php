<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanHeaderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'no_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'tgl_transaksi' => [
                'type' => 'DATE',
            ],
            'customer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_promo' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'total_bayar' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'ppn' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'grand_total' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
        ]);

        $this->forge->addKey('no_transaksi', true);
        $this->forge->addForeignKey('kode_promo', 'promo', 'kode_promo', 'RESTRICT', 'CASCADE');

        $this->forge->createTable('penjualan_header');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_header');
    }
}
