<!-- modal add -->
<div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Tambah Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="/users/simpan" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" name="nama" value="<?= old('nama') ?>" placeholder="Masukan nama" autofocus>
                                <?php if (session('errors.nama')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.nama') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">email</label>
                                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="Masukan email" value="<?= old('email') ?>">
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telp">Password</label>
                                <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="Password">
                                <?php if (session('errors.password')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telp">Ulangi Password</label>
                                <input type="password" class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" name="confirm_password" placeholder="Ulangi password">
                                <?php if (session('errors.confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.confirm_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Role</label>
                                <select name="role" class="form-control <?= session('errors.role') ? 'is-invalid' : '' ?>">
                                    <option value="" selected disabled>-- Pilih --</option>
                                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="pelanggan" <?= old('role') == 'pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
                                    <option value="sales" <?= old('role') == 'sales' ? 'selected' : '' ?>>Sales</option>
                                </select>
                                <?php if (session('errors.role')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.role') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telp">Alamat</label>
                                <textarea name="alamat" class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" id="" cols="10" rows="3"><?= old('alamat') ?></textarea>
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
                    <button type="submit" class="btn btn-sm btn-primary"><i class="mdi mdi-content-save"></i> Submit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="mdi mdi-cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit -->
<?php foreach ($users as $user) : ?>
    <div class="modal fade edit-modal" id="editModal<?= $user['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Edit Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="/users/update/<?= $user['id_user'] ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" name="nama" value="<?= old('nama', $user['nama'] ?? '') ?>" placeholder="Masukan nama" autofocus>
                                    <?php if (session('errors.nama')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">email</label>
                                    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" placeholder="Masukan email" value="<?= old('email', $user['email'] ?? '') ?>">
                                    <?php if (session('errors.email')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telp">Password</label>
                                    <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" placeholder="Password">
                                    <?php if (session('errors.password')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telp">Ulangi Password</label>
                                    <input type="password" class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" name="confirm_password" placeholder="Ulangi password">
                                    <?php if (session('errors.confirm_password')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.confirm_password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Role</label>
                                    <select name="role" class="form-control <?= session('errors.role') ? 'is-invalid' : '' ?>">
                                        <option value="" selected disabled>-- Pilih --</option>
                                        <option value="admin" <?= old('role', $user['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="pelanggan" <?= old('role', $user['role'] ?? '') == 'pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
                                        <option value="sales" <?= old('role', $user['role'] ?? '') == 'sales' ? 'selected' : '' ?>>Sales</option>
                                    </select>
                                    <?php if (session('errors.role')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.role') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telp">Alamat</label>
                                    <textarea name="alamat" class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" id="" cols="10" rows="3"><?= old('alamat', $user['alamat'] ?? '') ?></textarea>
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

<?php endforeach ?>