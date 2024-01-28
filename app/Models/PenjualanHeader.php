<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanHeader extends Model
{
    protected $table = 'penjualan_header';
    protected $primaryKey = 'no_transaksi';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['no_transaksi', 'tgl_transaksi', 'customer', 'kode_promo', 'total_bayar', 'ppn', 'grand_total'];
    protected $useTimestamps = false;

    public function get()
    {
        return $this->findAll();
    }

    public function savePenjualan($data)
    {
        return $this->insert($data);
    }

    public function findPenjualan($id)
    {
        return $this->find($id);
    }

    public function deletePenjualan($id)
    {
        return $this->delete($id);
    }
}