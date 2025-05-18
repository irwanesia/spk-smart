<?= $this->extend('layout/template') ?>

<!-- css -->
<?= $this->section('css') ?>
<style>
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .is-invalid {
        border-color: #dc3545;
    }
</style>
<?= $this->endSection('css') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php if (session()->get('role') === 'sales') : ?>
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title">Data Pelanggan</h4>
                    </div>
                    <!-- tampilkan menu khusus sales -->
                    <div class="table-responsive">
                        <table id="datatable" class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Registrasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($pelanggan as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['no_telp'] ?></td>
                                        <td><?= $row['alamat'] ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /table responsive-->
                <?php else : ?>
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mt-0 header-title">Daftar Users</h4>
                        <!-- <a href="<?= base_url('/users/tambah') ?>" class="btn btn-primary btn-rounded waves-effect waves-light"><i class="mdi mdi-plus-circle-outline"></i> Add</a> -->
                        <button type="button" class="btn btn-sm btn-primary btn-rounded" data-toggle="modal" data-animation="bounce" data-target=".add">
                            <i class="mdi mdi-plus-circle-outline"></i> Add
                        </button>
                    </div>

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

                    <?php if (session('arsipkan')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul>
                                <?php foreach (session('arsipkan') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table id="datatable" class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($users as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['alamat'] ?></td>
                                        <td><?= $row['role'] ?></td>
                                        <td>
                                            <form action="/users/edit/<?= $row['id_user'] ?>" method="get" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="GET">
                                                <button type="button" class="btn btn-sm btn-warning btn-rounded" data-toggle="modal" data-animation="bounce" data-target="#editModal<?= $row['id_user'] ?>">
                                                    <i class="mdi mdi-pencil-box"></i>
                                                </button>
                                                <!-- <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light"><i class="mdi mdi-pencil"></i> </button> -->
                                            </form>
                                            <form action="/users/hapus/<?= $row['id_user'] ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light delete-btn" data-name="<?= esc($row['nama']) ?>">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /tableresponsive-->
                <?php endif ?>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->
</div>

<?php include('form-modal.php') ?>

<?= $this->section('scripts') ?>
<!-- kode js -->
<?= $this->endSection('scripts') ?>

<?= $this->endSection('content') ?>