<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanHeaderDetail extends Model
{
    protected $table = 'penjualan_header_detail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['tgl_transaksi', 'kode_barang', 'qty', 'harga', 'discount', 'subtotal'];
    protected $useTimestamps = false;

    public function savePenjualanDetail($data)
    {
        return $this->insert($data);
    }
}