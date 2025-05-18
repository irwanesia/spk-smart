<?php

if (!function_exists('rupiah')) {
    /**
     * Format angka menjadi format rupiah.
     *
     * @param int|float $angka Angka yang akan diformat.
     * @return string Angka yang sudah diformat dalam bentuk rupiah.
     */
    function rupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
