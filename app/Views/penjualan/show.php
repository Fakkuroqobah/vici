@extends('layouts.index')
<?= $this->extend('index') ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item"><a href="<?= url_to('penjualan') ?>">Penjualan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Penjualan</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No transaksi</th>
                        <th>Tanggal transaksi</th>
                        <th>Customer</th>
                        <th>Kode promo</th>
                        <th>Total bayar</th>
                        <th>PPN</th>
                        <th>Grand total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $penjualan['no_transaksi'] ?></td>
                        <td><?= $penjualan['tgl_transaksi'] ?></td>
                        <td><?= $penjualan['customer'] ?></td>
                        <td><?= $penjualan['kode_promo'] ?></td>
                        <td><?= $penjualan['total_bayar'] ?></td>
                        <td><?= $penjualan['ppn'] ?></td>
                        <td><?= $penjualan['grand_total'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Detail</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>QTY</th>
                        <th>Harga</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($detail as $item) : ?>
                        <tr>
                            <td><?= $item['kode_barang'] ?></td>
                            <td><?= $item['nama_barang'] ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= $item['harga'] ?></td>
                            <td><?= $item['discount'] ?></td>
                            <td><?= $item['subtotal'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
</script>
<?= $this->endSection() ?>