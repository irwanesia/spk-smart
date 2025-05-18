<!-- modal add -->
<div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Tambah Mobil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="/mobil/simpan" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Mobil</label>
                                <input type="text" class="form-control <?= session('errors.nama_mobil') ? 'is-invalid' : '' ?>" name="nama_mobil" value="<?= old('nama_mobil') ?>" placeholder="Masukan nama mobil">
                                <?php if (session('errors.nama_mobil')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.nama_mobil') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Merk</label>
                                <input type="text" class="form-control <?= session('errors.merk') ? 'is-invalid' : '' ?>" name="merk" value="<?= old('merk') ?>" placeholder="Masukan merk mobil">
                                <?php if (session('errors.merk')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.merk') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input type="number" name="harga" value="<?= old('harga') ?>" class="form-control <?= session('errors.harga') ? 'is-invalid' : '' ?>" placeholder="Masukan harga" required />
                                <?php if (session('errors.harga')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.harga') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tahun</label>
                                <input type="number" name="tahun" value="<?= old('tahun') ?>" class="form-control <?= session('errors.tahun') ? 'is-invalid' : '' ?>" placeholder="Masukan tahun" required />
                                <?php if (session('errors.tahun')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.tahun') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Gambar</label>
                                <input type="file" class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" name="gambar" value="<?= old('gambar') ?>" placeholder="Masukan mobil" autofocus>
                                <?php if (session('errors.gambar')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.gambar') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tersedia</label>
                                <select name="tersedia" class="form-control <?= session('errors.tersedia') ? 'is-invalid' : '' ?>">
                                    <option value="1" selected>Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                <?php if (session('errors.tersedia')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.tersedia') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>" cols="30" rows="3" placeholder="deskripsi.."><?= old('deskripsi') ?? '' ?></textarea>
                                <?php if (session('errors.deskripsi')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.deskripsi') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="mdi mdi-content-save"></i> Submit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="mdi mdi-cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit -->
<?php foreach ($mobil as $data) : ?>
    <div class="modal fade edit-modal" id="editModal<?= $data['id_mobil'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Edit Mobil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="/mobil/update/<?= $data['id_mobil'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_mobil" value="<?= $data['id_mobil'] ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Mobil</label>
                                    <input type="text" class="form-control <?= session('errors.nama_mobil') ? 'is-invalid' : '' ?>" name="nama_mobil" value="<?= old('nama_mobil', $data['nama_mobil']) ?? '' ?>">
                                    <?php if (session('errors.nama_mobil')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama_mobil') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Merk</label>
                                    <input type="text" class="form-control <?= session('errors.merk') ? 'is-invalid' : '' ?>" name="merk" value="<?= old('merk', $data['merk']) ?? '' ?>">
                                    <?php if (session('errors.merk')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.merk') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <input type="number" class="form-control <?= session('errors.harga') ? 'is-invalid' : '' ?>" name="harga" value="<?= old('harga', $data['harga']) ?? '' ?>" />
                                    <?php if (session('errors.harga')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.harga') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <input type="number" class="form-control <?= session('errors.tahun') ? 'is-invalid' : '' ?>" name="tahun" value="<?= old('tahun', $data['tahun']) ?? '' ?>" />
                                    <?php if (session('errors.tahun')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.tahun') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" name="gambar" class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>">
                                    <?php if (session('errors.gambar')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.gambar') ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Preview Gambar -->
                                    <?php if ($data['gambar']) : ?>
                                        <img src="<?= base_url('uploads/' . $data['gambar']) ?>" width="150" class="mt-2 img-thumbnail">
                                        <small class="text-muted d-block">Gambar saat ini</small>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tersedia</label>
                                    <select name="tersedia" class="form-control <?= session('errors.tersedia') ? 'is-invalid' : '' ?>">
                                        <option value="1" <?= old('tersedia', $data['tersedia'] ?? '') == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= old('tersedia', $data['tersedia'] ?? '') == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                    <?php if (session('errors.tersedia')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.tersedia') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>" cols="30" rows="3"><?= old('deskripsi', $data['deskripsi']) ?? '' ?></textarea>
                                    <?php if (session('errors.deskripsi')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.deskripsi') ?>
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

<?php endforeach ?>