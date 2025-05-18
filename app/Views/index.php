<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row mt-n5">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Dashboard <?= $_SESSION['role'] == 'admin' ? 'Admin' : ($_SESSION['role'] == 'sales' ? 'Sales' : 'Pelanggan') ?></h4>
            <p class="text-muted">Selamat Datang, <?= ucfirst($_SESSION['nama']) ?>!</p>
        </div>
    </div>
</div>

<?php if (session()->get('role') === 'sales') : ?>
    <!-- tampilkan menu khusus sales -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-account-multiple text-purple"></i>
                            </div>
                        </div>
                        <div class="col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-1 text-muted">Total Pelanggan</p>
                                <h4 class="mt-0 mb-1"><?= $jumlah_pelanggan ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-calendar-text-outline text-pink"></i>
                            </div>
                        </div>
                        <div class="col-sm-8 col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-1 text-muted">Pembelian Terakhir</p>
                                <h4 class="mt-0 mb-1"><?= $tanggal_terakhir ? date('d M Y', strtotime($tanggal_terakhir)) : 'Belum ada data' ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-pink" role="progressbar" style="width: 22%;" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-playlist-check text-success"></i>
                            </div>
                        </div>
                        <div class="col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-0 text-muted">Nama Sales</p>
                                <h4 class="mt-0 mb-1"><?= session()->get('nama') ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 48%;" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div>

    <div class="row mt-1">
        <!-- Tabel Daftar Pelanggan -->
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">Daftar Pelanggan Saya</h6>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Pembelian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pelanggan)) : ?>
                                <?php $no = 1;
                                foreach ($pelanggan as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['no_telp'] ?></td>
                                        <td><?= date('d M Y', strtotime($row['tanggal_pembelian'])) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data pelanggan</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php else : ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-cube-send text-warning"></i>
                            </div>
                        </div>
                        <div class="col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-1 text-muted">Mobil</p>
                                <h4 class="mt-0 mb-1"><?= $countMobil ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-library-books text-pink"></i>
                            </div>
                        </div>
                        <div class="col-sm-8 col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-1 text-muted">Pembelian</p>
                                <h4 class="mt-0 mb-1"><?= $countPembelian ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-pink" role="progressbar" style="width: 22%;" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-playlist-check text-success"></i>
                            </div>
                        </div>
                        <div class="col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-0 text-muted">Kriteria</p>
                                <h4 class="mt-0 mb-1"><?= $countKriteria ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 48%;" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center">
                            <div class="icon-info">
                                <i class="mdi mdi-account-multiple text-purple"></i>
                            </div>
                        </div>
                        <div class="col-8 align-self-center text-right">
                            <div class="ml-2">
                                <p class="mb-1 text-muted">Users</p>
                                <h4 class="mt-0 mb-1 d-inline-block"><?= $countUser ?></h4>
                                <span class="badge badge-soft-success mt-1 shadow-none">Active</span>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height:3px;">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

    </div>

    <div class="row">
        <!-- Grafik Pembelian Mobil perbulan -->
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0">Statistik Pembelian per Bulan</h4>
                    <div class="">
                        <div id="statistikMobil" class="apex-charts"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div>

        <!-- Top Mobil Terpilih -->
        <div class="col-xl-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body ">
                            <a href="" class="float-right text-info">View All</a>
                            <h4 class="header-title mt-0 mb-3">Top Mobil Paling Sering Dipilih </h4>
                            <ul class="list-unsyled m-0 pl-0 transaction-history">
                                <?php foreach ($topMobil as $top) : ?>
                                    <li class="align-items-center d-flex justify-content-between">
                                        <div class="media">
                                            <div class="transaction-icon">
                                                <i class="mdi mdi-arrow-top-right-thick"></i>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <div class="transaction-data">
                                                    <h3 class="m-0"><?= $top['nama_mobil'] . " " . $top['tahun']  ?></h3>
                                                    <p class="text-muted mb-0"><?= $top['terakhir_dibeli'] ?></p>
                                                </div>
                                            </div><!--end media body-->
                                        </div>
                                        <span class="text-danger"><?= $top['jumlah_pembelian'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
            </div>
        </div>
    </div>

    <!-- Progress Penilaian -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Progress Penilaian Mobil </h4>
                    <p><?= $mobilDinilai ?> dari <?= $totalMobil ?> mobil sudah dinilai</p>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?= $persentase ?>%;" role="progressbar">
                            <?= $persentase ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Buka modal jika ada error dan show_modal = 'add'
        <?php if (session('errors') && session('show_modal') == 'add'): ?>
            $('.modal.add').modal('show');
            // Auto-focus ke field pertama yang error
            const firstErrorField = $('.modal.add .is-invalid').first();
            if (firstErrorField.length) {
                firstErrorField.focus();
            }
        <?php endif; ?>

        // Reset form saat modal ditutup
        $('.modal.add').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();
        });

        // Handle form submission (disable button)
        $('form').submit(function() {
            $(this).find('[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        });
    });
</script>

<script>
    var options = {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'Jumlah Pembelian',
            data: <?= $chartData ?>
        }],
        xaxis: {
            categories: <?= $chartLabels ?>
        },
        colors: ['#00B894']
    };

    var chart = new ApexCharts(document.querySelector("#statistikMobil"), options);
    chart.render();
</script>

<?= $this->endSection('scripts') ?>

<?= $this->endSection('content') ?>