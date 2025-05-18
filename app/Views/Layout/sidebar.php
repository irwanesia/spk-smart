<!-- Left Sidenav -->
<div class="left-sidenav">
    <ul class="metismenu left-sidenav-menu">
        <?php
        $current_url = uri_string(); // Menggunakan uri_string() dari CodeIgniter
        $role = $_SESSION['role'] != 'admin' ? 'd-none' : '';

        // Fungsi untuk menentukan menu aktif
        function is_active($segment, $current)
        {
            return $current === $segment ? 'active' : '';
        }
        ?>

        <?php if (session()->get('role') === 'admin') : ?>
            <!-- Menu Dashboard -->
            <li class="nav-item <?= $role ?>">
                <a class="nav-link <?= is_active('', $current_url) ?>" href="<?= site_url('/dashboard') ?>">
                    <i class="mdi mdi-view-dashboard"></i><span>Dashboard</span>
                </a>
            </li>

            <!-- Menu Kriteria -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('kriteria', $current_url) ?>" href="<?= site_url('kriteria') ?>">
                    <i class="ti-files"></i><span>Kelola Kriteria</span>
                </a>
            </li>

            <!-- Menu Mobil -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('mobil', $current_url) ?>" href="<?= site_url('mobil') ?>">
                    <i class="mdi mdi-clipboard-text"></i><span>Kelola Mobil</span>
                </a>
            </li>

            <!-- Menu Penilaian -->
            <li class="nav-item <?= $role ?>">
                <a class="nav-link <?= is_active('penilaian', $current_url) ?>" href="<?= site_url('penilaian') ?>">
                    <i class="mdi mdi-pencil-box"></i><span>Penilaian</span>
                </a>
            </li>

            <!-- Menu Pengguna -->
            <li class="nav-item <?= $role ?>">
                <a class="nav-link <?= is_active('users', $current_url) ?>" href="<?= site_url('users') ?>">
                    <i class="mdi mdi-account-multiple"></i><span>Kelola Pengguna</span>
                </a>
            </li>

            <!-- Menu Riwayat -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('pembelian', $current_url) ?>" href="<?= site_url('pembelian') ?>">
                    <i class="mdi mdi-file-find"></i><span>Data Pembelian</span>
                </a>
            </li>

            <!-- Menu Perhitungan -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('perhitungan', $current_url) ?>" href="<?= site_url('perhitungan') ?>">
                    <i class="mdi mdi-memory"></i><span>Perhitungan SMART</span>
                </a>
            </li>

            <!-- Menu Laporan -->
            <li>
                <a href="javascript: void(0);"><i class="ti-layers-alt"></i><span>Laporan</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="/laporan/hasil-ranking"><i class="ti-control-record"></i>Hasil Perangkingan</a></li>
                    <li class="nav-item"><a class="nav-link" href="/laporan/detail-penilaian"><i class="ti-control-record"></i>Detail Penilaian</a></li>
                    <li class="nav-item"><a class="nav-link" href="/laporan/riwayat-penilaian"><i class="ti-control-record"></i>Riwayat Penilaian</a></li>
                </ul>
            </li>
        <?php elseif (session()->get('role') === 'sales') : ?>
            <!-- tampilkan menu khusus sales -->
            <!-- Menu Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('', $current_url) ?>" href="<?= site_url('/dashboard') ?>">
                    <i class="mdi mdi-view-dashboard"></i><span>Dashboard</span>
                </a>
            </li>

            <!-- Menu Penilaian -->
            <li class="nav-item d-none">
                <a class="nav-link <?= is_active('penilaian', $current_url) ?>" href="<?= site_url('penilaian') ?>">
                    <i class="mdi mdi-pencil-box"></i><span>Penilaian</span>
                </a>
            </li>

            <!-- Menu Pengguna -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('users', $current_url) ?>" href="<?= site_url('users') ?>">
                    <i class="mdi mdi-account-multiple"></i><span>Data Pelanggan</span>
                </a>
            </li>

            <!-- Menu riwayat -->
            <li class="nav-item d-none">
                <a class="nav-link <?= is_active('riwayat', $current_url) ?>" href="<?= site_url('riwayat') ?>">
                    <i class="ti-files"></i><span>Riwayat Penilaian</span>
                </a>
            </li>

            <!-- Menu laporan -->
            <li class="nav-item">
                <a class="nav-link <?= is_active('laporan', $current_url) ?>" href="<?= site_url('laporan/sales') ?>">
                    <i class="mdi mdi-clipboard-text"></i><span>Laporan Saya</span>
                </a>
            </li>


        <?php endif; ?>
    </ul>

</div>
<!-- end left-sidenav-->