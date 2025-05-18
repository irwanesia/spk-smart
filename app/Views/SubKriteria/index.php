<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <form id="bahanBakuForm">
                        <?= csrf_field() ?>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control" name="id_bahan_baku" id="id_bahan_baku">
                                    <option selected disabled>-- Pilih Bahan Baku --</option>
                                    <?php foreach ($bahanBaku as $item) : ?>
                                        <option value="<?= $item['id_bahan_baku'] ?>" <?= $item['id_bahan_baku'] == $id_bahan_baku ? 'selected' : '' ?>><?= $item['nama_bahan'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- cek apakah ada data id bahan baku -->
                <?php if (!empty($id_bahan_baku)) : ?>

                    <?php if ($kriteria): ?>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h4 class="header-title mt-0 mb-3">Kriteria</h4>
                                        <div class="files-nav">
                                            <div class="nav flex-column nav-pills" id="files-tab" aria-orientation="vertical">
                                                <?php foreach ($kriteria as $index => $row) : ?>
                                                    <a class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="" data-toggle="pill" href="#<?= $row['kode_kriteria'] ?>" aria-selected="false">
                                                        <i class="em em-file_folder mr-3 text-warning d-inline-block"></i>
                                                        <div class="d-inline-block align-self-center">
                                                            <h5 class="m-0"><?= $row['kriteria'] ?></h5>
                                                            <small class="text-muted"><?= $row['kode_kriteria'] ?></small>
                                                        </div>
                                                    </a>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div><!--end card-body-->
                                </div><!--end card-->

                            </div><!--end col-->

                            <div class="col-lg-9">
                                <div class="">
                                    <div class="tab-content" id="files-tabContent">
                                        <?php if (session()->getFlashdata('pesan')) : ?>
                                            <?= session()->getFlashdata('pesan') ?>
                                        <?php endif ?>

                                        <?php foreach ($subkriteriaData as $index => $data) : ?>
                                            <div class="tab-pane fade <?= $index === 0 ? 'active show' : '' ?>" id="<?= $data['kriteria']['kode_kriteria'] ?>">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card shadow">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <h4 class="mt-0 header-title"><?= $data['kriteria']['kriteria'] ?></h4>
                                                                    <!-- Tombol Tambah -->
                                                                    <a href="#" class="btn btn-primary btn-round waves-effect waves-light" data-toggle="modal" data-target="#add<?= $data['kriteria']['id_kriteria'] ?>">
                                                                        <i class="mdi mdi-plus-circle-outline"></i> Add
                                                                    </a>
                                                                </div>

                                                                <div class="table-responsive">
                                                                    <table class="table mb-0 table-centered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Nama Sub Kriteria</th>
                                                                                <th>Nilai</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $no = 1; ?>
                                                                            <?php foreach ($data['subkriteria'] as $item) : ?>
                                                                                <tr>
                                                                                    <td><?= $no++ ?></td>
                                                                                    <td><?= $item['sub_kriteria'] ?></td>
                                                                                    <td><?= $item['nilai'] ?></td>
                                                                                    <td>
                                                                                        <!-- Tombol Edit -->
                                                                                        <button type="button" class="btn btn-warning btn-round waves-effect waves-light edit-btn" data-toggle="modal" data-target="#edit<?= $item['id_sub_kriteria'] ?>">
                                                                                            <i class="mdi mdi-pencil"></i> Edit
                                                                                        </button>
                                                                                        <form action="/sub-kriteria/hapus/<?= $item['id_sub_kriteria'] ?>" method="post" class="d-inline">
                                                                                            <?= csrf_field() ?>
                                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                                            <button type="submit" class="btn btn-danger btn-round waves-effect waves-light" onclick="return confirm('Apakah yakin?')"><i class="mdi mdi-delete"></i> Delete</button>
                                                                                        </form>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        </tbody>
                                                                    </table><!--end /table-->
                                                                </div><!--end /tableresponsive-->
                                                            </div><!--end card-body-->
                                                        </div><!--end card-->
                                                    </div> <!-- end col -->
                                                </div>
                                            </div><!--end tab-pane-->

                                            <!-- modal add -->
                                            <div class="modal fade" id="add<?= $data['kriteria']['id_kriteria'] ?>" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addModalLabel">Tambah Sub Kriteria</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url('/sub-kriteria/simpan/') . $data['kriteria']['id_kriteria'] ?>" method="post">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="id_bahan_baku" value="<?= $id_bahan_baku ?>">
                                                                <input type="hidden" name="id_kriteria" value="<?= $data['kriteria']['id_kriteria'] ?>"> <!-- Default kriteria pertama -->
                                                                <div class="form-group">
                                                                    <label for="sub_kriteria">Nama Sub Kriteria</label>
                                                                    <input type="text" class="form-control" id="sub_kriteria" name="sub_kriteria" required placeholder="Masukan sub kriteria">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nilai">Nilai</label>
                                                                    <input type="number" class="form-control" id="nilai" name="nilai" required placeholder="Masukan nilai">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit -->
                                            <?php foreach ($subkriteria as $sub) : ?>
                                                <div class="modal fade" id="edit<?= $sub['id_sub_kriteria'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel">Edit Sub Kriteria</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/sub-kriteria/update/<?= $sub['id_sub_kriteria'] ?>" method="post">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id_sub_kriteria" value="<?= $sub['id_sub_kriteria'] ?>">
                                                                    <input type="hidden" name="id_kriteria" value="<?= $sub['id_kriteria'] ?>">
                                                                    <div class="form-group">
                                                                        <label for="edit_sub_kriteria">Nama Sub Kriteria</label>
                                                                        <input type="text" class="form-control" value="<?= $sub['sub_kriteria'] ?>" name="sub_kriteria" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit_nilai">Nilai</label>
                                                                        <input type="number" class="form-control" value="<?= $sub['nilai'] ?>" name="nilai" required>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>

                                        <?php endforeach ?>
                                    </div> <!--end tab-content-->
                                </div><!--end card-body-->
                            </div><!--end col-->
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning" role="alert">
                            Data kriteria tidak ada!
                        </div>
                    <?php endif ?>
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        Silakan pilih bahan baku terlebih dahulu untuk menampilkan data sub kriteria bahan baku!
                    </div>
                <?php endif ?>

            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->
</div>

<script>
    document.getElementById('id_bahan_baku').onchange = changeSupplier;

    function changeSupplier() {
        var id_bahan_baku = document.getElementById('id_bahan_baku').value;
        if (id_bahan_baku != '#') {
            window.location.href = `<?= base_url() ?>sub-kriteria/${id_bahan_baku}`;
        }
    }
</script>

<?= $this->endSection('content') ?>