@extends('layout.app')

@section('title', 'Daftar Pengajuan')

@section('content')
    <div
        x-data="{
            showModalCreate: {{ $errors->any() ? 'true' : 'false' }},
            showModalConfirm: false,
            selectedPengajuan: null,
            confirmStatus: '',
            formatRupiah(value) {
                if (!value) {
                    return 'Rp 0';
                }

                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0,
                }).format(value);
            },
            openConfirm(pengajuan, status) {
                this.selectedPengajuan = pengajuan;
                this.confirmStatus = status;
                this.showModalConfirm = true;
            },
            closeModals() {
                this.showModalDetail = false;
                this.showModalConfirm = false;
                this.selectedPengajuan = null;
            }
        }">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-900">Daftar Pengajuan</h1>

            <button
                @click="showModalCreate = true"
                type="button"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-yellow-400 text-white text-sm font-medium hover:bg-yellow-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengajuan
            </button>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Tipe Pengajuan</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Nominal Pengajuan</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Tenor (Bulan)</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Tagihan Nasabah (/bulan)</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Tanggal Pengajuan</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pengajuans as $i => $p)
                    <tr>
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ $p->customer->nama_lengkap }}</td>
                        <td class="px-4 py-3">{{ $p->tipe_pengajuan }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($p->nominal_pengajuan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $p->tenor }} bulan</td>
                        <td class="px-4 py-3">Rp {{ number_format($p->tagihan_per_bulan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $p->tanggal_pengajuan }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                    @if ($p->status === 'setuju') bg-green-100 text-green-700
                                    @elseif ($p->status === 'tolak') bg-red-100 text-red-700
                                    @else bg-amber-100 text-amber-700 @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($p->status === 'pending')
                                    <button
                                        type="button"
                                        @click="openConfirm(@js([
                                            'id' => $p->id,
                                            'nama_lengkap' => $p->customer->nama_lengkap,
                                        ]), 'setuju')"
                                        class="rounded-md bg-green-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">
                                        Setujui
                                    </button>

                                    <button
                                        type="button"
                                        @click="openConfirm(@js([
                                            'id' => $p->id,
                                            'nama_lengkap' => $p->customer->nama_lengkap,
                                        ]), 'tolak')"
                                        class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                        Tolak
                                    </button>
                                @endif
                                <a
                                    href="{{ route('pengajuan.detail', $p->id) }}"
                                    class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-slate-400">Belum ada data pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('pengajuan.partials.modal_create')
        @include('pengajuan.partials.modal_confirm')

    </div>
@endsection