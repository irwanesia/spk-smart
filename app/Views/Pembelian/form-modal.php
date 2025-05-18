<?php foreach ($pembelian as $data) : ?>
    <!-- modal edit atau tinjau -->
    <div class="modal fade edit-modal" id="editModal<?= $data['id_pembelian'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Edit pembelian</h5> -->
                    <h5 class="modal-title mt-0"><?= $data['status'] == 'approved' ? 'Detail Pembelian' : 'Form Edit Pembelian' ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="/pembelian/update/<?= $data['id_pembelian'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                    <input type="hidden" name="id_mobil" value="<?= $data['id_mobil'] ?>">
                    <input type="hidden" name="id_sales" value="<?= $data['id_sales'] ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Pembeli</label>
                                    <input type="text" name="" class="form-control" value="<?= old('nama_pembeli', $data['nama_user']) ?? '' ?>" readonly required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Mobil</label>
                                    <input type="text" name="" class="form-control" value="<?= old('nama_mobil', $data['nama_mobil']) ?? '' ?>" readonly required>
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>No. Telp</strong></label>
                                    <input type="text" name="no_telp" class="form-control <?= session('errors.no_telp') ? 'is-invalid' : '' ?>" value="<?= old('no_telp', $data['no_telp']) ?? '' ?>" required>
                                    <?php if (session('errors.no_telp')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.no_telp') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Pilih Sales -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Pilih Sales</strong></label>
                                    <select name="" class="form-control <?= session('errors.id_sales') ? 'is-invalid' : '' ?>" required>
                                        <option value="">-- Pilih Sales --</option>
                                        <?php foreach ($salesList as $sales): ?>
                                            <option value="<?= $sales['id_user'] ?>" <?= $sales['id_user'] == $data['id_sales'] ? 'selected' : '' ?>><?= esc($sales['nama']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.id_sales')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.id_sales') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tgl Pembelian</label>
                                    <input type="date" class="form-control <?= session('errors.tanggal_pembelian') ? 'is-invalid' : '' ?>" name="tanggal_pembelian" value="<?= old('tanggal_pembelian', $data['tanggal_pembelian']) ?? '' ?>" readonly />
                                </div>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Metode Pembayaran</strong></label>
                                    <select class="form-control <?= session('errors.payment_method') ? 'is-invalid' : '' ?>" name="payment_method" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="transfer" <?= $data['metode_pembayaran'] == 'transfer' ? 'selected' : '' ?>>Transfer Bank</option>
                                        <option value="credit" <?= $data['metode_pembayaran'] == 'credit' ? 'selected' : '' ?>>Kartu Kredit</option>
                                        <option value="cash" <?= $data['metode_pembayaran'] == 'cash' ? 'selected' : '' ?>>Tunai</option>
                                    </select>
                                    <?php if (session('errors.payment_method')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.payment_method') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Metode status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control <?= session('errors.status') ? 'is-invalid' : '' ?>" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="disetujui" <?= $data['status'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                        <option value="ditolak" <?= $data['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                    <?php if (session('errors.status')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.status') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Catatan</label>
                                    <textarea name="catatan" class="form-control <?= session('errors.catatan') ? 'is-invalid' : '' ?>" rows="3"><?= old('catatan', $data['catatan']) ?? '' ?></textarea>
                                    <?php if (session('errors.catatan')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.catatan') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- alamat -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Alamat Pengiriman</label>
                                    <textarea name="alamat" class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" rows="3" required><?= old('alamat', $data['alamat']) ?? '' ?></textarea>
                                    <?php if (session('errors.alamat')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.alamat') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="mdi mdi-update"></i> Update</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="mdi mdi-cancel"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal view -->
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal<?= $data['id_pembelian'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light text-white">
                    <h5 class="modal-title">Detail Pembelian #<?= $data['id_pembelian'] ?></h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="card-title mb-0">Informasi Pembeli</h6>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Nama</dt>
                                        <dd class="col-sm-8"><?= esc($data['nama_user']) ?></dd>

                                        <dt class="col-sm-4">No. Telepon</dt>
                                        <dd class="col-sm-8"><?= esc($data['no_telp']) ?></dd>

                                        <dt class="col-sm-4">Alamat</dt>
                                        <dd class="col-sm-8"><?= esc($data['alamat']) ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="card-title mb-0">Informasi Mobil</h6>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Nama Mobil</dt>
                                        <dd class="col-sm-8"><?= esc($data['nama_mobil']) ?></dd>

                                        <dt class="col-sm-4">Sales</dt>
                                        <dd class="col-sm-8"><?= esc($data['nama_sales'] ?? '-') ?></dd>

                                        <dt class="col-sm-4">Tanggal Pembelian</dt>
                                        <dd class="col-sm-8"><?= date('d F Y', strtotime($data['tanggal_pembelian'])) ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="card-title mb-0">Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Metode</dt>
                                        <dd class="col-sm-8 text-capitalize"><?= esc($data['metode_pembayaran']) ?></dd>

                                        <dt class="col-sm-4">Status</dt>
                                        <dd class="col-sm-8">
                                            <?php
                                            $badgeClass = [
                                                'pending' => 'badge-warning',
                                                'disetujui' => 'badge-success',
                                                'ditolak' => 'badge-danger'
                                            ][strtolower($data['status'])] ?? 'badge-secondary';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= esc($data['status']) ?></span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="card-title mb-0">Catatan</h6>
                                </div>
                                <div class="card-body">
                                    <?= $data['catatan'] ? nl2br(esc($data['catatan'])) : '<span class="text-muted">Tidak ada catatan</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <?php if ($data['status'] !== 'approved') : ?>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#editModal<?= $data['id_pembelian'] ?>">
                            <i class="mdi mdi-pencil"></i> Edit
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>