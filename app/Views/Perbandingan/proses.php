<?= $this->extend('layout/public') ?>

<?= $this->section('content-utama') ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('logged_in')) : ?>
        <h4 class="mb-3">Hasil Perbandingan Mobil</h4>

        <!-- Informasi mobil yang dibandingkan -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
            <div>
                <strong class="d-block mb-2">Mobil yang dibandingkan:</strong>
                <div id="comparedCars" class="d-flex flex-wrap gap-2">
                    <!-- Badges akan diisi oleh JavaScript -->
                </div>
            </div>
            <button class="btn btn-sm btn-primary align-self-start" id="changeComparison">
                <i class="mdi mdi-circle-edit-outline mr-1"></i> Ubah
            </button>
        </div>

        <!-- Bobot Kriteria -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"># Bobot Kriteria</h5>
            </div>
            <div class="card-body">
                <div class="row" id="criteriaWeights">
                    <!-- Bobot kriteria akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>

        <!-- Tabel Matriks Keputusan -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"># Matriks Keputusan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="decisionMatrix">
                        <thead class="thead-light">
                            <tr align="center">
                                <th width="5%" rowspan="2">No</th>
                                <th width="30%">Nama Mobil</th>
                                <?php foreach ($kriteria as $key) : ?>
                                    <th><?= $key['nama_kriteria'] ?></th>
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

        <!-- Tabel Normalisasi -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"># Normalisasi Matriks</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="normalizationMatrix">
                        <thead class="thead-light">
                            <tr align="center">
                                <th width="5%" rowspan="2">No</th>
                                <th width="30%">Nama Mobil</th>
                                <?php foreach ($kriteria as $key) : ?>
                                    <th><?= $key['nama_kriteria'] ?></th>
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
                <small class="text-muted">
                    * Normalisasi dilakukan dengan metode benefit (maksimasi) dan cost (minimasi)
                </small>
            </div>
        </div>

        <!-- Tabel Skor Preferensi -->
        <!-- <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">3. Skor Preferensi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="preferenceScores">
                    <thead class="thead-light">
                        <tr align="center">
                            <th width="5%" rowspan="2">No</th>
                            <th width="30%">Nama Mobil</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

        <!-- Tabel Ranking -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"># Hasil Ranking</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="rankingResults">
                        <thead class="thead-light">
                            <tr align="center">
                                <th width="10%">Ranking</th>
                                <th width="40%">Mobil</th>
                                <th width="30%">Skor Preferensi</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($nilaiPreferensi as $nama_mobil => $nilai) : ?>
                                <tr align="center">
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($nama_mobil) ?></td>
                                    <td><?= round($nilai, 4) ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#purchaseModal<?= md5($nama_mobil) ?>">
                                            <i class="mdi mdi-shopping"></i> Beli
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="row mb-4">
            <div class="col-md-6">
                <button class="btn btn-outline-secondary" id="backToList">
                    <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar Mobil
                </button>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-success" id="buyRecommended">
                    <i class="mdi mdi-check"></i> Beli Rekomendasi Terbaik
                </button>
            </div>
        </div>

    <?php else : ?>
        <div class="row justify-content-center mt-4 mb-4">
            <div class="col-md-12 text-center">
                <h2>Hasil Perbandingan Mobil</h2>
                <div class="alert alert-warning">
                    Anda harus login untuk melihat hasil perbandingan mobil.
                </div>
                <div class="text-center">
                    <a href="<?= base_url('login') ?>" class="btn btn-primary">Login</a>
                    <a href="<?= base_url('register') ?>" class="btn btn-secondary">Daftar</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- model pembelian -->
<?= include('form-modal.php') ?>

<?= $this->Section('scripts') ?>

