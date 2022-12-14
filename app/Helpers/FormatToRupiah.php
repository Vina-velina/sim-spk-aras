<?php

namespace App\Helpers;

/**
 * Created by Deyan Ardi 2022.
 * Format To Rupiah
 */
class FormatToRupiah
{
    public static function getRupiah($data)
    {
        $format_to_indo = number_format($data, 0, ',', '.');
        $merge = 'Rp '.$format_to_indo.'';

        return $merge;
    }
}
