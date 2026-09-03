<?php

namespace App\Repository\Contracts;

use App\Models\Pengajuan;

interface PengajuanRepoInterface
{
    public function getAllPengajuan();
    public function createPengajuan(array $data);
    public function getPengajuanById(Pengajuan $pengajuan);
    public function updatePengajuan(Pengajuan $pengajuan, array $data);
    public function updateStatusPengajuan(Pengajuan $pengajuan, string $status);
    public function deletePengajuan(Pengajuan $pengajuan);
}
