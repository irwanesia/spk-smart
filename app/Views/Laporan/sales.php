<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">
        <!-- Judul -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Laporan Saya</h4>
                </div>
            </div>
        </div>

        <!-- Card Ringkasan -->
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-soft-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Pelanggan</h5>
                        <h3 class="mb-0"><?= $totalPelanggan ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-soft-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Penilaian</h5>
                        <h3 class="mb-0"><?= $totalPenilaian ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title">Detail Penilaian Pelanggan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Mobil Dibeli</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Status Penilaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($pelanggan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($p['nama']) ?></td>
                                            <td><?= esc($p['nama_mobil']) ?></td>
                                            <td><?= esc($p['tanggal_pembelian']) ?></td>
                                            <td>
                                                <?php // if ($p['status_penilaian'] == 'Sudah'): 
                                                ?>
                                                <span class="badge badge-success">Sudah</span>
                                                <?php // else: 
                                                ?>
                                                <span class="badge badge-danger">Belum</span>
                                                <?php // endif; 
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($pelanggan)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Export Buttons (opsional) -->
                        <div class="mt-3">
                            <a href="<?= base_url('sales/export/pdf') ?>" class="btn btn-outline-danger"><i class="mdi mdi-file-pdf"></i> Export PDF</a>
                            <a href="<?= base_url('sales/export/excel') ?>" class="btn btn-outline-success"><i class="mdi mdi-file-excel"></i> Export Excel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content') ?>