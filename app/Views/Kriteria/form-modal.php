<!-- modal add kriteria -->
<div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="/kriteria/simpan" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Kriteria</label>
                                <input type="text" class="form-control <?= session('errors.kode_kriteria') ? 'is-invalid' : '' ?>" name="kode_kriteria" value="<?= $kode ?>" readonly>
                                <?php if (session('errors.kode_kriteria')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.kode_kriteria') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tipe</label>
                                <select name="tipe" class="form-control <?= session('errors.tipe') ? 'is-invalid' : '' ?>">
                                    <option selected disabled>-- Pilih --</option>
                                    <option value="benefit" <?= old('tipe') == 'benefit' ? 'selected' : '' ?>>Benefit</option>
                                    <option value="cost" <?= old('tipe') == 'cost' ? 'selected' : '' ?>>Cost</option>
                                </select>
                                <?php if (session('errors.tipe')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.tipe') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nama Kriteria</label>
                                <input type="text" class="form-control <?= session('errors.nama_kriteria') ? 'is-invalid' : '' ?>" name="nama_kriteria" value="<?= old('nama_kriteria') ?>" placeholder="Masukan kriteria" autofocus>
                                <?php if (session('errors.nama_kriteria')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.nama_kriteria') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Bobot</label>
                                <input type="number" name="bobot" step="0.01" value="<?= old('bobot') ?>" class="form-control <?= session('errors.bobot') ? 'is-invalid' : '' ?>" placeholder="Masukan bobot" required />
                                <?php if (session('errors.bobot')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.bobot') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Cara Penilaian</label>
                                <select name="pilih_inputan" class="form-control <?= session('errors.pilih_inputan') ? 'is-invalid' : '' ?>">
                                    <option selected disabled>-- Pilih --</option>
                                    <option value="input_langsung" <?= old('pilih_inputan') == 'input_langsung' ? 'selected' : '' ?>>Input Nilai Langsung</option>
                                    <option value="subkriteria" <?= old('pilih_inputan') == 'subkriteria' ? 'selected' : '' ?>>Pilih Subkriteria</option>
                                </select>
                                <?php if (session('errors.pilih_inputan')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.pilih_inputan') ?>
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

<?php foreach ($kriteria as $data) : ?>
    <!-- modal edit -->
    <div class="modal fade edit-modal" id="editModal<?= $data['id_kriteria'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Edit kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="/kriteria/update/<?= $data['id_kriteria'] ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kriteria" value="<?= $data['id_kriteria'] ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Kriteria</label>
                                    <input type="text" class="form-control <?= session('errors.kode_kriteria') ? 'is-invalid' : '' ?>" name="kode_kriteria" value="<?= $kode ?>" readonly>
                                    <?php if (session('errors.kode_kriteria')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kode_kriteria') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tipe</label>
                                    <select name="tipe" class="form-control <?= session('errors.tipe') ? 'is-invalid' : '' ?>">
                                        <option selected disabled>-- Pilih --</option>
                                        <option value="benefit" <?= (old('tipe', $data['tipe'] ?? '') == 'benefit') ? 'selected' : '' ?>>Benefit</option>
                                        <option value="cost" <?= (old('tipe', $data['tipe'] ?? '') == 'cost') ? 'selected' : '' ?>>Cost</option>
                                    </select>
                                    <?php if (session('errors.tipe')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.tipe') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nama Kriteria</label>
                                    <input type="text" class="form-control <?= session('errors.nama_kriteria') ? 'is-invalid' : '' ?>" name="nama_kriteria" value="<?= old('nama_kriteria', $data['nama_kriteria'] ?? '') ?>" placeholder="Masukan kriteria" autofocus>
                                    <?php if (session('errors.nama_kriteria')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama_kriteria') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bobot</label>
                                    <input type="number" name="bobot" step="0.01" value="<?= old('bobot', $data['bobot'] ?? '') ?>" class="form-control <?= session('errors.bobot') ? 'is-invalid' : '' ?>" placeholder="Masukan bobot" required />
                                    <?php if (session('errors.bobot')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.bobot') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cara Penilaian</label>
                                    <select name="pilih_inputan" class="form-control <?= session('errors.pilih_inputan') ? 'is-invalid' : '' ?>">
                                        <option selected disabled>-- Pilih --</option>
                                        <option value="input_langsung" <?= old('pilih_inputan', $data['pilih_inputan'] ?? '') == 'input_langsung' ? 'selected' : '' ?>>Input Nilai Langsung</option>
                                        <option value="subkriteria" <?= old('pilih_inputan', $data['pilih_inputan'] ?? '') == 'subkriteria' ? 'selected' : '' ?>>Pilih Subkriteria</option>
                                    </select>
                                    <?php if (session('errors.pilih_inputan')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.pilih_inputan') ?>
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

    <!-- modal add dan edit subkriteria -->
    <!-- modal add subkriteria -->
    <div class="modal fade addSubkriteria-modal" id="addSubModal<?= $data['id_kriteria'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Tambah Subkriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="/subkriteria/simpan" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kriteria" value="<?= $data['id_kriteria'] ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nama Subkriteria</label>
                                    <input type="text" class="form-control <?= session('errors.nama_subkriteria') ? 'is-invalid' : '' ?>" name="nama_subkriteria" value="<?= old('nama_subkriteria') ?>" placeholder="Masukan subkriteria" autofocus>
                                    <?php if (session('errors.nama_subkriteria')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama_subkriteria') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nilai</label>
                                    <input type="number" name="nilai" step="0.01" value="<?= old('nilai') ?>" class="form-control <?= session('errors.nilai') ? 'is-invalid' : '' ?>" placeholder="Masukan nilai" required />
                                    <?php if (session('errors.nilai')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nilai') ?>
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

    <!-- modal edit subkriteria -->
    <?php foreach ($subkriteria[$data['id_kriteria']] as $sub) : ?>
        <div class="modal fade editSubkriteria" id="editSubModal<?= $sub['id_subkriteria'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Tambah Subkriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="/subkriteria/update/<?= $sub['id_subkriteria'] ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_kriteria" value="<?= $sub['id_kriteria'] ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nama Subkriteria</label>
                                        <input type="text" class="form-control <?= session('errors.nama_subkriteria') ? 'is-invalid' : '' ?>" name="nama_subkriteria" value="<?= old('nama_subkriteria', $sub['nama_subkriteria']) ?>" placeholder="Masukan subkriteria" autofocus>
                                        <?php if (session('errors.nama_subkriteria')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.nama_subkriteria') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nilai</label>
                                        <input type="number" name="nilai" step="0.01" value="<?= old('nilai', $sub['nilai']) ?>" class="form-control <?= session('errors.nilai') ? 'is-invalid' : '' ?>" placeholder="Masukan nilai" required />
                                        <?php if (session('errors.nilai')): ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.nilai') ?>
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


<?php endforeach ?>