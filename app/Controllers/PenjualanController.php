<?php

namespace App\Controllers;

use App\Models\PenjualanHeader;
use App\Models\MasterBarang;
use App\Models\Promo;

use CodeIgniter\Exceptions\PageNotFoundException;
use \Hermawan\DataTables\DataTable;

class PenjualanController extends BaseController
{
    protected $penjualan;
    protected $barang;
    protected $promo;
    protected $db;

    public function __construct()
    {
        $this->penjualan = new PenjualanHeader();
        $this->barang = new MasterBarang();
        $this->promo = new Promo();
        $this->db = db_connect();
    }

    public function index()
    {
        $data['barang'] = $this->barang->get();
        $data['promo'] = $this->promo->get();
        return view('penjualan/penjualan', $data);
    }

    public function datatable()
    {
        $data = $this->db->table('penjualan_header')->select(['no_transaksi', 'tgl_transaksi', 'customer', 'kode_promo', 'total_bayar', 'ppn', 'grand_total']);
        return DataTable::of($data)
            ->addNumbering()
            ->add('aksi', function($row){
                return '
                <a href="#" class="btn btn-sm mr-2 btn-success">Detail</a>
                <a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $row->no_transaksi .'">Delete</a>';
            }, 'last')
            ->toJson();
    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'no_transaksi' => 'required|max_length[255]|is_unique[penjualan_header.no_transaksi]',
            'customer' => 'required|max_length[255]',
            'total_bayar' => 'required',
            'ppn' => 'required',

            'detail.*.kode_barang' => 'required',
            'detail.*.qty' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON($validation->getErrors())->setStatusCode(422);
        }

        $grand_total = 0;
        foreach ($this->request->getPost('detail') as $value) {
            $grand_total += $value['harga'];
        }

        if($grand_total < $this->request->getPost('total_bayar')) {
            return $this->response->setJSON(['error' => 'total bayar tidak cukup'])->setStatusCode(422);
        }

        die('oke');

        $this->db->transBegin();
        try {
            $data = $this->penjualan->savePenjualan([
                'no_transaksi' => $this->request->getPost('no_transaksi'),
                'tgl_transaksi' => date('Y-m-d'),
                'cutomer' => $this->request->getPost('cutomer'),
                'kode_promo' => $this->request->getPost('kode_promo'),
                'total_bayar' => $this->request->getPost('total_bayar'),
                'ppn' => $grand_total - $this->request->getPost('ppn'),
            ]);

            $db->transCommit();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON($e->getMessage())->setStatusCode(500);
        }
    }

    public function delete($id)
    {   
        $result = $this->penjualan->deletePenjualan($id);
        
        return true;
    }
}
