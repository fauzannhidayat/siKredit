<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest;
use App\Http\Requests\UpdatePengajuanRequest;
use App\Models\Pengajuan;
use App\Service\PengajuanService;


class PengajuanController extends Controller
{

    protected PengajuanService $pengajuanService;

    public function __construct(PengajuanService $pengajuanService)
    {
        $this->pengajuanService = $pengajuanService;
    }

    public function store(StorePengajuanRequest $request)
    {
        $data = $request->validated();
        $this->pengajuanService->createPengajuan($data);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function index()
    {
        $pengajuans = $this->pengajuanService->getAllPengajuan();

        return view('pengajuan.index', compact('pengajuans'));
    }

    public function updateStatus(Pengajuan $pengajuan, string $status)
    {
        abort_unless(in_array($status, ['setuju', 'tolak'], true), 404);

        $this->pengajuanService->updateStatusPengajuan($pengajuan, $status);

        return redirect()->route('pengajuan.index')->with(
            'success',
            $status === 'setuju'
                ? 'Pengajuan berhasil disetujui.'
                : 'Pengajuan berhasil ditolak.'
        );
    }

    public function detail(Pengajuan $pengajuan)
    {
        $pengajuan = $this->pengajuanService->getPengajuanById($pengajuan);
        return view('pengajuan.detail', compact('pengajuan'));
    }

    public function update(UpdatePengajuanRequest $request, Pengajuan $pengajuan)
    {
        $this->pengajuanService->updatePengajuan($pengajuan, $request->validated());

        return redirect()->route('pengajuan.detail', $pengajuan)
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $this->pengajuanService->deletePengajuan($pengajuan);

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}
