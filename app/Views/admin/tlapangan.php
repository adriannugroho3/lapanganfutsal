<?= $this->extend('templates/navadm'); ?>
<!-- End of Topbar -->
<?= $this->Section('content-adm'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-8">
            <h1 class="h3 my-3 text-gray-800">Form Tambah Data Lapangan</h1>
            <?php $validation = \Config\Services::validation(); ?>
            <form action="/admin/savelap" method="POST" autocomplete="off">

                <?= csrf_field(); ?>

                <div class="row mb-3">
                    <label for="noLap" class="col-sm-2 col-form-label">No Lapangan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= $validation->hasError('noLap') ? 'is-invalid' : null ?>" id="noLap" name="noLap" autofocus>
                        <div class="invalid-feedback">
                            <?= $validation->getError('noLap') ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="gambarLap" class="col-sm-2 col-form-label">Gambar</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= $validation->hasError('gambarLap') ? 'is-invalid' : null ?>" id=" gambarLap" name="gambarLap">
                        <div class="invalid-feedback">
                            <?= $validation->getError('gambarLap') ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= $validation->hasError('deskripsi') ? 'is-invalid' : null ?>" id="deskripsi" name="deskripsi">
                        <div class="invalid-feedback">
                            <?= $validation->getError('deskripsi') ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>