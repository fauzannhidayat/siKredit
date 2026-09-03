<div
    x-cloak
    x-show="showModalDetail"
    x-trap.noscroll="showModalDetail"
    @keydown.escape.window="showModalDetail = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-detail-title">
    <div @click="showModalDetail = false" class="fixed inset-0 bg-black/40"></div>

    <div class="relative max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-lg bg-white shadow-xl">
        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
            <h2 id="modal-detail-title" class="font-semibold text-slate-900">Detail Pengajuan</h2>
            <button type="button" @click="showModalDetail = false" class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">&times;</button>
        </div>

        <div x-show="selectedPengajuan" class="space-y-5 px-5 py-5 text-sm">
            <div>
                <h3 class="mb-3 font-semibold text-slate-900">Data Nasabah</h3>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                    <dt class="text-slate-500">Nama Lengkap</dt>
                    <dd class="font-medium text-slate-900" x-text="selectedPengajuan?.nama_lengkap"></dd>
                    <dt class="text-slate-500">Pendapatan Per Bulan</dt>
                    <dd class="font-medium text-slate-900" x-text="formatRupiah(selectedPengajuan?.pendapatan_per_bulan)"></dd>
                </dl>
            </div>

            <div class="border-t border-slate-200 pt-5">
                <h3 class="mb-3 font-semibold text-slate-900">Detail Pinjaman</h3>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                    <dt class="text-slate-500">Tipe Pengajuan</dt>
                    <dd class="font-medium text-slate-900" x-text="selectedPengajuan?.tipe_pengajuan"></dd>
                    <dt class="text-slate-500">Nominal Pengajuan</dt>
                    <dd class="font-medium text-slate-900" x-text="formatRupiah(selectedPengajuan?.nominal_pengajuan)"></dd>
                    <dt class="text-slate-500">Tenor</dt>
                    <dd class="font-medium text-slate-900"><span x-text="selectedPengajuan?.tenor"></span> bulan</dd>
                    <dt class="text-slate-500">Tagihan Per Bulan</dt>
                    <dd class="font-medium text-slate-900" x-text="formatRupiah(selectedPengajuan?.tagihan_per_bulan)"></dd>
                    <dt class="text-slate-500">Tanggal Pengajuan</dt>
                    <dd class="font-medium text-slate-900" x-text="selectedPengajuan?.tanggal_pengajuan"></dd>
                    <dt class="text-slate-500">Status</dt>
                   <dd
                        class=" w-20 text-center rounded-full px-2 py-1 text-xs font-medium capitalize"
                        :class="{
                            'bg-green-100 text-green-700': selectedPengajuan?.status === 'setuju',
                            'bg-red-100 text-red-700': selectedPengajuan?.status === 'tolak',
                            'bg-amber-100 text-amber-700': selectedPengajuan?.status === 'pending',
                        }"
                        x-text="selectedPengajuan?.status">
                    </dd>
                </dl>
            </div>

            <div x-show="selectedPengajuan?.catatan" class="border-t border-slate-200 pt-5">
                <h3 class="mb-2 font-semibold text-slate-900">Catatan</h3>
                <p class="whitespace-pre-line text-slate-600" x-text="selectedPengajuan?.catatan"></p>
            </div>
        </div>
    </div>
</div>