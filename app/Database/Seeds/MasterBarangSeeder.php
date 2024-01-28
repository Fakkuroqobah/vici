<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterBarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_barang' => '001',
                'nama_barang' => 'Skin Care',
                'harga' => 5000,
            ],
            [
                'kode_barang' => '002',
                'nama_barang' => 'Body Care',
                'harga' => 4000,
            ],
            [
                'kode_barang' => '003',
                'nama_barang' => 'Facial Care',
                'harga' => 3000,
            ],
            [
                'kode_barang' => '004',
                'nama_barang' => 'Hair Care',
                'harga' => 2000,
            ],
        ];

        $this->db->table('master_barang')->insertBatch($data);
    }
}
