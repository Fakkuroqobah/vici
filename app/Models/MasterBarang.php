<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterBarang extends Model
{
    protected $table = 'master_barang';
    protected $primaryKey = 'kode_barang';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga'];
    protected $useTimestamps = false;

    public function getBarang()
    {
        return $this->findAll();
    }

    public function saveBarang($data)
    {
        return $this->insert($data);
    }

    public function updateBarang($id, $data)
    {
        return $this->update($id, $data);
    }

    public function findBarang($id)
    {
        return $this->find($id);
    }

    public function deleteBarang($id)
    {
        return $this->delete($id);
    }
}