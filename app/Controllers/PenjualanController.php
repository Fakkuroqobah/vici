<?php

namespace App\Controllers;

use App\Models\PenjualanHeader;
use App\Models\PenjualanHeaderDetail;
use App\Models\MasterBarang;
use App\Models\Promo;

use CodeIgniter\Exceptions\PageNotFoundException;
use \Hermawan\DataTables\DataTable;

class PenjualanController extends BaseController
{
    protected $penjualan;
    protected $penjualanDetail;
    protected $barang;
    protected $promo;
    protected $db;

    public function __construct()
    {
        $this->penjualan = new PenjualanHeader();
        $this->penjualanDetail = new PenjualanHeaderDetail();
        $this->barang = new MasterBarang();
        $this->promo = new Promo();
        $this->db = db_connect();
    }

    public function index()
    {
        $data['barang'] = $this->barang->getBarang();
        $data['promo'] = $this->promo->get();
        return view('penjualan/penjualan', $data);
    }

    public function show($id)
    {
        $data['penjualan'] = $this->penjualan->showPenjualan($id);
        $data['detail'] = $this->penjualan->showDetail($id);
        return view('penjualan/show', $data);
    }

    public function datatable()
    {
        $data = $this->db->table('penjualan_header')->select(['no_transaksi', 'tgl_transaksi', 'customer', 'kode_promo', 'total_bayar', 'ppn', 'grand_total']);
        return DataTable::of($data)
            ->addNumbering()
            ->add('aksi', function($row){
                return '
                <a href="'. base_url('penjualan/show/') . $row->no_transaksi .'" class="btn btn-sm mr-2 btn-success">Detail</a>
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
            'ppn' => 'required',

            'detail.*.kode_barang' => 'required',
            'detail.*.qty' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON($validation->getErrors())->setStatusCode(422);
        }

        $total_bayar = 0;
        $potongan = 0;
        foreach ($this->request->getPost('detail') as $value) {
            $a = explode('-', $value['kode_barang']);
            $total_bayar += $a[1] * $value['qty'];

            if($this->request->getPost('kode_promo') == 'promo-001') {
                if($a[0] == '003' && $value['qty'] >= 2) {
                    $potongan = 3000;
                }
            }
        }

        $this->db->transBegin();
        try {
            $no = $this->request->getPost('no_transaksi');
            $kode_promo = $this->request->getPost('kode_promo');
            if(empty($this->request->getPost('kode_promo'))) {
                $kode_promo = null;
            }

            $data = $this->penjualan->savePenjualan([
                'no_transaksi' => $no,
                'tgl_transaksi' => date('Y-m-d'),
                'customer' => $this->request->getPost('customer'),
                'kode_promo' => $kode_promo,
                'total_bayar' => $total_bayar,
                'ppn' => $this->request->getPost('ppn') ?? 0,
                'grand_total' => ($total_bayar + $this->request->getPost('ppn')) - $potongan,
            ]);

            if($data) {
                foreach ($this->request->getPost('detail') as $value) {
                    $a = explode('-', $value['kode_barang']);
    
                    if($a[0] == '003' && $value['qty'] >= 2) {
                        $this->penjualanDetail->savePenjualanDetail([
                            'id' => '',
                            'no_transaksi' => $no,
                            'kode_barang' => $a[0],
                            'qty' => $value['qty'],
                            'harga' => $a[1] * $value['qty'],
                            'discount' => $potongan,
                            'subtotal' => ($a[1] * $value['qty']) - $potongan,
                        ]);
                    }else{
                        $this->penjualanDetail->savePenjualanDetail([
                            'id' => '',
                            'no_transaksi' => $no,
                            'kode_barang' => $a[0],
                            'qty' => $value['qty'],
                            'harga' => $a[1] * $value['qty'],
                            'discount' => 0,
                            'subtotal' => ($a[1] * $value['qty']),
                        ]);
                    }
                }
            }else{
                return $this->response->setJSON()->setStatusCode(500);
            }

            $this->db->transCommit();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON($e->getMessage())->setStatusCode(500);
        }
    }

    public function delete($id)
    {   
        $result = $this->penjualan->deletePenjualan($id);
        
        return true;
    }
}
