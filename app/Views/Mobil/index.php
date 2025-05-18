<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mt-0 header-title">Data <?= $title ?></h4>
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

                <!-- Konten tabel tetap sama -->
                <div class="table-responsive">
                    <table id="datatable" class="table mb-0 table-centered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mobil</th>
                                <th>Merk/Tahun</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Tersedia</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($mobil as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama_mobil'] ?></td>
                                    <td><?= $row['merk'] . " - " . $row['tahun'] ?></td>
                                    <td><?= rupiah($row['harga']) ?></td>
                                    <td>
                                        <?php if (isset($row['gambar'])): ?>
                                            <img src="<?= base_url('uploads/' . $row['gambar']) ?>" width="100" class="mt-2 img-thumbnail">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['deskripsi'] ?></td>
                                    <td><?= $row['tersedia'] == '1' ? 'Ya' : 'Tidak' ?></td>
                                    <td>
                                        <form action="/mobil/edit/<?= $row['id_mobil'] ?>" method="get" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="GET">
                                            <button type="button" class="btn btn-sm btn-warning btn-rounded" data-toggle="modal" data-animation="bounce" data-target="#editModal<?= $row['id_mobil'] ?>">
                                                <i class="mdi mdi-pencil-box"></i>
                                            </button>
                                        </form>
                                        <form action="/mobil/hapus/<?= $row['id_mobil'] ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger btn-sm waves-effect waves-light delete-btn" data-name="<?= esc($row['nama_mobil']) ?>">
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

<?= include('form-modal.php') ?>

<?= $this->endSection('content') ?>