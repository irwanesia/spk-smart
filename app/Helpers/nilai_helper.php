<?php

if (!function_exists('getPenilaian')) {
    function getPenilaian($idBahanBaku, $id_supplier, $id_kriteria)
    {
        // Panggil model Penilaian
        $penilaianModel = model('App\Models\PenilaianModel');

        // Ambil nilai dari fungsi findPenilaian di dalam model
        return $penilaianModel->findPenilaian($idBahanBaku, $id_supplier, $id_kriteria);
    }
}
