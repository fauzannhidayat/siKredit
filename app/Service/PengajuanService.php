<?php

namespace App\Service;

use App\Models\Pengajuan;
use App\Repository\Contracts\CustomerRepoInterface;
use App\Repository\Contracts\PengajuanRepoInterface;
use Illuminate\Support\Facades\DB;

class PengajuanService
{
    protected PengajuanRepoInterface $pengajuanRepository;
    protected CustomerRepoInterface $customerRepository;
    protected HitungTagihanService $hitungTagihanService;

    public function __construct(PengajuanRepoInterface $pengajuanRepository, CustomerRepoInterface $customerRepository, HitungTagihanService $hitungTagihanService)
    {
        $this->pengajuanRepository = $pengajuanRepository;
        $this->customerRepository = $customerRepository;
        $this->hitungTagihanService = $hitungTagihanService;
    }
    public function getAllPengajuan()
    {
        return $this->pengajuanRepository->getAllPengajuan();
    }

    public function createPengajuan(array $data)
    {
        return DB::transaction(function () use ($data) {
            $customer = $this->customerRepository->firstOrCreate(
                [
                    'nama_lengkap' => $data['nama_lengkap'],
                    'pendapatan_per_bulan' => $data['pendapatan_per_bulan'],
                ]
            );

            $tagihanPerBulan = $this->hitungTagihanService->hitungTagihan(
                $data['nominal_pengajuan'],
                $data['tenor']
            );

            $pengajuanData = [
                'customer_id' => $customer->id,
                'pendapatan_per_bulan' => $data['pendapatan_per_bulan'],
                'tipe_pengajuan' => $data['tipe_pengajuan'],
                'nominal_pengajuan' => $data['nominal_pengajuan'],
                'tagihan_per_bulan' => $tagihanPerBulan,
                'tanggal_pengajuan' => now()->format('Y-m-d'),
                'tenor' => $data['tenor'],
                'catatan' => $data['catatan'] ?? null,
            ];

            return $this->pengajuanRepository->createPengajuan($pengajuanData);
        });
    }

    public function getPengajuanById(Pengajuan $pengajuan)
    {
        return $this->pengajuanRepository->getPengajuanById($pengajuan);
    }

    public function updatePengajuan(Pengajuan $pengajuan, array $data)
    {
        return $this->pengajuanRepository->updatePengajuan($pengajuan, $data);
    }

    public function updateStatusPengajuan(Pengajuan $pengajuan, string $status)
    {
        return $this->pengajuanRepository->updateStatusPengajuan($pengajuan, $status);
    }

    public function deletePengajuan(Pengajuan $pengajuan)
    {
        return $this->pengajuanRepository->deletePengajuan($pengajuan);
    }
}
