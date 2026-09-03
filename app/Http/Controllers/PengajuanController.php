<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest;
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
}
