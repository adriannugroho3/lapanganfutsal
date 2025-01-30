<?= $this->extend('templates/navadm'); ?>
<!-- End of Topbar -->
<?= $this->Section('content-adm'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">DATA PESANAN</h1>

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
        <div class="col-lg-6">
            <table class="table table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tgl Invoice</th>
                        <th scope="col">username</th>
                        <th scope="col">atas nama</th>
                        <th scope="col">alamat</th>
                        <th scope="col">kontak</th>
                        <th scope="col">total bayar</th>
                        <th scope="col">status</th>
                        <th scope="colspan=" 2">Action</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($boking as $bkg) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $bkg->tglInvoice; ?></td>
                            <td><?= user()->username ?></td>
                            <td><?= $bkg->atasNama; ?></td>
                            <td><?= $bkg->alamat; ?></td>
                            <td><?= $bkg->kontak; ?></td>
                            <td><?= $bkg->totalBayar; ?></td>

                            <td> <?php if ($bkg->kdStatus == "Sudah_Membayar") {
                                        echo "<label class='label'> Lunas </label>";
                                    } else {
                                        echo "<label class='label'>Belum Lunas</label>";
                                    }
                                    ?>
                            </td>

                            <td>
                                <a href="<?= base_url('admin/pesanan/' . $bkg->kdBoking); ?>" class="btn btn-info">Detail</a>
                            </td>
                            <td>
                                <form action="<?= base_url('/admin/pesanan' .  $bkg->kdBoking); ?>" method="post">
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

<?= $this->endSection(); ?>