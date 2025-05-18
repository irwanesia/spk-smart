<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    protected $user;
    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->user = new UsersModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('login', $data);
    }

    public function register()
    {
        $data = [
            'title' => 'Registrasi',
        ];
        return view('register', $data);
    }

    public function auth()
    {
        // Validasi input
        $validationRules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'email harus diisi',
                    'valid_email' => 'Format email tidak valid'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]|max_length[20]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 4 karakter'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $data = $this->request->getPost();

        // Ambil data user dari database
        $user = $this->user->where('email', $data['email'])->first();

        if (!$user) {
            log_message('warning', 'Percobaan login dengan email tidak terdaftar: ' . $data['email']);
            $this->session->setFlashdata('error', 'email atau password salah');
            return redirect()->to('/login')->withInput();
        }

        // Verifikasi password
        if (!password_verify($data['password'], $user['password'])) {
            // if (($data['password'] != $user['password'])) {
            log_message('warning', 'Percobaan login dengan password salah untuk user: ' . $user['email']);
            $this->session->setFlashdata('error', 'email atau password salah');
            return redirect()->to('/login')->withInput();
        }

        // Buat session data
        $sessionData = [
            'id_user' => $user['id_user'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true, // Gunakan boolean untuk status login
            'last_login' => time()
        ];

        // Set session
        $this->session->set($sessionData);

        // Redirect berdasarkan role
        $redirectUrl = match ($user['role']) {
            'admin' => '/dashboard',
            'sales' => '/dashboard',
            'pelanggan' => '/pelanggan/dashboard',
            default => '/dashboard'
        };

        return redirect()->to($redirectUrl);
    }

    // protected function getRedirectUrlBasedOnRole($role)
    // {
    //     switch ($role) {
    //         case 'admin':
    //             return '/dashboard';
    //         case 'pelanggan':
    //             return '/';
    //         case 'sales':
    //             return '/dashboard';
    //         default:
    //             return '/dashboard';
    //     }
    // }

    public function logout()
    {
        // Catat aktivitas logout
        if ($this->session->has('email')) {
            log_message('info', 'User ' . $this->session->get('email') . ' melakukan logout');
        }

        // Hapus session
        $this->session->destroy();

        // Set pesan logout
        $this->session->setFlashdata('success', 'Anda telah berhasil logout');

        return redirect()->to('/login');
    }
}
