<?= $this->extend('templates/navadm'); ?>
<!-- End of Topbar -->
<?= $this->Section('content-adm'); ?>




<div class="container-fluid">

    <hr>

    <div class="row">
        <div class="col-lg-6">

            <table>
                <tbody>
                    <tr>
                        <td>
                            <h4>CENTRO FUTSAL YOGYAKARTA</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Jl. Damai, Ngaglik, Sleman
                        </td>
                    </tr>
                    <tr>
                        <td>Phone: 0274-761090</td>
                    </tr>
                    <tr>
                        <td>centrofutsal.com</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">

            <table class='table table-bordered '>
                <tbody>


                    <tr>
                        <td>Nomor Invoice</td>
                        <td><strong><?= $boking->noInvoice; ?></strong></td>

                    </tr>
                    <tr>
                        <td>Status Bayar </td>
                        <td> <?php if ($boking->kdStatus == "Sudah_Membayar") {
                                    echo "<label class='label  btn-success'> Lunas </label>";
                                } else {
                                    echo "<label class='label btn-danger'>Belum Lunas</label>";
                                }
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Invoice </td>
                        <td><strong> <?= $boking->tglInvoice; ?></strong></td>
                    </tr>
                    <tr>
                        <td>Username Boking </td>
                        <td><?= $boking->username; ?> </td>
                    </tr>
                    <tr>
                        <td>Atas Nama </td>
                        <td><?= $boking->atasNama; ?> </td>
                    </tr>
                    <tr>
                        <td>Alamat :</td>
                        <td><?= $boking->alamat; ?> </td>
                    </tr>
                    <tr>
                        <td>Kontak :</td>
                        <td><?= $boking->kontak; ?> </td>
                    </tr>
                    <tr>
                        <td>Cetak Invoice</td>
                        <td>
                            <a href="<?= base_url('admin/transaksi/' . $boking->kdBoking); ?>" class="btn btn-info">cetak</a>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>
    </div>
    <div class='row-fluid'>
        <div class=''>
            <table class='table table-bordered '>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor lapangan</th>
                        <th>Tgl.Boking</th>
                        <th>Jam mulai Boking</th>
                        <th>Jam seleai Boking</th>
                        <th>Harga</th>
                        <th>Subtotal</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $boking->noLap; ?></td>
                        <td><?= $boking->tglInvoice; ?></td>
                        <td><?= $boking->jamMulaiBooking; ?></td>
                        <td><?= $boking->jamSelesaiBooking; ?></td>
                        <td><?= $boking->harga; ?></td>
                        <td><?= $boking->totalBayar; ?></td>

                    </tr>
                </tbody>
            </table>
            <form action="<?= site_url('admin/pesanan' . $boking->kdBoking) ?>" method="POST" autocomplete="off">

                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">
                <table class='table table-bordered '>

                    <tbody>
                        <tr>
                            <td class='msg' width='85%'>
                                <h4>Invoice Boking Lapangan Centro </h4>
                                <a href='#' class='tip-bottom' title='Kasir'></a> | <a href='#' class='tip-bottom' title='BCA (78889991) - Mandiri (788928292)-BRI (082928938) '>BCA (78889991) - Mandiri (788928292)-BRI (082928938) </a> | <a href='#' class='tip-bottom' title='SWIFT code'>A/N </a>| <a href='#' class='tip-bottom' title='IBAN Billing address'>Centro Futsal </a>
                            </td>
                            <td class='right'><strong>Ubah Status Pembayaran</strong> <br>
                            </td>
                            <td>
                                <?php if ($boking->kdStatus == "Sudah_Membayar") {
                                    echo "
							<input type='radio' value='sudah_Membayar' name='kdStatus' checked> Sudah Membayar
							<input type='radio' value='menunggu_pembayaran' name='kdStatus'> Menunggu pembayaran
							<input type='radio' value='selesai' name='kdStatus'> Selesai
							";
                                } else {
                                    echo "
                                    <input type='radio' value='sudah_Membayar' name='kdStatus' checked> Sudah Membayar
                                    <input type='radio' value='menunggu_pembayaran' name='kdStatus'> Menunggu pembayaran
                                    <input type='radio' value='selesai' name='kdStatus'> Selesai
							";
                                } ?>


                            </td>
                        </tr>
                    </tbody>
                </table>


                <div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                    <h4><span></span></h4>
                    <br>
                    <button type="submit" class="btn btn-primary " onclick="return confirm('apakah anda yakin');">Simpan Perubahan</button>
                </div>

            </form>


            <br>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>