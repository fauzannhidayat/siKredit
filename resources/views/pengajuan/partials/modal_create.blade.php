
<div
    x-data="formTagihan({
        nominalPengajuan: '{{ old('nominal_pengajuan') }}',
        pendapatanPerBulan: '{{ old('pendapatan_per_bulan') }}'
    })" 
    @customer-found.window="updatePendapatan(String($event.detail.pendapatan_per_bulan))"
    x-cloak
    x-show="showModalCreate"
    x-trap.noscroll="showModalCreate"
    @keydown.escape.window="showModalCreate = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-create-title">

    <div
        x-show="showModalCreate"
        x-transition:enter="transition-opacity ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="showModalCreate = false"
        class="fixed inset-0 bg-black/40">
    </div>

    <div
        x-show="showModalCreate"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 sticky top-0 bg-white z-10">
            <div>
                <h2
                    id="modal-create-title"
                    class="font-semibold text-slate-900">
                    Tambah Pengajuan
                </h2>

                <p class="mt-0.5 text-xs text-slate-500">
                    Lengkapi data nasabah dan detail pinjaman.
                </p>
            </div>

            <button
                @click="showModalCreate = false"
                type="button"
                class="p-1.5 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition"
                aria-label="Tutup">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form
            action="{{ route('pengajuan.store') }}"
            method="POST"
            class="px-5 py-5 space-y-6">

            @csrf

            <div>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-slate-900">
                        Data Nasabah
                    </h3>

                    <p class="text-xs text-slate-500 mt-0.5">
                        Masukkan informasi dasar nasabah.
                    </p>
                </div>

                <div class="space-y-4">

                    {{-- Nama Lengkap --}}
                    <div
                        x-data="customerSearch({
                            nama: '{{ old('nama_lengkap') }}',
                            searchUrl: '{{ route('customer.search') }}'
                        })"
                        @click.outside="showDropdown = false"
                        class="relative">
 
                        <label
                            for="nama_lengkap"
                            class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>
 
                        <div class="relative">
                            <input
                                type="text"
                                id="nama_lengkap"
                                name="nama_lengkap"
                                x-model="nama"
                                @input.debounce.400ms="search()"
                                @focus="if (results.length > 0) showDropdown = true"
                                required
                                autocomplete="off"
                                class="w-full rounded-md border p-2 pr-9 border-slate-300 text-sm
                                    focus:border-slate-500 focus:ring-slate-500
                                    @error('nama_lengkap') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Contoh: Budi Santoso">
 
                            {{-- Loading indicator --}}
                            <svg
                                x-show="loading"
                                x-cloak
                                class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 animate-spin text-slate-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
 
                            {{-- Ikon customer sudah dipilih dari dropdown --}}
                            <svg
                                x-show="!loading && selectedCustomerId"
                                x-cloak
                                class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-green-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
 
                        {{-- Dropdown hasil pencarian --}}
                        <ul
                            x-show="showDropdown && results.length > 0"
                            x-cloak
                            x-transition
                            class="absolute z-20 mt-1 w-full max-h-56 overflow-y-auto rounded-md border border-slate-200 bg-white text-sm shadow-lg">
 
                            <template x-for="customer in results" :key="customer.id">
                                <li
                                    @click="selectCustomer(customer)"
                                    class="flex items-center justify-between gap-3 px-3 py-2 cursor-pointer hover:bg-slate-50">
                                    <span class="font-medium text-slate-800" x-text="customer.nama_lengkap"></span>
                                    <span class="text-xs text-slate-400" x-text="formatRupiahShort(customer.pendapatan_per_bulan)"></span>
                                </li>
                            </template>
                        </ul>
 
                        <p x-show="!loading && selectedCustomerId" x-cloak class="mt-1.5 text-xs text-green-600">
                            Nasabah dipilih &mdash; pendapatan per bulan sudah terisi.
                        </p>
 
                        <p x-show="!loading && !selectedCustomerId && nama.trim().length >= 3 && results.length === 0" x-cloak class="mt-1.5 text-xs text-slate-400">
                            Nasabah baru, silakan isi pendapatan per bulan.
                        </p>
 
                        @error('nama_lengkap')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Pendapatan --}}
                    <div>
                        <label
                            for="pendapatan_per_bulan"
                            class="block text-sm font-medium text-slate-700 mb-1.5">
                            Pendapatan Per Bulan
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                                Rp
                            </span>

                            <input
                                type="text"
                                id="pendapatan_per_bulan"
                                x-model="pendapatanPerBulanDisplay"
                                @input="updatePendapatan($event.target.value)"
                                required
                                inputmode="numeric"
                                class="w-full pl-10 border p-2 rounded-md border-slate-300 text-sm
                                    focus:border-slate-500 focus:ring-slate-500
                                    @error('pendapatan_per_bulan') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="5.000.000">

                            <input type="hidden" name="pendapatan_per_bulan" :value="pendapatanPerBulan">

                        </div>

                        @error('pendapatan_per_bulan')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>


            <div class="border-t border-slate-200"></div>

            <div>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-slate-900">
                        Detail Pinjaman
                    </h3>

                    <p class="text-xs text-slate-500 mt-0.5">
                        Tentukan jenis, nominal, dan jangka waktu pinjaman.
                    </p>
                </div>

                <div class="space-y-4">

                    {{-- Tipe Pengajuan --}}
                    <div>
                        <label
                            for="tipe_pengajuan"
                            class="block text-sm font-medium text-slate-700 mb-1.5">
                            Tipe Pengajuan
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="tipe_pengajuan"
                            name="tipe_pengajuan"
                            required
                            class="w-full rounded-md border p-2 border-slate-300 text-sm
                                focus:border-slate-500 focus:ring-slate-500
                                @error('tipe_pengajuan') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">

                            <option value="" disabled @selected(!old('tipe_pengajuan'))>
                                Pilih tipe pengajuan
                            </option>

                            @foreach (['Sepeda Motor', 'Mobil', 'Multiguna'] as $tipe)
                                <option
                                    value="{{ $tipe }}"
                                    @selected(old('tipe_pengajuan') === $tipe)>
                                    {{ $tipe }}
                                </option>
                            @endforeach
                        </select>

                        @error('tipe_pengajuan')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Nominal & Tenor --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Nominal --}}
                        <div>
                            <label
                                for="nominal_pengajuan"
                                class="block text-sm font-medium text-slate-700 mb-1.5">
                                Nominal Pengajuan
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                                    Rp
                                </span>

                                <input
                                    type="text"
                                    id="nominal_pengajuan"
                                    x-model="nominalPengajuanDisplay"
                                    @input="updateNominal($event.target.value)"
                                    required
                                    inputmode="numeric"
                                    class="w-full pl-10 border p-2 rounded-md border-slate-300 text-sm
                                        focus:border-slate-500 focus:ring-slate-500
                                        @error('nominal_pengajuan') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="50.000.000">

                                <input type="hidden" name="nominal_pengajuan" :value="nominalPengajuan">
                            </div>
                            <p class="mt-1.5 text-xs text-slate-300">
                                    maksimal pengajuan Rp.200.000.000
                            </p>

                            @error('nominal_pengajuan')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Tenor --}}
                        <div>
                            <label
                                for="tenor"
                                class="block text-sm font-medium text-slate-700 mb-1.5">
                                Tenor
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <input
                                    type="number"
                                    id="tenor"
                                    name="tenor"
                                    x-model.number="tenor"
                                    @input="calculateInstallment()"
                                    value="{{ old('tenor') }}"
                                    min="1"
                                    max="24"
                                    required
                                    inputmode="numeric"
                                    class="w-full pr-16 border p-2 rounded-md border-slate-300 text-sm
                                        focus:border-slate-500 focus:ring-slate-500
                                        @error('tenor') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="12">

                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                                    bulan
                                </span>
                            </div>
                            <p class="mt-1.5 text-xs text-slate-300">
                                    maksimal tenor 24 bulan
                            </p>

                            @error('tenor')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        
                    </div>
                    <div
                        x-show="estimasiTagihan > 0"
                        x-transition
                        class="rounded-md border border-slate-200 bg-slate-50 px-4 py-3">

                        <div class="flex items-center justify-between gap-4">

                            <div>
                                <p class="text-xs font-medium text-slate-500">
                                    Estimasi Tagihan Per Bulan
                                </p>

                                <p class="mt-1 text-lg font-semibold text-slate-900"
                                x-text="formatRupiah(estimasiTagihan)">
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-slate-400">
                                    Berdasarkan
                                </p>

                                <p class="text-xs text-slate-500">
                                    <span x-text="formatRupiah(nominalPengajuan)"></span>
                                    /
                                    <span x-text="tenor"></span> bulan
                                </p>
                            </div>

                        </div>

                    </div>

                </div>
            </div>


            <div class="border-t border-slate-200"></div>


            <div>
                <label
                    for="catatan"
                    class="block text-sm font-medium text-slate-700 mb-1.5">
                    Catatan
                    <span class="text-slate-400 font-normal">(opsional)</span>
                </label>

                <textarea
                    id="catatan"
                    name="catatan"
                    rows="3"
                    class="w-full rounded-md border p-2 border-slate-300 text-sm
                        focus:border-slate-500 focus:ring-slate-500
                        @error('catatan') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                    placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>

                @error('catatan')
                    <p class="mt-1.5 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <div class="flex justify-end gap-2 pt-2 sticky bottom-0 bg-white">

                <button
                    @click="showModalCreate = false"
                    type="button"
                    class="px-4 py-2 rounded-md text-sm font-medium text-slate-600
                        hover:bg-slate-100 transition">
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-md text-sm font-medium
                        bg-yellow-500 text-white hover:bg-yellow-300 transition">
                    Simpan Pengajuan
                </button>

            </div>

        </form>
    </div>
</div>

