<?= $this->extend('templates/navadm'); ?>
<!-- End of Topbar -->
<?= $this->Section('content-adm'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-9 text-gray-800">DAFTAR LAPANGAN</h1>

    <a href="<?= base_url('/admin/tlapangan'); ?>" class="btn btn-info mb-3">Tambah Data</a>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible show fede">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">x</button>
                <b>Success</b>
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-9">
            <table class="table table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">gambar</th>
                        <th scope="col">No lapangan</th>
                        <th scope="col">deskripsi</th>
                        <th scope="col">Action</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i = 1; ?>
                    <?php foreach ($lapangan as $lap) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="<?= base_url(); ?>/img/<?= $lap->gambarLap; ?>" class="img-fluid rounded-start" alt=""></td>
                            <td><?= $lap->noLap; ?></td>
                            <td><?= $lap->deskripsi; ?></td>
                            <td>
                                <a href="<?= base_url('admin/edit' . $lap->kdLap); ?>" class="btn btn-info">Edit</a>
                            </td>
                            <td>
                                <form action="<?= base_url('/admin/lapangan'); ?><?= $lap->kdLap; ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-info" onclick="return confirm('apakah anda yakin');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </form>

</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>