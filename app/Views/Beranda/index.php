<?= $this->extend('layout/public') ?>

<?= $this->section('content-utama') ?>
<div class="jumbotron text-center bg-light">
    <h1 class="display-4">Selamat Datang di AutoCompare</h1>
    <p class="lead">Platform untuk membandingkan harga dan spesifikasi mobil sebelum Anda membeli menggunakan metode SMART.</p>
    <hr class="my-4">
    <a class="btn btn-primary btn-lg" href="<?= base_url('/bandingkan') ?>" role="button">Bandingkan Mobil</a>
</div>

<div class="container">
    <h3 class="text-center mb-4">Mobil Terbaru</h3>
    <div class="row">
        <?php foreach ($mobil_terbaru as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= base_url('/uploads/' . ($item['gambar'] ?: 'default.png')) ?>" class="card-img-top" alt="<?= $item['nama_mobil'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['nama_mobil'] ?></h5>
                        <p class="card-text">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#detailModal<?= $item['id_mobil'] ?>">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('detail-modal.php') ?>
<!-- akses form modal berbeda folder di view -->
<?php include('form-modal.php') ?>

<?= $this->section('script') ?>
<?= $this->endSection('script') ?>

<?= $this->endSection() ?>