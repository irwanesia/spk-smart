<!-- Modal untuk form pembelian -->
<?php if (session()->has('logged_in')) : ?>
    <?php foreach ($dataMobil as $data) : ?>
        <div class="modal fade" id="purchaseModal<?= md5($data['nama_mobil']) ?>" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Pembelian - <?= esc($data['nama_mobil']) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="<?= base_url('pembelian/simpan') ?>" method="POST">
                        <?= csrf_field() ?>
                        <!-- Hidden Fields -->
                        <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?? null ?>">
                        <input type="hidden" name="id_mobil" value="<?= $data['id_mobil'] ?>">
                        <input type="hidden" name="tgl_pembelian" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="cars" value="<?= $_GET['cars'] ?? '' ?>">
                        <input type="hidden" name="status" value="proses">

                        <div class="modal-body">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">Detail Mobil</h5>
                                    <div class="mb-3">
                                        <table>
                                            <tr>
                                                <th>Nama Mobil</th>
                                                <td> : </td>
                                                <td> <?= esc($data['nama_mobil']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Merk</th>
                                                <td> : </td>
                                                <td> <?= esc($data['merk']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Harga</th>
                                                <td> : </td>
                                                <td> Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Deskripsi</th>
                                                <td> : </td>
                                                <td> <?= esc($data['deskripsi']) ?></td>
                                            </tr>
                                        </table>
                                        <img src="<?= base_url('uploads/' . $data['gambar']) ?>" alt="Foto Mobil" class="img-thumbnail my-3" style="max-width: 100%; height: auto;">
                                    </div>

                                    <hr>

                                    <h6 class="text-secondary mb-3">Informasi Pembeli</h6>
                                    <div class="row">
                                        <!-- Nama Pembeli -->
                                        <div class="col-md-6 mb-3">
                                            <label><strong>Nama Lengkap</strong></label>
                                            <input type="text" class="form-control" name="nama_pembeli" value="<?= esc($dataUsers['nama']) ?>" readonly>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" value="<?= esc($dataUsers['email']) ?>" readonly>
                                        </div>

                                        <!-- Alamat -->
                                        <div class="col-md-12 mb-3">
                                            <label><strong>Alamat Pengiriman</strong></label>
                                            <textarea class="form-control" name="alamat_pengiriman" rows="2" readonly><?= esc($dataUsers['alamat']) ?></textarea>
                                        </div>

                                        <!-- Nomor Telepon -->
                                        <div class="col-md-6 mb-3">
                                            <label><strong>No. Telp</strong></label>
                                            <!-- <input type="text" name="no_telp" class="form-control" placeholder="Masukkan nomor telepon" required> -->
                                            <input type="text" name="no_telp" class="form-control"
                                                placeholder="Masukkan nomor telepon"
                                                required
                                                pattern="[0-9]+"
                                                minlength="10"
                                                maxlength="15">

                                        </div>

                                        <!-- Pilih Sales -->
                                        <div class="col-md-6 mb-3">
                                            <label><strong>Pilih Sales</strong></label>
                                            <select name="id_sales" class="form-control" required>
                                                <option value="">-- Pilih Sales --</option>
                                                <?php foreach ($salesList as $sales): ?>
                                                    <option value="<?= $sales['id_user'] ?>"><?= esc($sales['nama']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Metode Pembayaran -->
                                        <div class="col-md-12 mb-3">
                                            <label><strong>Metode Pembayaran</strong></label>
                                            <select class="form-control" name="payment_method" required>
                                                <option value="">-- Pilih metode pembayaran --</option>
                                                <option value="transfer">Transfer Bank</option>
                                                <option value="credit">Kartu Kredit</option>
                                                <option value="cash">Tunai</option>
                                            </select>
                                        </div>

                                        <!-- Catatan (Optional) -->
                                        <div class="col-md-12 mb-3">
                                            <label><strong>Catatan</strong> <small class="text-muted">(Opsional)</small></label>
                                            <textarea class="form-control" name="catatan" rows="2" placeholder="Tulis catatan jika ada..."></textarea>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning mt-3" role="alert">
                                        Apakah Anda yakin ingin membeli <strong><?= esc($data['nama_mobil']) ?></strong>?
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">✅ Konfirmasi Beli</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">❌ Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <?php foreach ($dataMobil as $data) : ?>
        <div class="modal fade" id="purchaseModal<?= md5($data['nama_mobil']) ?>" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login Required</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Silahkan login terlebih dahulu, untuk melakukan pembelian!</p>
                        <a href="<?= base_url('login') ?>" class="btn btn-primary">Login</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>