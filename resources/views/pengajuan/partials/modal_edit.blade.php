<div
    x-data="formTagihan({
        nominalPengajuan: '{{ $pengajuan->nominal_pengajuan }}',
        pendapatanPerBulan: '{{ $pengajuan->customer->pendapatan_per_bulan }}',
        tenor: '{{ $pengajuan->tenor }}'
    })"
    x-init="calculateInstallment()"
    x-cloak
    x-show="showModalEdit"
    x-trap.noscroll="showModalEdit"
    @keydown.escape.window="showModalEdit = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-edit-title">
    <div
        x-show="showModalEdit"
        x-transition:enter="transition-opacity ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="showModalEdit = false"
        class="fixed inset-0 bg-black/40"></div>

    <div
        x-show="showModalEdit"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-lg bg-white shadow-xl">
        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <div>
                <h2 id="modal-edit-title" class="font-semibold text-slate-900">Edit Pengajuan</h2>
                <p class="mt-0.5 text-xs text-slate-500">Perbarui data pengajuan dan detail pinjaman.</p>
            </div>
            <button type="button" @click="showModalEdit = false" class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form action="{{ route('pengajuan.update', $pengajuan) }}" method="POST" class="space-y-6 px-5 py-5">
            @csrf
            @method('PUT')

            <div>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-slate-900">Data Nasabah</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Identitas nasabah tidak dapat diubah.</p>
                </div>
                <label for="edit_nama_lengkap" class="mb-1.5 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                <input type="text" id="edit_nama_lengkap" value="{{ $pengajuan->customer->nama_lengkap }}" disabled class="w-full cursor-not-allowed rounded-md border border-slate-300 bg-slate-100 p-2 text-sm text-slate-500">
                <input type="hidden" name="nama_lengkap" value="{{ $pengajuan->customer->nama_lengkap }}">
            </div>

            <div>
                <label for="edit_pendapatan_per_bulan" class="mb-1.5 block text-sm font-medium text-slate-700">Pendapatan Per Bulan</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">Rp</span>
                    <input type="text" id="edit_pendapatan_per_bulan" x-model="pendapatanPerBulanDisplay" @input="updatePendapatan($event.target.value)" disabled inputmode="numeric" class="w-full cursor-not-allowed bg-slate-100 rounded-md border border-slate-300 p-2 pl-10 text-sm focus:border-slate-500 focus:ring-slate-500 text-slate-500">
                    <input type="hidden" name="pendapatan_per_bulan" :value="pendapatanPerBulan">
                </div>
                <p class="mt-1.5 text-xs text-slate-400">Pendapatan minimal Rp 1.000.000.</p>
            </div>

            <div class="border-t border-slate-200"></div>

            <div>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-slate-900">Detail Pinjaman</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Perbarui jenis, nominal, dan jangka waktu pinjaman.</p>
                </div>
                <label for="edit_tipe_pengajuan" class="mb-1.5 block text-sm font-medium text-slate-700">Tipe Pengajuan</label>
                <select id="edit_tipe_pengajuan" name="tipe_pengajuan" required class="w-full rounded-md border border-slate-300 p-2 text-sm focus:border-slate-500 focus:ring-slate-500">
                    @foreach (['Sepeda Motor', 'Mobil', 'Multiguna'] as $tipe)
                        <option value="{{ $tipe }}" @selected($pengajuan->tipe_pengajuan === $tipe)>{{ $tipe }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="edit_nominal_pengajuan" class="mb-1.5 block text-sm font-medium text-slate-700">Nominal Pengajuan</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">Rp</span>
                        <input type="text" id="edit_nominal_pengajuan" x-model="nominalPengajuanDisplay" @input="updateNominal($event.target.value)" required inputmode="numeric" class="w-full rounded-md border border-slate-300 p-2 pl-10 text-sm focus:border-slate-500 focus:ring-slate-500">
                        <input type="hidden" name="nominal_pengajuan" :value="nominalPengajuan">
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Maksimal pengajuan Rp 200.000.000.</p>
                </div>
                <div>
                    <label for="edit_tenor" class="mb-1.5 block text-sm font-medium text-slate-700">Tenor</label>
                    <div class="relative">
                        <input type="number" id="edit_tenor" name="tenor" x-model="tenor" @input="calculateInstallment()" required min="1" max="24" inputmode="numeric" class="w-full rounded-md border border-slate-300 p-2 pr-16 text-sm focus:border-slate-500 focus:ring-slate-500">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">bulan</span>
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Maksimal tenor 24 bulan.</p>
                </div>
            </div>

            <div x-show="estimasiTagihan > 0" x-transition class="rounded-md border border-slate-200 bg-slate-50 px-4 py-3">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Estimasi Tagihan Per Bulan</p>
                        <p class="mt-1 text-lg font-semibold text-slate-900" x-text="formatRupiah(estimasiTagihan)"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400">Berdasarkan</p>
                        <p class="text-xs text-slate-500"><span x-text="formatRupiah(nominalPengajuan)"></span> / <span x-text="tenor"></span> bulan</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200"></div>

            <div>
                <label for="edit_catatan" class="mb-1.5 block text-sm font-medium text-slate-700">Catatan</label>
                <textarea id="edit_catatan" name="catatan" rows="3" class="w-full rounded-md border border-slate-300 p-2 text-sm focus:border-slate-500 focus:ring-slate-500">{{ $pengajuan->catatan }}</textarea>
            </div>

            <div class="flex justify-end gap-2 border-t border-slate-200 pt-4">
                <button type="button" @click="showModalEdit = false" class="rounded-md px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-md bg-yellow-500 px-4 py-2 text-sm font-medium text-white hover:bg-yellow-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
