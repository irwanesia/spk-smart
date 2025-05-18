<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModel extends Model
{
    protected $table      = 'kriteria';
    protected $primaryKey = 'id_kriteria';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['kode_kriteria', 'nama_kriteria', 'tipe', 'bobot', 'pilih_inputan'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    // membuat kode kriteria auto
    public function generateCode()
    {
        $builder = $this->table('kriteria');
        $builder->selectMax('kode_kriteria', 'kodeMax');
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $kodeMax = $row->kodeMax;

            // Mengambil angka dari kode terakhir (menghapus 'A' dan mengkonversi ke integer)
            $number = intval(substr($kodeMax, 1));

            // Menambahkan 1 ke angka tersebut
            $newNumber = $number + 1;

            // Membentuk kode baru dengan format 'K' diikuti oleh angka baru
            $newKode = 'K' . $newNumber;
        } else {
            // Jika tidak ada data, mulai dari 'K1'
            $newKode = 'K1';
        }

        return $newKode;
    }

    public function getPilihanSubKriteria()
    {
        $builder = $this->db->table('kriteria');
        // Gunakan COUNT(DISTINCT column_name) untuk menghitung jumlah nilai unik
        $builder->select('input_pilihan as pilihan');
        $query = $builder->get();

        return $query->getRow()->pilihan;
    }
}
