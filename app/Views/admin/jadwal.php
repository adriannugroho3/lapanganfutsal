<?= $this->extend('templates/navadm'); ?>
<!-- End of Topbar -->
<?= $this->Section('content-adm'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">JADWAL</h1>
    <a href="<?= base_url('/admin/tjadwal'); ?>" class="btn btn-info mb-3">Tambah Data</a>

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
        <div class="col-lg-8">
            <table class="table table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">lapangan</th>
                        <th scope="col">jam</th>
                        <th scope="col">harga</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($jadwal as $jdwl) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $jdwl->tglJadwal; ?></td>
                            <td><?= $jdwl->kdLap; ?></td>
                            <td><?= $jdwl->jamBo; ?></td>
                            <td><?= $jdwl->harga; ?></td>
                            <td>
                                <a href="<?= base_url('admin/jadwal/' . $jdwl->kdJadwal); ?>" class="btn btn-info">Edit</a>
                            </td>
                            <td>
                                <form action="<?= base_url('/admin/jadwal'); ?><?= $jdwl->kdJadwal; ?>" method="post">
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


</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>