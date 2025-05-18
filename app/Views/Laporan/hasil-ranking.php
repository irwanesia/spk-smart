<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mt-0 header-title">Data <?= $title ?></h4>
                </div>

                <!-- Konten tabel tetap sama -->
                <div class="table-responsive">
                    <table id="datatable" class="table mb-0 table-centered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Email</th>
                                <th>Hasil Perhitungan SMART</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($pelanggan as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td>
                                        <?php if (!empty($ranking[$row['id_user']])) : ?>
                                            <ul class="mb-0">
                                                <?php foreach ($ranking[$row['id_user']] as $rank) : ?>
                                                    <li><?= $rank['nama_mobil'] . ': ' . $rank['skor']; ?></li>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php else : ?>
                                            <span class="text-muted">Belum ada data</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('laporan/cetak-hasil-ranking/' . $row['id_user']) ?>"
                                            class="btn btn-sm btn-icon btn-info"
                                            title="Cetak Laporan Pelanggan">
                                            <i class="mdi mdi-printer"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table><!--end /table-->
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content') ?>