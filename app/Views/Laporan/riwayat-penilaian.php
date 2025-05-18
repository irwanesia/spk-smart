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
                                <th>Tanggal Penilaian</th>
                                <th>Jumlah Alternatif/Mobil</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($riwayat as $r) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $r['nama'] ?></td>
                                    <td><?= $r['email'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($r['tanggal'])) ?></td>
                                    <td><?= $r['jumlah_mobil'] ?> mobil</td>
                                    <td>
                                        <a href="<?= site_url('laporan/detail_riwayat/' . $r['id_user'] . '/' . $r['tanggal']) ?>"
                                            class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i> Detail
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