<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenjualanHeaderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'no_transaksi' => '202312-001',
                'tgl_transaksi' => '2023-12-23',
                'customer' => 'Michael',
                'kode_promo' => 'promo-001',
                'total_bayar' => 10000,
                'ppn' => 1100,
                'grand_total' => 11100,
            ],
        ];

        $this->db->table('penjualan_header')->insertBatch($data);
    }
}
