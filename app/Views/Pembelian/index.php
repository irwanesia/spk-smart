<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mt-0 header-title">Daftar <?= $title ?></h4>
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

                <!-- Konten tabel tetap sama -->
                <div class="table-responsive">
                    <table id="datatable" class="table mb-0 table-centered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pembeli</th>
                                <th>Nama Mobil</th>
                                <th>Nama Sales</th>
                                <th>Harga</th>
                                <th>Tgl Pembelian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($pembelian as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama_user'] ?></td>
                                    <td><?= $row['nama_mobil'] ?></td>
                                    <td><?= $row['nama_sales'] ?></td>
                                    <td><?= rupiah($row['harga']) ?></td>
                                    <td><?= $row['tanggal_pembelian'] ?></td>
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
                                    <td>
                                        <!-- Button View Detail -->
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal<?= $row['id_pembelian'] ?>">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        <form action="/pembelian/edit/<?= $row['id_pembelian'] ?>" method="get" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="GET">
                                            <button type="button" class="btn btn-sm btn-warning btn-rounded" data-toggle="modal" data-animation="bounce" data-target="#editModal<?= $row['id_pembelian'] ?>">
                                                <i class="mdi mdi-pencil-box"></i>
                                            </button>
                                        </form>
                                        <form action="/pembelian/hapus/<?= $row['id_pembelian'] ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger btn-sm waves-effect waves-light delete-btn" data-name="<?= esc($row['tanggal_pembelian']) ?>">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table><!--end /table-->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('form-modal.php') ?>

<?= $this->endSection('content') ?>