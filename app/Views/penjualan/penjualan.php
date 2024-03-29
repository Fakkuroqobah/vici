<?= $this->extend('index') ?>

<?= $this->section('breadcrumb') ?>
    <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="#" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#modal-tambah">Tambah</a>
<div class="clearfix"></div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No transaksi</th>
                        <th>Tanggal transaksi</th>
                        <th>Customer</th>
                        <th>Kode promo</th>
                        <th>Total bayar</th>
                        <th>PPN</th>
                        <th>Grand total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-tambah">
                <div class="modal-body">
                    <div class="alert alert-danger error-message d-none" role="alert">
                        <ul class="m-0"></ul>
                    </div>

                    <div class="form-group">
                        <label for="">No transaksi</label>
                        <input type="text" name="no_transaksi" class="form-control" autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Customer</label>
                        <input type="text" name="customer" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">PPN</label>
                        <input type="number" name="ppn" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Kode promo</label>
                        <select class="form-control" name="kode_promo">
                            <option value="">Pilih promo</option>
                            <?php foreach($promo as $val) : ?>
                                <option value="<?= $val['kode_promo'] ?>"><?= $val['kode_promo'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <button type="button" class="btn btn-sm btn-success btn-block mb-3" id="btn-add">Tambah barang</button>
                    <table id="area">
                        
                    </table>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

function template(id)
{
    return `<tr>
        <td>
            <div class="form-group">
                <label for="">Barang</label>
                <select name="detail[${id}][kode_barang]" class="form-control" id="">
                    <?php foreach($barang as $valu) : ?>
                        <option value="<?= $valu['kode_barang'] ?>-<?= $valu['harga'] ?>"><?= $valu['kode_barang'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="">QTY</label>
                <input type="number" class="form-control" name="detail[${id}][qty]">
            </div>
        </td>
        <td>
            <button type="button" class="btn-del btn btn-sm btn-danger">Hapus</button>
        </td>
    </tr>`;
}

$(document).ready(function() {
    var id = 0;

    $('#btn-add').click(function(){
        $('#area').append(template(id));
        id++;
    });

    $('#area').on('click', '.btn-del', function() {
        var el = $('#area tr');

        if(el.length > 1) {
            $(this).closest('tr').remove();
            resetNumber();
        }
    });

    var table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= base_url('penjualan/datatable') ?>',
        columnDefs: [
            { targets: -1, orderable: false},
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7]
                }
            }
        ]
    });

    var tambah = $("#modal-tambah button[name='submit']");
    tambah.click(function(e) {
        e.preventDefault();

        tambah.attr("disabled", true);
        tambah.text('Loading');

        $('.error-message').addClass('d-none');
        $('.error-message ul').empty();

        var form = new FormData($('#form-tambah')[0]);
        form.append('aksi', 'tambah');

        var opt = {
            method: 'POST',
            aksi: 'tambah',
            url: '<?= base_url('penjualan/store') ?>',
            table: table,
            element: tambah
        };

        var txt = {
            btnText: 'Tambah Data',
            msgAlert: 'Data berhasil ditambahkan',
            msgText: 'ditambah'
        };

        requestAjaxPost(opt, form, txt);
    });

    $('#table').on('click', '.delete', function(event) {
        var url = "<?= base_url('penjualan/delete/') . ':id' ?>";
        url = url.replace(':id', $(this).attr('data-id'));

        var opt = {
            url: url,
            method: 'DELETE',
            aksi: 'hapus',
            table: table
        };
        
        var txt = {
            msgAlert: "Data akan dihapus!",
            msgText: "hapus",
            msgTitle: 'Data berhasil dihapus'
        };

        requestAjaxDelete(opt, txt);
    });
});
</script>
<?= $this->endSection() ?>