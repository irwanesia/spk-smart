<?= $this->extend('layout/public') ?>

<?= $this->section('content-utama') ?>
<div class="container">
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-12 text-center">
            <h2>Riwayat Pembelian Mobil</h2>
            <p>Berikut adalah riwayat pembelian mobil Anda.</p>
            <div class="card">
                <div class="card-body">
                    <!-- Notifikasi -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($riwayatPembelian)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mobil</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Alamat Pengiriman</th>
                                        <th>Sales</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($riwayatPembelian as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($row['nama_mobil']) ?></td>
                                            <td><?= date('d M Y', strtotime($row['tanggal_pembelian'])) ?></td>
                                            <td><?= esc($row['alamat']) ?></td>
                                            <td><?= esc($row['nama_sales']) ?></td>
                                            <td>
                                                <?php
                                                $status = esc($row['status']);
                                                $badgeClasses = [
                                                    'disetujui' => 'badge-success',
                                                    'ditolak'   => 'badge-danger',
                                                    'proses'    => 'badge-primary',
                                                    'pending'   => 'badge-warning'
                                                ];
                                                $badgeClass = $badgeClasses[strtolower($status)] ?? 'badge-secondary';
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info">Belum ada pembelian.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content-utama') ?>