<?php

namespace App\Controllers;

use App\Models\PerhitunganTempModel;

class PerhitunganTemp extends BaseController
{
    protected $perhitunganTemp;

    public function __construct()
    {
        $this->perhitunganTemp = new PerhitunganTempModel();
    }

    public function simpan()
    {
        $id_user = $this->request->getPost('id_user');
        $id_mobil = $this->request->getPost('id_mobil');

        // Cek apakah data sudah ada
        $exists = $this->perhitunganTemp->where(['id_user' => $id_user, 'id_mobil' => $id_mobil])
            ->get()
            ->getRow();
        if (!$exists) {
            $this->perhitunganTemp->insert([
                'id_user' => $id_user,
                'id_mobil' => $id_mobil,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'exists']);
    }
}
