<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<!-- cek apakah ada data mobil -->
<?php if (!empty($data)) : ?>
    <!-- bobot kriteria -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mt-0 header-title">#Bobot Kriteria</h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <?php foreach ($kriteria as $key) : ?>
                                <th><?= $key['kode_kriteria'] ?> (<?= $key['tipe'] ?>)</th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bobot (W)</td>
                            <?php foreach ($kriteria as $key) : ?>
                                <td>
                                    <?= $key['bobot']; ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- nilai matrik keputusan -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mt-0 header-title">#Matrik Keputusan</h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="text-white">
                        <tr align="center">
                            <th width="5%" rowspan="2">No</th>
                            <th width="15%">Nama Mobil</th>
                            <?php foreach ($kriteria as $key) : ?>
                                <th><?= $key['kode_kriteria'] ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data as $nama_mobil => $nilaiKriteria) : ?>
                            <tr align="center">
                                <td><?= $no++; ?></td>
                                <td align="left"><?= $nama_mobil ?></td>
                                <?php foreach ($kriteria as $key) : ?>
                                    <td><?= $nilaiKriteria[$key['id_kriteria']] ?? '-'; ?></td>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach ?>
                        <tr class="text-center">
                            <td colspan="2" class="bg-secondary text-white">Nilai Max</td>
                            <?php foreach ($nilaiMax as $max) : ?>
                                <td class="bg-secondary text-white"><?= $max ?></td>
                            <?php endforeach ?>
                        </tr>
                        <tr class="text-center">
                            <td colspan="2" class="bg-secondary text-white">Nilai Min</td>
                            <?php foreach ($nilaiMin as $min) : ?>
                                <td class="bg-secondary text-white"><?= $min ?></td>
                            <?php endforeach ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- normalisasi matrik -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mt-0 header-title">#Normalisasi Matrik</h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="text-white">
                        <tr align="center">
                            <th width="5%" rowspan="2">No</th>
                            <th width="15%">Nama Mobil</th>
                            <?php foreach ($kriteria as $key) : ?>
                                <th><?= $key['kode_kriteria'] . " (<i class='text-success'>" . $key['tipe'] . "</i>)" ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($normalisasi as $nama_mobil => $nama_kriteria) : ?>
                            <tr align="center">
                                <td><?= $no++; ?></td>
                                <td align="left"><?= $nama_mobil ?></td>
                                <?php foreach ($nama_kriteria as $key => $nilai) : ?>
                                    <td><?= $nilai; ?></td>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- score preferensi -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mt-0 header-title">#Hitung Skor Preferensi</h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="text-white">
                        <tr align="center">
                            <th width="5%" rowspan="2">No</th>
                            <th width="15%">Nama Mobil</th>
                            <?php foreach ($kriteria as $key) : ?>
                                <th><?= $key['kode_kriteria'] ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($normalisasi as $nama_mobil => $nilai_kriteria) : ?>
                            <tr align="center">
                                <td><?= $no++; ?></td>
                                <td align="left"><?= $nama_mobil ?></td>
                                <?php foreach ($nilai_kriteria as $id_kriteria => $nilai) : ?>
                                    <td><?= $nilai * $bobot[$id_kriteria] ?></td>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- hasil preferensi -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mt-0 header-title">#Nilai Preferensi</h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Nilai Preferensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($nilaiPreferensi as $nama_mobil => $nilai) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($nama_mobil) ?></td>
                                <td><?= round($nilai, 4) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php else : ?>
    <div class="alert alert-danger" role="alert">
        <strong>Data tidak ditemukan!</strong> Silahkan pilih periode dan kriteria terlebih dahulu.
    </div>
<?php endif; ?>

<?= $this->endSection('content') ?>