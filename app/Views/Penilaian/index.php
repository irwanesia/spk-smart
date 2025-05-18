<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 mb-4 header-title">Data <?= $title ?></h4>

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

                <?php if (!empty($mobil)) : ?>
                    <div class="table-responsive">
                        <table id="datatable" class="table mb-0 table-centered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama mobil</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($mobil as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nama_mobil'] ?></td>
                                        <td>
                                            <?php if (!empty(($row['isPenilaianExists']))) : ?>
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-sm btn-warning btn-rounded" data-toggle="modal" data-target="#editModal<?= $row['id_mobil'] ?>">
                                                    <i class="mdi mdi-pencil-box"></i>
                                                </button>

                                                <form action="/penilaian/hapus/<?= $row['id_mobil'] ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-danger btn-rounded delete-btn" data-name="<?= esc($row['nama_mobil']) ?>">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-sm btn-primary btn-rounded" data-toggle="modal" data-target="#addModal<?= $row['id_mobil'] ?>">
                                                    <i class="mdi mdi-plus-circle-outline"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /tableresponsive-->
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        Data tidak ditemukan!
                    </div>
                <?php endif ?>
            </div>
        </div><!--end card-->
    </div> <!-- end col -->
</div>
<!-- jika tidak ada data tampilkan pesan -->

<?php include('form-modal.php') ?>

<?= $this->endSection('content') ?>