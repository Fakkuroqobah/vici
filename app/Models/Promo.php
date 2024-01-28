<?php

namespace App\Models;

use CodeIgniter\Model;

class Promo extends Model
{
    protected $table = 'promo';
    protected $primaryKey = 'kode_promo';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['kode_promo', 'nama_promo', 'keterangan'];
    protected $useTimestamps = false;

    public function get()
    {
        return $this->findAll();
    }
}