<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// =============================================
// PUBLIC ROUTES (bisa diakses tanpa login)
// =============================================

// Halaman Utama & Fitur Publik
$routes->get('/', 'Beranda::index');
$routes->get('bandingkan', 'Perbandingan::index');
$routes->get('bandingkan/proses', 'Perbandingan::proses');
$routes->get('proses-perbandingan', 'Perbandingan::proses_perbandingan');
$routes->get('proses-perbandingan/(:any)', 'Perbandingan::proses_perbandingan/$1');
$routes->get('riwayat-pembelian', 'RiwayatPembelianMobil::index');
$routes->get('uploads/(:segment)', 'ImageController::show/$1');

// Autentikasi
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::auth');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('reset-password', 'ResetPassword::index');
$routes->get('logout', 'Auth::logout');

// =============================================
// PROTECTED ROUTES (perlu login)
// =============================================
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard berdasarkan role
    $routes->get('dashboard', 'Dashboard::index'); // Default dashboard

    // Role-specific dashboards
    // $routes->get('admin/dashboard', 'Dashboard::admin', ['filter' => 'auth:admin']);
    // $routes->get('sales/dashboard', 'Dashboard::sales', ['filter' => 'auth:sales']);
    $routes->get('pelanggan/dashboard', 'Beranda::index', ['filter' => 'auth:pelanggan']);


    // User Management
    $routes->group('users', function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('profile', 'Users::profile');
        $routes->match(['get', 'post'], 'simpan', 'Users::simpan');
        $routes->get('tambah', 'Users::tambah');
        $routes->get('edit/(:num)', 'Users::edit/$1');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->delete('hapus/(:num)', 'Users::delete/$1');
    });

    // Data Master

    // Kriteria
    $routes->group('kriteria', function ($routes) {
        $routes->get('/', 'Kriteria::index');
        $routes->match(['get', 'post'], 'simpan', 'Kriteria::simpan');
        $routes->get('tambah', 'Kriteria::tambah');
        $routes->get('edit/(:num)', 'Kriteria::edit/$1');
        $routes->post('update/(:num)', 'Kriteria::update/$1');
        $routes->delete('hapus/(:num)', 'Kriteria::delete/$1');
    });

    // Subkriteria
    $routes->group('subkriteria', function ($routes) {
        $routes->post('simpan', 'Subkriteria::simpan');
        $routes->post('simpan/(:num)', 'Subkriteria::simpan/$1');
        $routes->get('edit/(:num)', 'Subkriteria::edit/$1');
        $routes->post('update/(:num)', 'Subkriteria::update/$1');
        $routes->delete('hapus/(:num)', 'Subkriteria::delete/$1');
    });

    // Mobil
    $routes->group('mobil', function ($routes) {
        $routes->get('/', 'Mobil::index');
        $routes->get('periode/(:any)/(:any)', 'Mobil::index/$1/$2');
        $routes->match(['get', 'post'], 'simpan', 'Mobil::simpan');
        $routes->get('tambah', 'Mobil::tambah');
        $routes->get('tambah/periode/(:any)/(:any)', 'Mobil::tambah/$1/$2');
        $routes->get('edit/(:num)', 'Mobil::edit/$1');
        $routes->post('update/(:num)', 'Mobil::update/$1');
        $routes->delete('hapus/(:num)', 'Mobil::delete/$1');
    });

    // Riwayat Pembelian
    $routes->group('riwayat-pembelian', function ($routes) {
        $routes->get('periode/(:any)/(:any)', 'RiwayatPembelianMobil::index/$1/$2');
        $routes->get('tambah', 'RiwayatPembelianMobil::tambah');
        $routes->get('tambah/periode/(:any)/(:any)', 'RiwayatPembelianMobil::tambah/$1/$2');
        $routes->post('simpan', 'RiwayatPembelianMobil::simpan');
        $routes->get('edit/(:num)', 'RiwayatPembelianMobil::edit/$1');
        $routes->post('update/(:num)', 'RiwayatPembelianMobil::update/$1');
        $routes->delete('hapus/(:num)', 'RiwayatPembelianMobil::delete/$1');
    });

    // Pembelian
    $routes->group('pembelian', function ($routes) {
        $routes->get('/', 'PembelianMobil::index');
        $routes->get('periode/(:any)/(:any)', 'PembelianMobil::index/$1/$2');
        $routes->get('tambah', 'PembelianMobil::tambah');
        $routes->get('tambah/periode/(:any)/(:any)', 'PembelianMobil::tambah/$1/$2');
        $routes->post('simpan', 'PembelianMobil::simpan');
        $routes->get('edit/(:num)', 'PembelianMobil::edit/$1');
        $routes->post('update/(:num)', 'PembelianMobil::update/$1');
        $routes->delete('hapus/(:num)', 'PembelianMobil::delete/$1');
    });

    // Penilaian
    $routes->group('penilaian', function ($routes) {
        $routes->get('/', 'Penilaian::index');
        $routes->post('simpan/(:num)', 'Penilaian::simpan/$1');
        $routes->put('update/(:num)', 'Penilaian::update/$1');
        $routes->delete('hapus/(:num)', 'Penilaian::delete/$1');
    });



    // =============================================
    // ROLE-SPECIFIC ROUTES (perlu role tertentu)
    // =============================================

    // Pelanggan Routes
    $routes->group('', ['filter' => 'auth:pelanggan'], function ($routes) {
        $routes->get('pelanggan/dashboard', 'Dashboard::pelanggan');
        // Tambahkan route khusus pelanggan lainnya
    });

    // Sales Routes
    $routes->group('', ['filter' => 'auth:sales'], function ($routes) {
        $routes->get('sales/dashboard', 'Dashboard::sales');
        $routes->get('laporan/sales', 'Sales::index');
        // Tambahkan route khusus sales lainnya
    });

    // Admin Routes
    $routes->group('', ['filter' => 'auth:admin'], function ($routes) {
        // Tambahkan route khusus admin
    });

    // Laporan & Perhitungan
    $routes->group('laporan', function ($routes) {
        $routes->get('hasil-ranking', 'Laporan::index');
        $routes->get('hasil-ranking/(:num)', 'Laporan::index/$1');
        $routes->get('detail-penilaian', 'Laporan::detail_penilaian');
        $routes->get('detail-penilaian/(:num)', 'Laporan::detailPenilaianUser/$1');
        $routes->get('riwayat-penilaian', 'Laporan::riwayat_penilaian');
        $routes->get('riwayat-penilaian/(:num)', 'Laporan::riwayat_penilaian/$1');
        $routes->get('cetak-hasil-ranking/(:num)', 'Laporan::cetak_laporan/$1');
        $routes->get('hapus', 'Laporan::hapus');
    });

    $routes->group('perhitungan', function ($routes) {
        $routes->get('/', 'Perhitungan::index');
        $routes->post('simpan', 'Perhitungan::simpan');
    });
    $routes->post('perhitungan_temp/simpan', 'PerhitunganTemp::simpan');

    $routes->post('ranking/save/(:num)', 'Ranking::save/$1');
});
