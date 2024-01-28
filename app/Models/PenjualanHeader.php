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

    public function showDetail($id)
    {
        return $this
            ->select('penjualan_header.*, penjualan_header_detail.*,master_barang.*')
            ->join('penjualan_header_detail', 'penjualan_header.no_transaksi = penjualan_header_detail.no_transaksi')
            ->join('master_barang', 'penjualan_header_detail.kode_barang = master_barang.kode_barang')
            ->where('penjualan_header_detail.no_transaksi', $id)
            ->findAll();
    }

    public function showPenjualan($id)
    {
        return $this->find($id);
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