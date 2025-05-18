<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mt-0 header-title">Daftar Kriteria</h4>
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

                <div class="table-responsive">
                    <table id="datatable" class="table mb-0 table-centered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                                <th>Tipe</th>
                                <th>Pilihan Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($kriteria as $index => $row) :
                                $pilihInput = $row['pilih_inputan'];
                                $dNone = $pilihInput == 'input_langsung' ? 'd-none' : '';
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['kode_kriteria'] ?></td>
                                    <td><?= $row['nama_kriteria'] ?></td>
                                    <td><?= $row['tipe'] ?></td>
                                    <td><?= $row['bobot'] ?></td>
                                    <td><?= $row['pilih_inputan'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info btn-rounded <?= $dNone ?>" data-toggle="collapse" data-target="#collapse-<?= $index ?>" aria-expanded="false" aria-controls="collapse-<?= $index ?>">
                                            <i class="mdi mdi-arrow-down-bold-box"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-warning btn-rounded" data-toggle="modal" data-target="#editModal<?= $row['id_kriteria'] ?>">
                                            <i class="mdi mdi-pencil-box"></i>
                                        </button>

                                        <form action="/kriteria/hapus/<?= $row['id_kriteria'] ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger btn-rounded delete-btn" data-name="<?= esc($row['nama_kriteria']) ?>">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="collapse-row">
                                    <td colspan="6" class="p-0">
                                        <div class="collapse" id="collapse-<?= $index ?>">
                                            <div class="card card-body p-0">
                                                <table class="table table-sm table-centered dt-responsive mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Nama Subkriteria</th>
                                                            <th width="15%">Nilai</th>
                                                            <th width="15%">Aksi</th>
                                                            <th width="15%" class="text-center">
                                                                <button type="button" class="btn btn-sm btn-primary btn-rounded" data-toggle="modal" data-animation="bounce" data-target="#addSubModal<?= $row['id_kriteria']  ?>">
                                                                    <i class="mdi mdi-plus-circle-outline"></i> Add
                                                                </button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // var_dump($subkriteria[10]);
                                                        $nomor = 1;
                                                        // Cek apakah ada subkriteria untuk kriteria ini
                                                        if (isset($subkriteria[$row['id_kriteria']]) && !empty($subkriteria[$row['id_kriteria']])) :
                                                            foreach ($subkriteria[$row['id_kriteria']] as $sub) :
                                                        ?>
                                                                <tr>
                                                                    <td>(<?= $nomor++ ?>)</td>
                                                                    <td><?= $sub['nama_subkriteria'] ?></td>
                                                                    <td><?= $sub['nilai'] ?></td>
                                                                    <td>
                                                                        <!-- Tombol aksi subkriteria -->
                                                                        <button type="button" class="btn btn-sm btn-warning btn-rounded" data-toggle="modal" data-target="#editSubModal<?= $sub['id_subkriteria'] ?>">
                                                                            <i class="mdi mdi-pencil-box"></i>
                                                                        </button>

                                                                        <form action="/subkriteria/hapus/<?= $sub['id_subkriteria'] ?>" method="post" class="d-inline">
                                                                            <?= csrf_field() ?>
                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                            <button type="submit" class="btn btn-sm btn-danger btn-rounded delete-btn" data-name="<?= esc($sub['nama_subkriteria']) ?>">
                                                                                <i class="mdi mdi-delete"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            endforeach;
                                                        else :
                                                            ?>
                                                            <tr>
                                                                <td colspan="4" class="text-center">Tidak ada subkriteria</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table><!--end /table-->
                </div><!--end /tableresponsive-->
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- jika tidak ada data tampilkan pesan -->

<?= include('form-modal.php') ?>

<?= $this->endSection('content') ?>