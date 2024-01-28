<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenjualanHeaderDetailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'no_transaksi' => '202312-001',
                'kode_barang' => '001',
                'qty' => 1,
                'harga' => 5000,
                'discount' => 0,
                'subtotal' => 5000,
            ],
            [
                'no_transaksi' => '202312-001',
                'kode_barang' => '003',
                'qty' => 2,
                'harga' => 3000,
                'discount' => 3000,
                'subtotal' => 5000,
            ],
            [
                'no_transaksi' => '202312-001',
                'kode_barang' => '004',
                'qty' => 1,
                'harga' => 3000,
                'discount' => 0,
                'subtotal' => 3000,
            ],
        ];

        $this->db->table('penjualan_header_detail')->insertBatch($data);
    }
}
