<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table      = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_mobil', 'id_kriteria', 'id_subkriteria', 'nilai'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function findAllPenilaian()
    {
        $builder = $this->builder();
        $builder->select('penilaian.*, m.nama_mobil, m.id_mobil');
        $builder->join('mobil m', 'm.id_mobil = penilaian.id_mobil');
        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan semua baris hasil sebagai array
    }

    public function findPenilaianOld($id)
    {
        $builder = $this->builder();
        $builder->select('*');
        $builder->join('mobil', 'penilaian.id_mobil = mobil.id_mobil');

        // menambahkan kondisi jika $id disediakan
        if ($id == null) {
            // Menambahkan filter berdasarkan ID
            $builder->where('penilaian.id_penilaian', $id);
            $query = $builder->get();
            return $query->getRowArray(); // Mengembalikan satu baris hasil sebagai array
        }

        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan semua baris hasil sebagai array
    }

    public function findPenilaian($idBahanBaku, $id_mobil, $id_kriteria)
    {
        return $this->db->table('penilaian')
            ->select("id_penilaian, id_bahan_baku, id_mobil, id_kriteria, 
                 COALESCE(nilai, (SELECT nilai FROM sub_kriteria WHERE id_sub_kriteria = penilaian.id_sub_kriteria)) AS nilai_akhir")
            ->where('id_bahan_baku', $idBahanBaku)
            ->where('id_mobil', $id_mobil)
            ->where('id_kriteria', $id_kriteria)
            ->get()
            ->getResultArray(); // Kembalikan array hasil query
    }


    // Dalam model mobilModel atau model yang relevan
    public function getPenilaianBymobilAndKriteria($idmobil, $idKriteria)
    {
        $builder = $this->db->table('penilaian');
        $builder->select('penilaian.nilai, sub_kriteria.nilai as nilai_sub_kriteria');
        $builder->join('sub_kriteria', 'penilaian.nilai = sub_kriteria.id_sub_kriteria', 'left'); // Sesuaikan dengan kondisi join Anda
        $builder->where('penilaian.id_mobil', $idmobil);
        $builder->where('penilaian.id_kriteria', $idKriteria);
        $query = $builder->get();

        return $query->getRowArray(); // Untuk single result atau getResultArray() untuk multiple results
    }

    public function getNilaiMobil($id_mobil)
    {
        return $this->where('id_mobil', $id_mobil)
            ->join('kriteria', 'kriteria.id_kriteria = penilaian.id_kriteria')
            ->select('penilaian.*, kriteria.nama_kriteria, kriteria.tipe, kriteria.bobot, kriteria.pilih_inputan')
            ->findAll();
    }

    public function getmobilPenilaian($idBahanBaku, $id_mobil)
    {
        return $this->db->table('penilaian')
            ->select('id_mobil')
            ->where('id_bahan_baku', $idBahanBaku)
            ->where('id_mobil', $id_mobil)
            ->groupBy('id_mobil')
            ->get()
            ->getResultArray();
    }

    public function getAllPenilaian()
    {
        // Mengambil semua data penilaian dengan nilai akhir yang diperoleh dari penilaian atau sub_kriteria
        $builder = $this->db->table('penilaian p');
        $builder->select("
            p.id_penilaian,
            p.id_mobil,
            m.nama_mobil,
            p.id_kriteria,
            p.id_subkriteria,
            COALESCE(p.nilai, s.nilai) AS nilai_akhir,
        ");
        $builder->join('mobil m', 'p.id_mobil = m.id_mobil');
        $builder->join('sub_kriteria s', 'p.id_subkriteria = s.id_subkriteria', 'left');
        $builder->orderBy('p.id_mobil', 'ASC');
        $builder->orderBy('p.id_kriteria', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPenilaianByMobil($carIds)
    {
        $builder = $this->db->table('penilaian p');
        $builder->select("
                        p.id_penilaian,
                        p.id_mobil,
                        m.nama_mobil,
                        p.id_kriteria,
                        k.nama_kriteria,
                        k.tipe,
                        k.bobot,
                        p.id_subkriteria,
                        COALESCE(p.nilai, s.nilai) AS nilai_akhir
                    ");
        $builder->join('mobil m', 'p.id_mobil = m.id_mobil');
        $builder->join('kriteria k', 'p.id_kriteria = k.id_kriteria');
        $builder->join('sub_kriteria s', 'p.id_subkriteria = s.id_subkriteria', 'left');

        // Tambahkan filter untuk mobil yang dipilih
        $builder->whereIn('p.id_mobil', $carIds);

        $builder->orderBy('p.id_mobil', 'ASC');
        $builder->orderBy('p.id_kriteria', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getNilaiMaxMin()
    {
        $builder = $this->db->table('penilaian p');
        $builder->select('p.id_kriteria, MAX(COALESCE(p.nilai, s.nilai)) as nilaiMax, MIN(COALESCE(p.nilai, s.nilai)) as nilaiMin');
        $builder->join('sub_kriteria s', 'p.id_subkriteria = s.id_subkriteria', 'left');
        $builder->groupBy('p.id_kriteria');
        $builder->orderBy('p.id_kriteria', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getNilaiMaxMinByMobil($carIds)
    {
        $builder = $this->db->table('penilaian p');
        $builder->select('p.id_kriteria, 
                    MAX(COALESCE(p.nilai, s.nilai)) as nilaiMax, 
                    MIN(COALESCE(p.nilai, s.nilai)) as nilaiMin');
        $builder->join('sub_kriteria s', 'p.id_subkriteria = s.id_subkriteria', 'left');

        // Tambahkan filter untuk mobil yang dipilih
        $builder->whereIn('p.id_mobil', $carIds);

        $builder->groupBy('p.id_kriteria');
        $builder->orderBy('p.id_kriteria', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDistinctKriteria()
    {
        $builder = $this->db->table('penilaian p');
        $builder->select('p.id_kriteria, p.id_mobil, k.*');
        $builder->join('kriteria k', 'p.id_kriteria = k.id_kriteria');
        $builder->groupBy('p.id_kriteria');
        $builder->orderBy('p.id_kriteria', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getKriteriaByMobil($carIds)
    {
        $builder = $this->db->table('penilaian p');
        $builder->select('p.id_kriteria, k.*');
        $builder->join('kriteria k', 'p.id_kriteria = k.id_kriteria');

        // Tambahkan filter untuk mobil yang dipilih
        $builder->whereIn('p.id_mobil', $carIds);

        $builder->groupBy('p.id_kriteria');
        $builder->orderBy('p.id_kriteria', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    // Hitung jumlah mobil yang sudah dinilai (distinct id_mobil)
    public function getJumlahMobilDinilai()
    {
        return $this->db->table('penilaian')
            ->select('id_mobil')
            ->groupBy('id_mobil')
            ->get()
            ->getNumRows();
    }

    public function getMobilId(array $mobilIdList)
    {
        // Validasi input
        if (empty($mobilIdList)) {
            return [];
        }

        // Pastikan semua nilai adalah integer
        $mobilIdList = array_map('intval', $mobilIdList);
        $mobilIdList = array_unique($mobilIdList); // Hindari duplikasi

        return $this->db->table('penilaian')
            ->whereIn('id_mobil', $mobilIdList)
            ->get()
            ->getResultArray(); // atau ->getResult() untuk object
    }
}
