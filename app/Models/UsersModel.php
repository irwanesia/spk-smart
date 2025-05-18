<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id_user';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['nama', 'email', 'password', 'alamat', 'role'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getUserByUsername($username)
    {
        return $this->where(['username' => $username])->first();
    }

    // data pelanggan by sales
    public function getPelangganBySales($id_sales)
    {
        $builder = $this->db->table('users u');
        $builder->select('u.*, p.no_telp, p.tanggal_pembelian');
        $builder->join('pembelian p', 'u.id_user = p.id_user', 'left');
        $builder->where('p.id_sales', $id_sales);
        $builder->groupBy('u.nama');
        $builder->orderBy('u.nama', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }
}
