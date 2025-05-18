<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Detail Penilaian: <?= esc($user['nama']) ?></h5>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-centered">
                        <thead class="thead-light">
                            <tr>
                                <th>Kriteria</th>
                                <?php foreach ($mobils as $mobil) : ?>
                                    <th><?= esc($mobil['nama_mobil']) ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kriterias as $kriteria) : ?>
                                <tr>
                                    <td><?= esc($kriteria['nama_kriteria']) ?></td>
                                    <?php foreach ($mobils as $mobil) : ?>
                                        <td>
                                            <?= $penilaian[$mobil['id_mobil']][$kriteria['id_kriteria']] ?? '<span class="text-muted">-</span>' ?>
                                        </td>
                                    <?php endforeach ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <a href="<?= site_url('laporan/detail-penilaian') ?>" class="btn btn-sm btn-secondary mt-3">← Kembali</a>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content') ?>