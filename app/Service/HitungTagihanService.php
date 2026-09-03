<?php

namespace App\Service;

class HitungTagihanService
{
    public function hitungTagihan($jumlahPinjaman, $jangkaWaktu)
    {
        

        // Menghitung total tagihan per bulan
        $totalTagihanPerBulan = $jumlahPinjaman / $jangkaWaktu;

        return $totalTagihanPerBulan;
    }
}
