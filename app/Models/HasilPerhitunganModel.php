<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilPerhitunganModel extends Model
{
    protected $table      = 'hasil_perhitungan';
    protected $primaryKey = 'id_hasil';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_user', 'id_mobil', 'skor', 'ranking'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // tampilkan hasil rangking
    public function getHasilPerhitungan($id)
    {
        return $this->select('hasil_perhitungan.*, u.*, m.nama_mobil, u.nama AS nama_sales, u.alamat')
            ->join('users u', 'u.id_user = hasil_perhitungan.id_user')
            ->join('mobil m', 'm.id_mobil = hasil_perhitungan.id_mobil')
            ->where('hasil_perhitungan.id_user', $id)
            ->orderBy('hasil_perhitungan.ranking', 'ASC')
            ->findAll();
    }

    public function getRiwayatHasil($id_user = null)
    {
        $builder = $this->db->table('hasil_perhitungan h');
        $builder->select('
        u.id_user, 
        u.nama,
        u.email,
        DATE(h.created_at) as tanggal,
        COUNT(DISTINCT h.id_mobil) as jumlah_mobil,
        MAX(h.created_at) as waktu_terakhir')
            ->join('users u', 'u.id_user = h.id_user');

        if ($id_user) {
            $builder->where('h.id_user', $id_user);
        }

        return $builder->groupBy('u.id_user, u.nama, u.email, DATE(h.created_at)')
            ->orderBy('waktu_terakhir', 'DESC')
            ->get()
            ->getResultArray();
    }
}
