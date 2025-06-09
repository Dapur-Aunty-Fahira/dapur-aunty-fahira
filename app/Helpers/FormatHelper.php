<?php

if (!function_exists('format_rupiah')) {
    /**
     * Format angka jadi Rupiah.
     * Jika desimal nol, tampilkan tanpa koma/desimal.
     *
     * @param float|int|string $value
     * @return string
     */
    function format_rupiah($value)
    {
        $value = floatval($value);
        if (floor($value) == $value) {
            return number_format($value, 0, ',', '.');
        }
        return number_format($value, 2, ',', '.');
    }
}
