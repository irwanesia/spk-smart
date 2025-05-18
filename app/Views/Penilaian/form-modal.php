<?php foreach ($mobil as $mbl) : ?>
    <!-- form modal input -->
    <div class="modal fade edit-modal" id="addModal<?= $mbl['id_mobil'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian untuk <?= $mbl['nama_mobil'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/penilaian/simpan/<?= $mbl['id_mobil'] ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_mobil" value="<?= $mbl['id_mobil'] ?>">
                            <?php foreach ($kriteriaData as $data) : ?>
                                <input type="hidden" name="id_kriteria[<?= $data['kriteria']['id_kriteria'] ?>]" value="<?= $data['kriteria']['id_kriteria'] ?>">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>(<?= $data['kriteria']['kode_kriteria'] ?>) <?= $data['kriteria']['nama_kriteria'] ?></label>

                                        <?php if ($data['kriteria']['pilih_inputan'] != 'subkriteria') : ?>
                                            <!-- Input Nilai Langsung -->
                                            <input
                                                type="number"
                                                name="nilai[<?= $data['kriteria']['id_kriteria'] ?>]"
                                                class="form-control"
                                                placeholder="Masukkan nilai"
                                                required>
                                        <?php else : ?>
                                            <!-- Pilihan Subkriteria -->
                                            <select
                                                name="id_subkriteria[<?= $data['kriteria']['id_kriteria'] ?>]"
                                                class="form-control <?= session('errors.id_subkriteria.' . $data['kriteria']['id_kriteria']) ? 'is-invalid' : '' ?>"
                                                required>
                                                <option value="" selected disabled>-- Pilih --</option>
                                                <?php foreach ($data['subkriteria'] as $sub) : ?>
                                                    <option value="<?= $sub['id_subkriteria'] ?>">
                                                        <?= $sub['nama_subkriteria'] ?> (Nilai: <?= $sub['nilai'] ?>)
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <?php if (session('errors.id_subkriteria.' . $data['kriteria']['id_kriteria'])) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.id_subkriteria.' . $data['kriteria']['id_kriteria']) ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
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
    <?php
    // Ambil data penilaian yang sudah ada untuk mobil ini
    $penilaianExist = array_column(array_filter($dataPenilaian, fn($item) => $item['id_mobil'] == $mbl['id_mobil']), null, 'id_kriteria');
    // dd($penilaianExist); // Debugging: Cek data yang ada
    ?>

    <div class="modal fade edit-modal" id="editModal<?= $mbl['id_mobil'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penilaian <?= $mbl['nama_mobil'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/penilaian/update/<?= $mbl['id_mobil'] ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <?php foreach ($kriteriaData as $data) :
                            $id_kriteria = $data['kriteria']['id_kriteria'];
                            $existData = $penilaianExist[$id_kriteria] ?? null;
                        ?>
                            <input type="hidden" name="id_kriteria[<?= $id_kriteria ?>]" value="<?= $id_kriteria ?>">
                            <div class="mb-3">
                                <label class="form-label">
                                    (<?= $data['kriteria']['kode_kriteria'] ?>) <?= $data['kriteria']['nama_kriteria'] ?>
                                </label>

                                <?php if ($data['kriteria']['pilih_inputan'] == 'subkriteria') : ?>
                                    <select name="id_subkriteria[<?= $id_kriteria ?>]" class="form-control" required>
                                        <option value="" disabled>-- Pilih --</option>
                                        <?php foreach ($data['subkriteria'] as $sub) : ?>
                                            <option value="<?= $sub['id_subkriteria'] ?>"
                                                <?= (!empty($existData) && $existData['id_subkriteria'] == $sub['id_subkriteria']) ? 'selected' : '' ?>>
                                                <?= $sub['nama_subkriteria'] ?> (Nilai: <?= $sub['nilai'] ?>)
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                <?php else : ?>
                                    <input type="number" name="nilai[<?= $id_kriteria ?>]" class="form-control" placeholder="Masukkan nilai" value="<?= $existData['nilai'] ?? '' ?>" required>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
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