<script>
    // Data dari controller
    const kriteria = <?= json_encode($kriteria) ?>;
    const mobil = <?= json_encode($mobil) ?>;
    const comparedCarIds = <?= json_encode($comparedCarIds) ?>;

    // Format data untuk perhitungan SMART
    function prepareSMARTData() {
        const criteriaWeights = {};
        const cars = {};

        // Siapkan bobot kriteria
        kriteria.forEach(k => {
            criteriaWeights[k.id_kriteria] = parseFloat(k.bobot * 100) || 0; // Menggunakan bobot dari database
        });

        // Siapkan data mobil
        comparedCarIds.forEach(id => {
            if (mobil[id]) {
                cars[id] = {
                    name: mobil[id].nama,
                    criteria: {}
                };

                kriteria.forEach(k => {
                    if (mobil[id].data[k.id_kriteria]) {
                        cars[id].criteria[k.id_kriteria] = {
                            value: parseFloat(mobil[id].data[k.id_kriteria].nilai),
                            type: mobil[id].data[k.id_kriteria].tipe,
                            weight: parseFloat(mobil[id].data[k.id_kriteria].bobot),
                            nama_kriteria: k.nama_kriteria // Tambahkan nama kriteria
                        };
                    }
                });
            }
        });

        return {
            criteriaWeights,
            cars
        };
    }

    // Fungsi untuk menampilkan mobil yang dibandingkan
    function displayComparedCars() {
        const carBadges = comparedCarIds.map(id => {
            return mobil[id] ?
                `<span class="badge badge-primary p-2 mr-2 mb-2 d-flex align-items-center">
                <i class="mdi mdi-car mr-1"></i>${mobil[id].nama}
            </span>` :
                '<span class="badge badge-secondary">Mobil tidak dikenal</span>';
        });

        $('#comparedCars').html(carBadges.join(''));
    }

    // Fungsi untuk menampilkan bobot kriteria
    function displayCriteriaWeights() {
        const {
            criteriaWeights
        } = prepareSMARTData();
        let totalWeight = Object.values(criteriaWeights).reduce((a, b) => a + b, 0);

        let html = '';

        // Tampilkan warning jika total bobot tidak 100
        if (totalWeight !== 100) {
            html += `<div class="col-md-12 mb-3">
            <div class="alert alert-warning">
                Total bobot kriteria harus 100%. Saat ini total: ${totalWeight.toFixed(2)}%
            </div>
        </div>`;
        }

        // Tampilkan bobot per kriteria
        kriteria.forEach(k => {
            const weight = criteriaWeights[k.id_kriteria] || 0;
            const progressBarClass = k.tipe === 'cost' ? 'bg-danger' : 'bg-success';
            const tipText = k.tipe === 'cost' ? '(Cost)' : '(Benefit)';

            html += `
            <div class="col-md-${Math.floor(12 / kriteria.length)} mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">${k.nama_kriteria}</h6>
                        <div class="progress">
                            <div class="progress-bar ${progressBarClass}" style="width: ${weight}%">
                                ${weight.toFixed(2)}%
                            </div>
                        </div>
                        <small class="text-muted">${tipText}</small>
                    </div>
                </div>
            </div>
        `;
        });

        $('#criteriaWeights').html(html);
    }

    // Event listeners
    $(document).ready(function() {
        displayComparedCars();
        displayCriteriaWeights();
        // calculateSMART();

        // Tombol ubah perbandingan
        $('#changeComparison').click(function() {
            window.location.href = '/';
        });

        // Tombol kembali
        $('#backToList').click(function() {
            window.location.href = '/';
        });

        // Tombol beli rekomendasi terbaik
        // $('#buyRecommended').click(function() {
        //     const bestCarId = $('#rankingResults tbody tr:first-child .buy-btn').data('id');
        //     if (bestCarId) {
        //         window.location.href = `/beli?car=${bestCarId}`;
        //     }
        // });

        // // Tombol beli di tabel ranking
        // $(document).on('click', '.buy-btn', function() {
        //     const carId = $(this).data('id');
        //     window.location.href = `/beli?car=${carId}`;
        // });
    });
</script>
<?= $this->endSection('scripts') ?>

<?= $this->endSection('content-utama') ?>