<?= $this->extend('templates/navadm'); ?>
<!-- End of Topbar -->
<?= $this->Section('content-adm'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-8">
            <h1 class="h3 my-3 text-gray-800">Form Tambah Data jadwal</h1>
            <?php $validation = \Config\Services::validation(); ?>
            <form action="/admin/savejad" method="POST" autocomplete="off">

                <?= csrf_field(); ?>

                <div class="row mb-3">
                    <label for="tglJadwal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control <?= $validation->hasError('tglJadwal') ? 'is-invalid' : null ?>" id="tglJadwal" name="tglJadwal" value="<?= date('Y-m-d') ?>" autofocus>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tglJadwal') ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="kdLap" class="col-sm-2 col-form-label">No lapangan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= $validation->hasError('kdLap') ? 'is-invalid' : null ?>" id="kdLap" name="kdLap">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kdLap') ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jamBo" class="col-sm-2 col-form-label">Jam</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= $validation->hasError('jamBo') ? 'is-invalid' : null ?>" id="jamBo" name="jamBo">
                        <div class="invalid-feedback">
                            <?= $validation->getError('jamBo') ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= $validation->hasError('harga') ? 'is-invalid' : null ?>" id="harga" name="harga">
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga') ?>
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