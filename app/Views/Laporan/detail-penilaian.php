<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mt-0 header-title">Data <?= $title ?></h4>
                </div>

                <!-- views/laporan/detail_penilaian_index.php -->
                <div class="table-responsive">
                    <table id="datatable" class="table mb-0 table-centered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Email</th>
                                <th>Lihat Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($userPenilaian as $userId => $dataUser) : ?>
                                <?php $user = $dataUser['user']; ?>
                                <?php $kriteria = $dataUser['kriteria']; ?>
                                <?php $penilaian = $dataUser['penilaian']; ?>

                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $user['nama'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <?php if (!empty($penilaian)) : ?>
                                            <button type="button" class="btn btn-sm btn-info btn-rounded" data-toggle="collapse" data-target="#collapse-<?= $userId ?>" aria-expanded="false" aria-controls="collapse-<?= $userId ?>">
                                                <i class="mdi mdi-arrow-down-bold-box"></i> Detail Penilaian
                                            </button>
                                        <?php else : ?>
                                            <span class="text-muted">Belum ada penilaian</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <?php if (!empty($penilaian)) : ?>
                                    <tr class="collapse-row">
                                        <td colspan="4" class="p-0">
                                            <div class="collapse" id="collapse-<?= $userId ?>">
                                                <div class="card card-body p-0">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr align="center">
                                                                <th width="30%">Nama Mobil</th>
                                                                <?php foreach ($kriteria as $key) : ?>
                                                                    <th><?= $key['nama_kriteria'] ?></th>
                                                                <?php endforeach ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($penilaian as $namaMobil => $nilaiKriteria) : ?>
                                                                <tr align="center">
                                                                    <td align="left"><?= $namaMobil ?></td>
                                                                    <?php foreach ($kriteria as $key) : ?>
                                                                        <td><?= $nilaiKriteria[$key['nama_kriteria']] ?? '-' ?></td>
                                                                    <?php endforeach ?>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content') ?>