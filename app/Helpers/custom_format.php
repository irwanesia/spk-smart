<?php

if (!function_exists('custom_format')) {
    /**
     * Format angka sesuai kebutuhan:
     * - Jika angka bulat (1, 2, 3, dst.), tampilkan tanpa desimal.
     * - Jika angka desimal (0.25, 1.3333, dst.), tampilkan maksimal 4 angka di belakang koma.
     *
     * @param float|int $angka Angka yang akan diformat.
     * @return string Angka yang sudah diformat.
     */
    function custom_format($angka)
    {
        // Cek apakah angka adalah bilangan bulat
        if ($angka == (int) $angka) {
            return (string) $angka; // Tampilkan tanpa desimal
        } else {
            // Batasi angka di belakang koma hingga 4 digit
            return number_format($angka, 4, '.', '');
        }
    }
}
