<?= $this->extend('layout/public') ?>

<?= $this->section('content-utama') ?>

<div class="container mt-4">
    <h4 class="mb-3">Filter Harga Mobil</h4>
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <input type="range" class="custom-range" id="hargaRange" min="100000000" max="1000000000" step="50000000" value="1000000000">
        </div>
        <div class="col-md-6">
            <span id="hargaValue">Rp 1.000.000.000</span>
        </div>
    </div>

    <!-- Tombol bandingkan dan indikator jumlah mobil terpilih -->
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <span id="compareCounter" class="badge badge-primary mr-2" style="display: none;">0</span>
            <button id="compareBtn" class="btn btn-primary" disabled>
                <i class="mdi mdi-comment-plus"></i> Bandingkan Sekarang
            </button>
        </div>
    </div>

    <div class="row" id="daftarMobil">
        <!-- Contoh kartu mobil -->
        <?php foreach ($dataMobil as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php
                    // Cek apakah gambar ada, jika tidak tampilkan gambar default
                    if (empty($item['gambar'])) {
                        $image = 'default.png'; // Gambar default
                    } else {
                        $image = $item['gambar'];
                    }
                    ?>
                    <img src="<?= base_url() . "/uploads/" . $image ?>" class="card-img-top" alt="<?= $item['nama_mobil'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['nama_mobil'] ?></h5>
                        <p class="card-text">
                            <span class="font-weight-bold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span><br>
                            Merk: <?= $item['merk'] ?> </br>
                            Tahun: <?= $item['tahun'] ?> </br>
                            Deskripsi: <?= $item['deskripsi'] ?>
                        </p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm add-to-compare" data-id="<?= $item['id_mobil'] ?>">
                                <i class="fa fa-plus-circle"></i> Bandingkan
                            </button>
                            <button class="btn btn-primary btn-sm buy-btn" data-toggle="modal"
                                data-target="#purchaseModal<?= md5($item['nama_mobil']) ?>">
                                <i class="fa fa-shopping-cart"></i> Beli
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('form-modal.php') ?>

<?= $this->Section('scripts') ?>
<script>
    $(document).ready(function() {
        $('.add-to-compare').on('click', function() {
            const idMobil = $(this).data('id');
            const idUser = <?= $_SESSION['id_user'] ?? null; ?>; // Pastikan session tersedia

            $.ajax({
                url: '<?= base_url("perhitungan_temp/simpan") ?>',
                method: 'POST',
                data: {
                    id_user: idUser,
                    id_mobil: idMobil
                },
                success: function(response) {
                    console.log(response);
                    // Tambahkan logika update badge jumlah mobil
                    let counter = $('#compareCounter');
                    let count = parseInt(counter.text()) || 0;
                    count++;
                    counter.text(count).show();
                    $('#compareBtn').prop('disabled', false);
                },
                error: function() {
                    alert('Gagal menambahkan ke perbandingan.');
                }
            });
        });
    });
</script>

<?= $this->endSection('scripts') ?>

<?= $this->endSection('content-utama') ?>