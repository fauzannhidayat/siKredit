<div
    x-cloak
    x-show="showModalConfirm"
    x-trap.noscroll="showModalConfirm"
    @keydown.escape.window="showModalConfirm = false"
    class="fixed inset-0 z-[60] flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-confirm-title">
    <div @click="showModalConfirm = false" class="fixed inset-0 bg-black/40"></div>

    <div class="relative w-full max-w-md rounded-lg bg-white p-5 shadow-xl">
        <h2 id="modal-confirm-title" class="font-semibold text-slate-900">
            <span x-show="confirmStatus === 'setuju'">Setujui Pengajuan?</span>
            <span x-show="confirmStatus === 'tolak'">Tolak Pengajuan?</span>
        </h2>
        <p class="mt-2 text-sm text-slate-600">
            Anda yakin ingin <span class="font-medium" x-text="confirmStatus === 'setuju' ? 'menyetujui' : 'menolak'"></span>
            pengajuan atas nama <span class="font-medium text-slate-900" x-text="selectedPengajuan?.nama_lengkap"></span>?
        </p>

        <form
            method="POST"
            class="mt-5 flex justify-end gap-2"
            x-bind:action="'{{ url('/pengajuan') }}/' + selectedPengajuan?.id + '/status/' + confirmStatus">
            @csrf
            @method('PATCH')
            <button type="button" @click="showModalConfirm = false" class="rounded-md px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">Batal</button>
            <button
                type="submit"
                class="rounded-md px-4 py-2 text-sm font-medium text-white"
                :class="confirmStatus === 'setuju' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'">
                Konfirmasi
            </button>
        </form>
    </div>
</div>