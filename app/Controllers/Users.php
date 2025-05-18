<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        if (session()->get('role') === 'sales') {
            $title = 'Pelanggan';
        } else {
            $title = 'Users';
        }

        $data = [
            'title' => $title,
            'users' => $this->users->findAll(),
            'pelanggan' => $this->users->getPelangganBySales($_SESSION['id_user'])
        ];
        return view('Users/index', $data);
    }

    public function tambah()
    {
        // session dipindahkan ke basecontroller
        $data = [
            'title' => 'Form Register User',
            'validation' => \Config\Services::validation()
        ];
        return view('Users/tambah', $data);
    }


    public function simpan()
    {
        $validation = \Config\Services::validation();

        // Validasi input
        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi!',
                    'valid_email' => 'Format email tidak valid!',
                    'is_unique' => 'Email sudah terdaftar!'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Password harus diisi!',
                    'min_length' => 'Password minimal 4 karakter!',
                    'regex_match' => 'Password harus mengandung huruf besar, kecil, dan angka!'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi!',
                    'matches' => 'Konfirmasi password tidak cocok!'
                ]
            ],
            'nama' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama harus diisi!',
                    'min_length' => 'Nama minimal 3 karakter!',
                    'max_length' => 'Nama maksimal 100 karakter!'
                ]
            ],
            'alamat' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Alamat harus diisi!',
                    'min_length' => 'Alamat minimal 10 karakter!'
                ]
            ],
            'role' => [
                'rules' => 'required|in_list[admin,pelanggan,sales]',
                'errors' => [
                    'required' => 'Role harus dipilih!',
                    'in_list' => 'Role tidak valid!'
                ]
            ]
        ];

        if ($this->request->getVar('role') == 'pelanggan') {
            $slug = '/register';
            $slug2 = '/login';
        } else {
            $slug = '/users';
            $slug2 = '/users';
        }
        // Jika role admin, tidak perlu validasi password


        if (!$this->validate($rules)) {
            // Jika error validasi:
            return redirect()->to($slug)
                ->withInput()
                ->with('errors', $validation->getErrors()) // Menggunakan 'errors' (bisa diakses via session('errors'))
                ->with('show_modal', 'add');
        }

        try {
            // Enkripsi password
            $hashedPassword = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);

            // Data untuk disimpan
            $userData = [
                'nama' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'password' => $hashedPassword,
                'alamat' => $this->request->getVar('alamat'),
                'role' => $this->request->getVar('role'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Simpan ke database
            $this->users->insert($userData);

            // Log aktivitas
            log_message('info', 'User baru ditambahkan: ' . $userData['email']);

            // Pesan sukses
            session()->setFlashdata('success', 'User berhasil ditambahkan!');
            return redirect()->to($slug2);
        } catch (\Exception $e) {
            // Log error
            log_message('error', 'Gagal menambahkan user: ' . $e->getMessage());

            // Pesan error
            session()->setFlashdata('error', 'Gagal menambahkan user. Silakan coba lagi.');

            return redirect()->back()->withInput();
        }
    }

    public function profile()
    {
        $data = [
            'title' => 'Profile User',
            'validation' => \Config\Services::validation()
        ];
        return view('/users/profile-user', $data);
    }

    public function update($id)
    {
        // Validasi input (termasuk rule unique untuk email)
        $validationRules = [
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama harus diisi']
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[users.email,id_user,{$id}]",
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => ['min_length' => 'Password minimal 6 karakter']
            ],
            'role' => [
                'rules' => 'required|in_list[admin,pelanggan,sales]',
                'errors' => [
                    'required' => 'Role harus dipilih',
                    'in_list' => 'Role tidak valid'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'edit')
                ->with('edit_id', $id); // Penting untuk auto-open modal edit
        }

        try {
            // Ambil data dari form
            $data = [
                'nama' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'alamat' => $this->request->getVar('alamat'),
                'role' => $this->request->getVar('role'),
                'created_at' => date('Y-m-d H:i:s') // Hanya update updated_at
            ];

            // Hash password baru jika diisi
            $password = $this->request->getVar('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->users->update($id, $data);

            session()->setFlashdata('success', 'User berhasil diperbarui!');
            return redirect()->to('/users');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal memperbarui user. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        $this->users->delete($id);

        // pesan berhasil didelete
        session()->setFlashdata('success', 'User berhasil dihapus!');

        return redirect()->to('/users');
    }
}
