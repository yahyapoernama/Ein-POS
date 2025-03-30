<?php

namespace App\Utils;

class CurrencyFormatter
{
    public static function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public static function formatDollar($amount)
    {
        return '$' . number_format($amount, 2, '.', ',');
    }
}
