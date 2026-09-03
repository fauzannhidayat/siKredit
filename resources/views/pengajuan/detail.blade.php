@extends('layout.app')

@section('title', 'Detail Pengajuan')

@section('content')
    <div
        x-data="{ showModalEdit: false, showModalDelete: false }"
        class="bg-white border border-slate-200 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-900 mb-4">Detail Pengajuan</h1>
            <a
                href="{{ route('pengajuan.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 transition mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Pengajuan
            </a>
        </div>
        

        <div class="space-y-5 text-sm">
            <div>
                <h3 class="mb-3 font-semibold text-slate-900">Data Nasabah</h3>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                    <dt class="text-slate-500">Nama Lengkap</dt>
                    <dd class="font-medium text-slate-900">{{ $pengajuan->customer->nama_lengkap }}</dd>
                    <dt class="text-slate-500">Pendapatan Per Bulan</dt>
                    <dd class="font-medium text-slate-900">{{ 'Rp ' . number_format($pengajuan->customer->pendapatan_per_bulan, 0, ',', '.') }}</dd>
                </dl>
            </div>

            <div class="border-t border-slate-200 pt-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="mb-3 font-semibold text-slate-900">Detail Pinjaman</h3>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="showModalEdit = true" class="rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Edit pengajuan" title="Edit pengajuan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z" />
                            </svg>
                        </button>
                        <button type="button" @click="showModalDelete = true" class="rounded-md p-2 text-red-500 hover:bg-red-50 hover:text-red-700" aria-label="Hapus pengajuan" title="Hapus pengajuan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10" />
                            </svg>
                        </button>
                    </div>

                </div>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                    <dt class="text-slate-500">Tipe Pengajuan</dt>
                    <dd class="font-medium text-slate-900">{{ $pengajuan->tipe_pengajuan }}</dd>
                    <dt class="text-slate-500">Nominal Pengajuan</dt>
                    <dd class="font-medium text-slate-900">{{ 'Rp ' . number_format($pengajuan->nominal_pengajuan, 0, ',', '.') }}</dd>
                    <dt class="text-slate-500">Tenor</dt>
                    <dd class="font-medium text-slate-900">{{ $pengajuan->tenor }} bulan</dd>
                    <dt class="text-slate-500">Tagihan Per Bulan</dt>
                    <dd class="font-medium text-slate-900">{{ 'Rp ' . number_format($pengajuan->tagihan_per_bulan, 0, ',', '.') }}</dd>
                    <dt class="text-slate-500">Tanggal Pengajuan</dt>
                    <dd class="font-medium text-slate-900">{{ $pengajuan->tanggal_pengajuan }}</dd>
                    <dt class="text-slate-500">Status</dt>
                    <dd
                        class=" w-20 text-center rounded-full px-2 py-1 text-xs font-medium capitalize
                            @if ($pengajuan->status === 'setuju') bg-green-100 text-green-700
                            @elseif ($pengajuan->status === 'tolak') bg-red-100 text-red-700
                            @else bg-amber-100 text-amber-700 @endif">
                        {{ $pengajuan->status }}
                    </dd>
                </dl>
            </div>
            <div @if (!$pengajuan->catatan) hidden @endif class="border-t border-slate-200 pt-5">
                <h3 class="mb-2 font-semibold text-slate-900">Catatan</h3>
                <p class="whitespace-pre-line text-slate-600">{{ $pengajuan->catatan }}</p>
            </div>
        </div>

        @include('pengajuan.partials.modal_edit')

        <div x-cloak x-show="showModalDelete" x-trap.noscroll="showModalDelete" @keydown.escape.window="showModalDelete = false" class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modal-delete-title">
            <div @click="showModalDelete = false" class="fixed inset-0 bg-black/40"></div>
            <div class="relative w-full max-w-md rounded-lg bg-white p-5 shadow-xl">
                <h2 id="modal-delete-title" class="font-semibold text-slate-900">Hapus Pengajuan?</h2>
                <p class="mt-2 text-sm text-slate-600">Data pengajuan ini akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                <form action="{{ route('pengajuan.destroy', $pengajuan) }}" method="POST" class="mt-5 flex justify-end gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="showModalDelete = false" class="rounded-md px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Batal</button>
                    <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
