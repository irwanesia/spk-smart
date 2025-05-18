<?php

namespace App\Controllers;

use App\Models\RankingSupplierModel;
use App\Models\SupplierBahanBakuModel;
use App\Models\BahanBakuModel;
use App\Models\SupplierModel;

class Ranking extends BaseController
{
    protected $rankingSupplier;
    protected $supplier;
    protected $supplierBahanBaku;
    protected $bahanBaku;

    public function __construct()
    {
        $this->rankingSupplier = new RankingSupplierModel();
        $this->supplier = new SupplierModel();
        $this->supplierBahanBaku = new SupplierBahanBakuModel();
        $this->bahanBaku = new BahanBakuModel();
    }

    public function save($id_bahan_baku)
    {
        // $id_bahan_baku = $this->request->getPost('id_bahan_baku');
        $id_suppliers = $this->request->getPost('id_supplier');
        $peringkats = $this->request->getPost('peringkat');
        $scores = $this->request->getPost('score');

        if ($id_suppliers && $peringkats && $scores) {
            foreach ($id_suppliers as $key => $id_supplier) {
                $this->rankingSupplier->save([
                    'id_bahan_baku' => $id_bahan_baku,
                    'id_supplier' => $id_supplier,
                    'peringkat' => $peringkats[$key],
                    'score' => $scores[$key],
                ]);
            }
            // pesan data berhasil ditambah
            $isipesan = '<script> alert("Hasil perhitungan berhasil disimpan!") </script>';
            session()->setFlashdata('pesan', $isipesan);
            return redirect()->to('/perhitungan/bahan-baku/' . $id_bahan_baku);
        } else {
            $isipesan = '<script> alert("Hasil perhitungan gagal disimpan!") </script>';
            session()->setFlashdata('pesan', $isipesan);
            return redirect()->to('/perhitungan/bahan-baku/' . $id_bahan_baku);
        }
    }
}
