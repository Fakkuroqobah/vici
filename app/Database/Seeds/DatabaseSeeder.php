<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('MasterBarangSeeder');
        $this->call('PromoSeeder');
        $this->call('PenjualanHeaderSeeder');
        $this->call('PenjualanHeaderDetailSeeder');
    }
}