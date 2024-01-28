<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Inventory">
    <meta name="author" content="">

    <title>Ecommerce</title>

    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/sb-admin-2.min.css') ?>">
    <?= $this->renderSection('css') ?>

    <style>
        .swal2-top-end .swal2-title { color: white !important; }
    </style>
</head>
<?php
    function tgl_indo($tanggal, $cetak_hari = false) {
        $hari = array ( 
            1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );

        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
    
        return $tgl_indo;
    }
?>
<body id="page-top">
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <i class="fas fa-money-bill"></i>
            </div>
            <div class="sidebar-brand-text ml-2">Ecommerce</div>
        </a>

        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-clipboard-list"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-clipboard-list"></i>
                <span>Barang</span>
            </a>
        </li>
        
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">
                    <?= tgl_indo(date('Y-m-d'), true) ?>
                </div>
            </nav>

            <div class="container-fluid">
                <ol class="breadcrumb">
                    <?= $this->renderSection('breadcrumb') ?>
                </ol>

                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>© <?= date('Y') ?> AGUNG MAULANA</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
<script>
$(document).ready(function() {
    $('.modal').on('hidden.bs.modal', function() {
        $('.error-message').addClass('d-none');
        $('.error-message ul').empty();
    });
});
</script>
<?= $this->include('shared/ajax') ?>
<?= $this->renderSection('script') ?>
</body>
</html>