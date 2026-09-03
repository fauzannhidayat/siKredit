<?php
namespace App\Repository;
use App\Models\Pengajuan;
use App\Repository\Contracts\PengajuanRepoInterface;

class PengajuanRepository implements PengajuanRepoInterface
{
    public function getAllPengajuan(){
        return Pengajuan::with('customer')->get();
    }

    public function createPengajuan(array $data){
        // dd($data);
        return Pengajuan::create($data);
    }

    public function getPengajuanById(Pengajuan $pengajuan){
        return $pengajuan->load('customer');
    }

    public function updatePengajuan(Pengajuan $pengajuan, array $data){
        $pengajuan->update($data);

        return $pengajuan->refresh();
    }

    public function updateStatusPengajuan(Pengajuan $pengajuan, string $status){
        $pengajuan->update([
            'status' => $status,
            'tanggal_persetujuan' => $status === 'setuju' ? now()->toDateString() : null,
        ]);

        return $pengajuan->refresh();
    }
    public function deletePengajuan(Pengajuan $pengajuan){ 
        return $pengajuan->delete();
    }

    public function getPengajuanByCustomerId(int $customerId)
    {
        return Pengajuan::where('customer_id', $customerId)->get();
    }


}
