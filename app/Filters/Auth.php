<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            session()->set('redirect_url', current_url());
            return redirect()->to('/login');
        }

        // Jika ada parameter role (arguments tidak null)
        if (!empty($arguments)) {
            $userRole = session()->get('role');

            // $arguments sudah berupa array, tidak perlu explode
            if (!in_array($userRole, $arguments)) {
                // Redirect ke halaman default sesuai role
                $redirectUrl = match ($userRole) {
                    'pelanggan' => '/pelanggan/dashboard',
                    'admin' => '/admin/dashboard',
                    'sales' => '/sales/dashboard',
                    default => '/'
                };

                return redirect()->to($redirectUrl)
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini');
            }
        }

        // Jika semua pengecekan passed
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah response
    }
}
