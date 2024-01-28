<?php

namespace App\Controllers;

use App\Models\MasterBarang;

use CodeIgniter\Exceptions\PageNotFoundException;
use \Hermawan\DataTables\DataTable;

class BarangController extends BaseController
{
    protected $barang;
    protected $db;

    public function __construct()
    {
        $this->barang = new MasterBarang();
        $this->db = db_connect();
    }

    public function index()
    {
        return view('barang/barang');
    }

    public function datatable()
    {
        $data = $this->db->table('master_barang')->select(['kode_barang', 'nama_barang', 'harga']);
        return DataTable::of($data)
            ->addNumbering()
            ->add('aksi', function($row){
                return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $row->kode_barang .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $row->kode_barang .'">Delete</a>';
            }, 'last')
            ->toJson();
    }

    public function show($id)
    {
        $data = $this->barang->findBarang($id);

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'kode_barang' => 'required|max_length[5]|is_unique[master_barang.kode_barang]',
            'nama_barang' => 'required|max_length[255]',
            'harga' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON($validation->getErrors())->setStatusCode(422);
        }

        $data = $this->barang->saveBarang([
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga' => $this->request->getPost('harga'),
        ]);

        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama_barang' => 'required|max_length[255]',
            'harga' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON($validation->getErrors())->setStatusCode(422);
        }

        $this->barang->updateBarang([
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga' => $this->request->getPost('harga'),
        ]);
    }

    public function delete($id)
    {   
        $result = $this->barang->deleteBarang($id);
        
        return true;
    }
}
